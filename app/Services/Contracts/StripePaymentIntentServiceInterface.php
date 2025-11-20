<?php

namespace App\Services\Contracts;

use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;

interface StripePaymentIntentServiceInterface
{
    /**
     * Set the Stripe API key.
     */
    public function setApiKey(string $apiKey): void;

    /**
     * Create a new PaymentIntent.
     *
     *
     * @throws ApiErrorException
     */
    public function create(array $params): PaymentIntent;

    /**
     * Retrieve a PaymentIntent by ID.
     *
     *
     * @throws ApiErrorException
     */
    public function retrieve(string $paymentIntentId): PaymentIntent;
}
