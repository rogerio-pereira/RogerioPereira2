<?php

namespace App\Services;

use App\Services\Contracts\StripeWebhookServiceInterface;
use Stripe\Event;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeWebhookService implements StripeWebhookServiceInterface
{
    /**
     * Construct and verify a Stripe webhook event.
     *
     *
     * @throws SignatureVerificationException
     */
    public function constructEvent(string $payload, string $sigHeader, string $webhookSecret): Event
    {
        Stripe::setApiKey(config('cashier.secret') ?: env('STRIPE_SECRET'));

        return Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
    }
}
