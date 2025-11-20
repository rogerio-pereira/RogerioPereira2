<?php

namespace Tests\Feature\App\Http\Controllers\Webhook;

use App\Models\Category;
use App\Models\Ebook;
use App\Models\Purchase;
use App\Services\Contracts\StripeWebhookServiceInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Stripe\Event;
use Stripe\Exception\SignatureVerificationException;

test('webhook returns error when secret is not configured', function () {
    $originalSecret = config('cashier.webhook.secret');
    Config::set('cashier.webhook.secret', null);

    $response = $this->postJson(route('stripe.webhook'), [], [
        'Stripe-Signature' => 'test-signature',
    ]);

    $response->assertStatus(500);
    $response->assertJson(['error' => 'Webhook secret not configured']);

    Config::set('cashier.webhook.secret', $originalSecret);
});

test('webhook returns error when signature is invalid', function () {
    Log::spy();

    Config::set('cashier.webhook.secret', 'test-secret');

    $mockService = $this->mock(StripeWebhookServiceInterface::class);
    $mockService->shouldReceive('constructEvent')
        ->once()
        ->andThrow(new SignatureVerificationException('Invalid signature', 400));

    $this->app->instance(StripeWebhookServiceInterface::class, $mockService);

    $response = $this->postJson(route('stripe.webhook'), [
        'type' => 'checkout.session.completed',
    ], [
        'Stripe-Signature' => 'invalid-signature',
    ]);

    $response->assertStatus(400);
    $response->assertJson(['error' => 'Invalid signature']);

    Log::shouldHaveReceived('error')
        ->once()
        ->with(\Mockery::pattern('/Stripe webhook signature verification failed/'));

    Config::set('cashier.webhook.secret', null);
});

test('webhook processes payment_intent.succeeded event', function () {
    Log::spy();

    Config::set('cashier.webhook.secret', 'test-secret');

    $paymentIntent = new \Stripe\PaymentIntent('pi_test_123');
    $event = new Event('evt_test_123');
    $reflectionEvent = new \ReflectionClass($event);
    $eventValuesProperty = $reflectionEvent->getProperty('_values');
    $eventValuesProperty->setAccessible(true);
    $eventValues = $eventValuesProperty->getValue($event);
    $eventValues['type'] = 'payment_intent.succeeded';
    $eventValues['data'] = (object) ['object' => $paymentIntent];
    $eventValuesProperty->setValue($event, $eventValues);

    $mockService = $this->mock(StripeWebhookServiceInterface::class);
    $mockService->shouldReceive('constructEvent')
        ->once()
        ->andReturn($event);

    $this->app->instance(StripeWebhookServiceInterface::class, $mockService);

    $response = $this->postJson(route('stripe.webhook'), [
        'type' => 'payment_intent.succeeded',
    ], [
        'Stripe-Signature' => 'test-signature',
    ]);

    $response->assertStatus(200);
    $response->assertJson(['received' => true]);

    Log::shouldHaveReceived('info')
        ->once()
        ->with('Payment intent succeeded: pi_test_123');

    Config::set('cashier.webhook.secret', null);
});

