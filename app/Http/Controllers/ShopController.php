<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class ShopController extends Controller
{
    /**
     * Display the shop page with all ebooks.
     */
    public function index(): View
    {
        $ebooks = Ebook::with('category')
            ->whereNotNull('file')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('shop.index', compact('ebooks'));
    }

    /**
     * Show checkout page with cart items.
     */
    public function checkout(): View
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
        Stripe::setApiKey(config('cashier.secret') ?: env('STRIPE_SECRET'));

        // Create PaymentIntent for the total amount
        try {
            $paymentIntent = PaymentIntent::create([
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
    public function processCheckout(Request $request)
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
            Stripe::setApiKey(config('cashier.secret') ?: env('STRIPE_SECRET'));

            // Retrieve the PaymentIntent
            $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);

            // Check if payment was successful
            if ($paymentIntent->status !== 'succeeded') {
                return response()->json([
                    'success' => false,
                    'error' => 'Payment was not successful. Please try again.',
                ], 400);
            }

            // Create purchase records for each ebook in cart
            $purchases = [];
            foreach ($cart as $ebookId) {
                $ebook = Ebook::find($ebookId);
                if ($ebook) {
                    $purchases[] = Purchase::create([
                        'name' => $request->name,
                        'phone' => $request->phone,
                        'ebook_id' => $ebook->id,
                        'stripe_payment_intent_id' => $paymentIntent->id,
                        'email' => $request->email,
                        'amount' => $ebook->price,
                        'currency' => 'usd',
                        'status' => 'completed',
                        'completed_at' => now(),
                    ]);
                }
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
}
