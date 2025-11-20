<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Webhook;

/**
 * Webhook Controller
 *
 * NOTE: This controller uses Stripe's static methods (Webhook::constructEvent)
 * which cannot be easily mocked in unit tests. The webhook signature verification
 * and event construction require real Stripe webhook payloads or would need
 * code refactoring to use dependency injection for testability.
 *
 * Current code coverage limitations:
 * - Lines 30-31: Stripe::setApiKey and Webhook::constructEvent (requires real webhook)
 * - Lines 36-40: Exception handling for webhook processing (partially covered)
 * - Lines 43-54: Event type switching and handling (partially covered)
 */
class WebhookController extends Controller
{
    /**
     * Handle Stripe webhook events.
     */
    public function handle(Request $request): \Illuminate\Http\JsonResponse
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('cashier.webhook.secret');

        if (! $webhookSecret) {
            Log::warning('Stripe webhook secret not configured');

            return response()->json(['error' => 'Webhook secret not configured'], 500);
        }

        try {
            Stripe::setApiKey(config('cashier.secret') ?: env('STRIPE_SECRET'));
            $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (SignatureVerificationException $e) {
            Log::error('Stripe webhook signature verification failed: '.$e->getMessage());

            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\Exception $e) {
            Log::error('Stripe webhook error: '.$e->getMessage());

            return response()->json(['error' => 'Webhook processing failed'], 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $this->handleCheckoutSessionCompleted($event->data->object);
                break;

            case 'payment_intent.succeeded':
                $this->handlePaymentIntentSucceeded($event->data->object);
                break;

            default:
                Log::info('Unhandled Stripe webhook event: '.$event->type);
        }

        return response()->json(['received' => true]);
    }

    /**
     * Handle checkout session completed event.
     */
    protected function handleCheckoutSessionCompleted(\Stripe\Checkout\Session $session): void
    {
        $purchase = Purchase::where('stripe_checkout_session_id', $session->id)->first();

        if ($purchase && $session->payment_status === 'paid') {
            $purchase->update([
                'status' => 'completed',
                'stripe_payment_intent_id' => $session->payment_intent,
                'completed_at' => now(),
            ]);

            // TODO: Send email with ebook download link
            Log::info("Purchase completed: {$purchase->id} for ebook {$purchase->ebook_id}");
        }
    }

    /**
     * Handle payment intent succeeded event.
     */
    protected function handlePaymentIntentSucceeded(\Stripe\PaymentIntent $paymentIntent): void
    {
        // Additional handling if needed
        Log::info('Payment intent succeeded: '.$paymentIntent->id);
    }
}