test('handleCheckoutSessionCompleted updates purchase when payment is paid', function () {
    Log::spy();

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $purchase = Purchase::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '1234567890',
        'ebook_id' => $ebook->id,
        'stripe_checkout_session_id' => 'cs_test_123',
        'amount' => 29.99,
        'currency' => 'usd',
        'status' => 'pending',
    ]);

    // Create Stripe Checkout Session and set properties using reflection
    $session = new \Stripe\Checkout\Session('cs_test_123');

    // Use reflection to access the _values property and set additional properties
    $reflectionSession = new \ReflectionClass($session);
    $valuesProperty = $reflectionSession->getProperty('_values');
    $valuesProperty->setAccessible(true);
    $values = $valuesProperty->getValue($session);
    $values['payment_status'] = 'paid';
    $values['payment_intent'] = 'pi_test_123';
    $valuesProperty->setValue($session, $values);

    // Use reflection to call protected method
    $mockService = $this->mock(StripeWebhookServiceInterface::class);
    $controller = new \App\Http\Controllers\WebhookController($mockService);
    $reflection = new \ReflectionClass($controller);
    $method = $reflection->getMethod('handleCheckoutSessionCompleted');
    $method->setAccessible(true);
    $method->invoke($controller, $session);

    $purchase->refresh();

    $this->assertEquals('completed', $purchase->status);
    $this->assertEquals('pi_test_123', $purchase->stripe_payment_intent_id);
    $this->assertNotNull($purchase->completed_at);

    // Verify Log::info was called (line 74)
    Log::shouldHaveReceived('info')
        ->once()
        ->with(\Mockery::pattern('/Purchase completed:/'));
});

test('handleCheckoutSessionCompleted does not update purchase when payment is not paid', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $purchase = Purchase::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '1234567890',
        'ebook_id' => $ebook->id,
        'stripe_checkout_session_id' => 'cs_test_123',
        'amount' => 29.99,
        'currency' => 'usd',
        'status' => 'pending',
    ]);

    // Create Stripe Checkout Session with unpaid status
    $session = new \Stripe\Checkout\Session('cs_test_123');

    $reflectionSession = new \ReflectionClass($session);
    $valuesProperty = $reflectionSession->getProperty('_values');
    $valuesProperty->setAccessible(true);
    $values = $valuesProperty->getValue($session);
    $values['payment_status'] = 'unpaid';
    $values['payment_intent'] = 'pi_test_123';
    $valuesProperty->setValue($session, $values);

    // Use reflection to call protected method
    $mockService = $this->mock(StripeWebhookServiceInterface::class);
    $controller = new \App\Http\Controllers\WebhookController($mockService);
    $reflection = new \ReflectionClass($controller);
    $method = $reflection->getMethod('handleCheckoutSessionCompleted');
    $method->setAccessible(true);
    $method->invoke($controller, $session);

    $purchase->refresh();

    $this->assertEquals('pending', $purchase->status);
    $this->assertNull($purchase->stripe_payment_intent_id);
    $this->assertNull($purchase->completed_at);
});

test('handleCheckoutSessionCompleted does not update when purchase does not exist', function () {
    // Create Stripe Checkout Session
    $session = new \Stripe\Checkout\Session('cs_nonexistent');

    $reflectionSession = new \ReflectionClass($session);
    $valuesProperty = $reflectionSession->getProperty('_values');
    $valuesProperty->setAccessible(true);
    $values = $valuesProperty->getValue($session);
    $values['payment_status'] = 'paid';
    $values['payment_intent'] = 'pi_test_123';
    $valuesProperty->setValue($session, $values);

    // Use reflection to call protected method
    $mockService = $this->mock(StripeWebhookServiceInterface::class);
    $controller = new \App\Http\Controllers\WebhookController($mockService);
    $reflection = new \ReflectionClass($controller);
    $method = $reflection->getMethod('handleCheckoutSessionCompleted');
    $method->setAccessible(true);
    $method->invoke($controller, $session);

    // Should not throw exception
    $this->assertTrue(true);
});

test('handlePaymentIntentSucceeded logs the event', function () {
    Log::spy();

    // Create Stripe PaymentIntent
    $paymentIntent = new \Stripe\PaymentIntent('pi_test_123');

    // Use reflection to call protected method
    $mockService = $this->mock(StripeWebhookServiceInterface::class);
    $controller = new \App\Http\Controllers\WebhookController($mockService);
    $reflection = new \ReflectionClass($controller);
    $method = $reflection->getMethod('handlePaymentIntentSucceeded');
    $method->setAccessible(true);

    $method->invoke($controller, $paymentIntent);

    Log::shouldHaveReceived('info')
        ->once()
        ->with('Payment intent succeeded: pi_test_123');
});

