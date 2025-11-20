<?php

namespace App\Services;

use App\Services\Contracts\StripePaymentIntentServiceInterface;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripePaymentIntentService implements StripePaymentIntentServiceInterface
{
    /**
     * Set the Stripe API key.
     */
    public function setApiKey(string $apiKey): void
    {
        Stripe::setApiKey($apiKey);
    }

    /**
     * Create a new PaymentIntent.
     *
     *
     * @throws ApiErrorException
     */
    public function create(array $params): PaymentIntent
    {
        return PaymentIntent::create($params);
    }

    /**
     * Retrieve a PaymentIntent by ID.
     *
     *
     * @throws ApiErrorException
     */
    public function retrieve(string $paymentIntentId): PaymentIntent
    {
        return PaymentIntent::retrieve($paymentIntentId);
    }
}
