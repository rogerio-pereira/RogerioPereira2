<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Ebook;
use App\Models\Purchase;
use App\Services\Contracts\StripePaymentIntentServiceInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Stripe\Exception\ApiErrorException;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Shop Controller
 *
 * This controller uses dependency injection for Stripe PaymentIntent service,
 * allowing for easy mocking in tests.
 */
class ShopController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private readonly StripePaymentIntentServiceInterface $paymentIntentService
    ) {
        //
    }

    /**
     * Display the shop page with all ebooks.
     */
    public function index(?string $category = null): View
    {
        $query = Ebook::with('category')
            ->whereNotNull('file');

        if ($category) {
            $categoryModel = Category::all()
                ->first(function (Category $cat) use ($category): bool {
                    return Str::slug($cat->name) === $category;
                });

            if ($categoryModel) {
                $query->where('category_id', $categoryModel->id);
            }
        }

        $ebooks = $query->orderBy('created_at', 'desc')
            ->get();

        $categories = Category::has('ebooks')
            ->whereHas('ebooks', function (Builder $query): void {
                $query->whereNotNull('file');
            })
            ->orderBy('name')
            ->get();

        return view('shop.index', compact('ebooks', 'categories', 'category'));
    }

    /**
     * Show checkout page with cart items.
     */
    public function checkout(): View|\Illuminate\Http\RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', __('Your cart is empty.'));
        }

        $ebooks = [];
        $total = 0;

        foreach ($cart as $ebookId) {
            $ebook = Ebook::with('category')->find($ebookId);
            if ($ebook) {
                $ebooks[] = $ebook;
                $total += $ebook->price;
            }
        }

        // Set Stripe API key
        $this->paymentIntentService->setApiKey(config('cashier.secret') ?: env('STRIPE_SECRET'));

        // Create PaymentIntent for the total amount
        try {
            $paymentIntent = $this->paymentIntentService->create([
                'amount' => (int) ($total * 100), // Convert to cents
                'currency' => 'usd',
                'metadata' => [
                    'cart_items' => json_encode(array_keys($cart)),
                ],
            ]);

            $clientSecret = $paymentIntent->client_secret;
        } catch (ApiErrorException $e) {
            Log::error('Stripe PaymentIntent creation error: '.$e->getMessage());
            $clientSecret = null;
        }

        return view('shop.checkout', compact('ebooks', 'total', 'clientSecret'));
    }

    /**
     * Process payment for cart items using Stripe PaymentIntent.
     */
    public function processCheckout(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'payment_intent_id' => 'required|string',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'error' => 'Your cart is empty.',
            ], 400);
        }

        try {
            $this->paymentIntentService->setApiKey(config('cashier.secret') ?: env('STRIPE_SECRET'));

            // Retrieve the PaymentIntent
            $paymentIntent = $this->paymentIntentService->retrieve($request->payment_intent_id);

            // Check if payment was successful
            if ($paymentIntent->status !== 'succeeded') {
                return response()->json([
                    'success' => false,
                    'error' => 'Payment was not successful. Please try again.',
                ], 400);
            }

            // Load ebooks with categories
            $ebooks = Ebook::with('category')
                ->whereIn('id', $cart)
                ->get();

            // Determine which category fields to set based on purchased ebooks
            $categoryFields = [
                'marketing' => false,
                'automation' => false,
                'software_development' => false,
            ];

            foreach ($ebooks as $ebook) {
                if ($ebook->category) {
                    $categoryName = $ebook->category->name;
                    $categoryName = Str::slug($categoryName, '_');
                    $categoryFields[$categoryName] = true;
                }
            }

            // Create or update contact
            $contact = Contact::updateOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'phone' => $request->phone,
                ]
            );

            // Update buyer and category fields (merge with existing values)
            $contact->update([
                'buyer' => true,
                'marketing' => $contact->marketing || $categoryFields['marketing'],
                'automation' => $contact->automation || $categoryFields['automation'],
                'software_development' => $contact->software_development || $categoryFields['software_development'],
            ]);

            // Create purchase records for each ebook in cart
            $purchases = [];
            foreach ($ebooks as $ebook) {
                $purchases[] = Purchase::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'ebook_id' => $ebook->id,
                    'stripe_payment_intent_id' => $paymentIntent->id,
                    'amount' => $ebook->price,
                    'currency' => 'usd',
                    'status' => 'completed',
                    'completed_at' => now(),
                ]);

                // Increment download count for the ebook
                $ebook->increment('downloads');
            }

            // Clear the cart
            session()->forget('cart');

            // Redirect to success page with first purchase
            return response()->json([
                'success' => true,
                'redirect_url' => route('shop.success', ['purchase' => $purchases[0]->id]),
            ]);
        } catch (ApiErrorException $e) {
            Log::error('Stripe payment error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Payment processing failed. Please try again.',
            ], 500);
        }
    }

    /**
     * Handle successful payment.
     */
    public function success(Request $request, ?Purchase $purchase = null): View
    {
        if (! $purchase) {
            return view('shop.success', [
                'purchase' => null,
                'purchases' => [],
                'total' => 0,
            ]);
        }

        $purchase->load('ebook');

        // Get all purchases with the same payment intent (same transaction)
        $purchases = Purchase::where('stripe_payment_intent_id', $purchase->stripe_payment_intent_id)
            ->where('email', $purchase->email)
            ->with('ebook')
            ->get();

        $total = $purchases->sum('amount');

        return view('shop.success', [
            'purchase' => $purchase,
            'purchases' => $purchases,
            'total' => $total,
        ]);
    }

    /**
     * Download ebook with confirmation hash.
     */
    public function downloadEbook(Request $request, Ebook $ebook, ?string $confirmation = null): View|RedirectResponse|StreamedResponse
    {
        // Get confirmation from URL parameter or query string
        $confirmation = $confirmation ?? $request->query('confirmation');

        // If no confirmation hash provided, show form to request it
        if (! $confirmation) {
            return view('shop.download-confirmation', compact('ebook'));
        }

        // Find purchase with matching confirmation hash and ebook
        $purchase = Purchase::where('ebook_id', $ebook->id)
            ->where('confirmation_hash', $confirmation)
            ->where('status', 'completed')
            ->first();

        if (! $purchase) {
            return redirect()->route('ebooks.download', ['ebook' => $ebook->id])
                ->with('error', __('Invalid confirmation hash. Please check your email for the correct download link.'));
        }

        // Check if file exists
        if (! $ebook->file || ! Storage::exists($ebook->file)) {
            abort(404, __('File not found.'));
        }

        // Download the file
        return Storage::download($ebook->file);
    }
}