test('webhook handles unhandled event types', function () {
    Log::spy();

    Config::set('cashier.webhook.secret', 'test-secret');

    $event = new Event('evt_test_123');
    $reflectionEvent = new \ReflectionClass($event);
    $eventValuesProperty = $reflectionEvent->getProperty('_values');
    $eventValuesProperty->setAccessible(true);
    $eventValues = $eventValuesProperty->getValue($event);
    $eventValues['type'] = 'customer.created'; // Unhandled event type
    $eventValuesProperty->setValue($event, $eventValues);

    $mockService = $this->mock(StripeWebhookServiceInterface::class);
    $mockService->shouldReceive('constructEvent')
        ->once()
        ->andReturn($event);

    $this->app->instance(StripeWebhookServiceInterface::class, $mockService);

    $response = $this->postJson(route('stripe.webhook'), [
        'type' => 'customer.created',
    ], [
        'Stripe-Signature' => 'test-signature',
    ]);

    $response->assertStatus(200);
    $response->assertJson(['received' => true]);

    Log::shouldHaveReceived('info')
        ->once()
        ->with('Unhandled Stripe webhook event: customer.created');

    Config::set('cashier.webhook.secret', null);
});

test('webhook returns error on generic exception', function () {
    Log::spy();

    Config::set('cashier.webhook.secret', 'test-secret');

    $mockService = $this->mock(StripeWebhookServiceInterface::class);
    $mockService->shouldReceive('constructEvent')
        ->once()
        ->andThrow(new \Exception('Generic webhook error'));

    $this->app->instance(StripeWebhookServiceInterface::class, $mockService);

    $response = $this->postJson(route('stripe.webhook'), [
        'type' => 'invalid.event',
    ], [
        'Stripe-Signature' => 'test-signature',
    ]);

    $response->assertStatus(400);
    $response->assertJson(['error' => 'Webhook processing failed']);

    Log::shouldHaveReceived('error')
        ->once()
        ->with(\Mockery::pattern('/Stripe webhook error/'));

    Config::set('cashier.webhook.secret', null);
});

test('webhook logs warning when secret is not configured', function () {
    Log::spy();

    $originalSecret = config('cashier.webhook.secret');
    Config::set('cashier.webhook.secret', null);

    $response = $this->postJson(route('stripe.webhook'), [], [
        'Stripe-Signature' => 'test-signature',
    ]);

    Log::shouldHaveReceived('warning')
        ->once()
        ->with('Stripe webhook secret not configured');

    Config::set('cashier.webhook.secret', $originalSecret);
});

test('webhook logs error on signature verification failure', function () {
    Log::spy();

    Config::set('cashier.webhook.secret', 'test-secret');

    $mockService = $this->mock(StripeWebhookServiceInterface::class);
    $mockService->shouldReceive('constructEvent')
        ->once()
        ->andThrow(new SignatureVerificationException('Invalid signature', 400));

    $this->app->instance(StripeWebhookServiceInterface::class, $mockService);

    $response = $this->postJson(route('stripe.webhook'), [
        'type' => 'checkout.session.completed',
    ], [
        'Stripe-Signature' => 'invalid-signature',
    ]);

    $response->assertStatus(400);

    Log::shouldHaveReceived('error')
        ->once()
        ->with(\Mockery::pattern('/Stripe webhook signature verification failed/'));

    Config::set('cashier.webhook.secret', null);
});

test('webhook logs error on generic exception', function () {
    Log::spy();

    Config::set('cashier.webhook.secret', 'test-secret');

    $mockService = $this->mock(StripeWebhookServiceInterface::class);
    $mockService->shouldReceive('constructEvent')
        ->once()
        ->andThrow(new \RuntimeException('Generic webhook processing error'));

    $this->app->instance(StripeWebhookServiceInterface::class, $mockService);

    $response = $this->postJson(route('stripe.webhook'), [
        'type' => 'invalid.event',
    ], [
        'Stripe-Signature' => 'test-signature',
    ]);

    $response->assertStatus(400);

    Log::shouldHaveReceived('error')
        ->once()
        ->with(\Mockery::pattern('/Stripe webhook error/'));

    Config::set('cashier.webhook.secret', null);
});

