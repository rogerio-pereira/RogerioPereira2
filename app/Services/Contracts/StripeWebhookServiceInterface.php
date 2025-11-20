<?php

namespace App\Services\Contracts;

use Stripe\Event;
use Stripe\Exception\SignatureVerificationException;

interface StripeWebhookServiceInterface
{
    /**
     * Construct and verify a Stripe webhook event.
     *
     * @param  string  $payload
     * @param  string  $sigHeader
     * @param  string  $webhookSecret
     * @return Event
     *
     * @throws SignatureVerificationException
     */
    public function constructEvent(string $payload, string $sigHeader, string $webhookSecret): Event;
}