test('webhook processes checkout.session.completed event', function () {
    Log::spy();
    Config::set('cashier.webhook.secret', 'test-secret');

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $purchase = Purchase::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '1234567890',
        'ebook_id' => $ebook->id,
        'stripe_checkout_session_id' => 'cs_test_123',
        'amount' => 29.99,
        'currency' => 'usd',
        'status' => 'pending',
    ]);

    $session = new \Stripe\Checkout\Session('cs_test_123');
    $reflectionSession = new \ReflectionClass($session);
    $valuesProperty = $reflectionSession->getProperty('_values');
    $valuesProperty->setAccessible(true);
    $values = $valuesProperty->getValue($session);
    $values['payment_status'] = 'paid';
    $values['payment_intent'] = 'pi_test_123';
    $valuesProperty->setValue($session, $values);

    $event = new Event('evt_test_123');
    $reflectionEvent = new \ReflectionClass($event);
    $eventValuesProperty = $reflectionEvent->getProperty('_values');
    $eventValuesProperty->setAccessible(true);
    $eventValues = $eventValuesProperty->getValue($event);
    $eventValues['type'] = 'checkout.session.completed';
    $eventValues['data'] = (object) ['object' => $session];
    $eventValuesProperty->setValue($event, $eventValues);

    $mockService = $this->mock(StripeWebhookServiceInterface::class);
    $mockService->shouldReceive('constructEvent')
        ->once()
        ->andReturn($event);

    $this->app->instance(StripeWebhookServiceInterface::class, $mockService);

    $response = $this->postJson(route('stripe.webhook'), [
        'type' => 'checkout.session.completed',
    ], [
        'Stripe-Signature' => 'test-signature',
    ]);

    $response->assertStatus(200);
    $response->assertJson(['received' => true]);

    $purchase->refresh();
    $this->assertEquals('completed', $purchase->status);
    $this->assertEquals('pi_test_123', $purchase->stripe_payment_intent_id);
    $this->assertNotNull($purchase->completed_at);

    Log::shouldHaveReceived('info')
        ->once()
        ->with(\Mockery::pattern('/Purchase completed:/'));

    Config::set('cashier.webhook.secret', null);
});

test('webhook handles generic exception and returns error', function () {
    Log::spy();
    Config::set('cashier.webhook.secret', 'test-secret');

    $mockService = $this->mock(StripeWebhookServiceInterface::class);
    $mockService->shouldReceive('constructEvent')
        ->once()
        ->andThrow(new \RuntimeException('Generic webhook processing error'));

    $this->app->instance(StripeWebhookServiceInterface::class, $mockService);

    $response = $this->postJson(route('stripe.webhook'), [
        'invalid' => 'payload',
    ], [
        'Stripe-Signature' => 'test-signature',
    ]);

    $response->assertStatus(400);
    $response->assertJson(['error' => 'Webhook processing failed']);

    Log::shouldHaveReceived('error')
        ->once()
        ->with(\Mockery::pattern('/Stripe webhook error/'));

    Config::set('cashier.webhook.secret', null);
});

test('webhook processes checkout.session.completed event through switch', function () {
    Log::spy();
    Config::set('cashier.webhook.secret', 'test-secret');

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $purchase = Purchase::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '1234567890',
        'ebook_id' => $ebook->id,
        'stripe_checkout_session_id' => 'cs_test_123',
        'amount' => 29.99,
        'currency' => 'usd',
        'status' => 'pending',
    ]);

    $session = new \Stripe\Checkout\Session('cs_test_123');
    $reflectionSession = new \ReflectionClass($session);
    $valuesProperty = $reflectionSession->getProperty('_values');
    $valuesProperty->setAccessible(true);
    $values = $valuesProperty->getValue($session);
    $values['payment_status'] = 'paid';
    $values['payment_intent'] = 'pi_test_123';
    $valuesProperty->setValue($session, $values);

    $event = new Event('evt_test_123');
    $reflectionEvent = new \ReflectionClass($event);
    $eventValuesProperty = $reflectionEvent->getProperty('_values');
    $eventValuesProperty->setAccessible(true);
    $eventValues = $eventValuesProperty->getValue($event);
    $eventValues['type'] = 'checkout.session.completed';
    $eventValues['data'] = (object) ['object' => $session];
    $eventValuesProperty->setValue($event, $eventValues);

    $mockService = $this->mock(StripeWebhookServiceInterface::class);
    $mockService->shouldReceive('constructEvent')
        ->once()
        ->andReturn($event);

    $this->app->instance(StripeWebhookServiceInterface::class, $mockService);

    $response = $this->postJson(route('stripe.webhook'), [
        'type' => 'checkout.session.completed',
    ], [
        'Stripe-Signature' => 'test-signature',
    ]);

    $response->assertStatus(200);
    $response->assertJson(['received' => true]);

    $purchase->refresh();
    $this->assertEquals('completed', $purchase->status);

    Config::set('cashier.webhook.secret', null);
});

test('webhook processes payment_intent.succeeded event through switch', function () {
    Log::spy();
    Config::set('cashier.webhook.secret', 'test-secret');

    $paymentIntent = new \Stripe\PaymentIntent('pi_test_123');
    $event = new Event('evt_test_123');
    $reflectionEvent = new \ReflectionClass($event);
    $eventValuesProperty = $reflectionEvent->getProperty('_values');
    $eventValuesProperty->setAccessible(true);
    $eventValues = $eventValuesProperty->getValue($event);
    $eventValues['type'] = 'payment_intent.succeeded';
    $eventValues['data'] = (object) ['object' => $paymentIntent];
    $eventValuesProperty->setValue($event, $eventValues);

    $mockService = $this->mock(StripeWebhookServiceInterface::class);
    $mockService->shouldReceive('constructEvent')
        ->once()
        ->andReturn($event);

    $this->app->instance(StripeWebhookServiceInterface::class, $mockService);

    $response = $this->postJson(route('stripe.webhook'), [
        'type' => 'payment_intent.succeeded',
    ], [
        'Stripe-Signature' => 'test-signature',
    ]);

    $response->assertStatus(200);
    $response->assertJson(['received' => true]);

    Log::shouldHaveReceived('info')
        ->once()
        ->with('Payment intent succeeded: pi_test_123');

    Config::set('cashier.webhook.secret', null);
});

test('webhook returns success response after processing event', function () {
    Config::set('cashier.webhook.secret', 'test-secret');

    $paymentIntent = new \Stripe\PaymentIntent('pi_test_123');
    $event = new Event('evt_test_123');
    $reflectionEvent = new \ReflectionClass($event);
    $eventValuesProperty = $reflectionEvent->getProperty('_values');
    $eventValuesProperty->setAccessible(true);
    $eventValues = $eventValuesProperty->getValue($event);
    $eventValues['type'] = 'payment_intent.succeeded';
    $eventValues['data'] = (object) ['object' => $paymentIntent];
    $eventValuesProperty->setValue($event, $eventValues);

    $mockService = $this->mock(StripeWebhookServiceInterface::class);
    $mockService->shouldReceive('constructEvent')
        ->once()
        ->andReturn($event);

    $this->app->instance(StripeWebhookServiceInterface::class, $mockService);

    $response = $this->postJson(route('stripe.webhook'), [
        'type' => 'payment_intent.succeeded',
    ], [
        'Stripe-Signature' => 'test-signature',
    ]);

    $response->assertStatus(200);
    $response->assertJson(['received' => true]);

    Config::set('cashier.webhook.secret', null);
});
