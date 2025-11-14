<?php

namespace Tests\Feature\App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Features;

test('two-factor rate limiter uses login.id from session', function () {
    if (! Features::canManageTwoFactorAuthentication()) {
        $this->markTestSkipped('Two-factor authentication is not enabled.');
    }

    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);

    $user = User::factory()->create();
    $loginId = $user->id;

    // Test line 63: RateLimiter::for('two-factor') uses session('login.id')
    // We need to simulate a login attempt that sets the session
    $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    // Verify the session has login.id set
    $this->assertTrue(session()->has('login.id'));

    // Verify rate limiter is configured and working
    $limiter = RateLimiter::limiter('two-factor');
    $this->assertNotNull($limiter);

    // Test that the limiter uses session('login.id') - line 63
    $request = request();
    $request->session()->put('login.id', $loginId);

    $limit = $limiter($request);
    $this->assertNotNull($limit);
    $this->assertEquals(5, $limit->maxAttempts);

    // Verify the key is based on login.id
    $this->assertStringContainsString((string) $loginId, $limit->key);
});

test('two-factor rate limiter handles missing login.id gracefully', function () {
    if (! Features::canManageTwoFactorAuthentication()) {
        $this->markTestSkipped('Two-factor authentication is not enabled.');
    }

    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);

    // Test that the rate limiter can handle when login.id is not in session
    $limiter = RateLimiter::limiter('two-factor');
    $this->assertNotNull($limiter);

    // Use a request with session but without login.id
    // Make a request that will have a session but no login.id
    $response = $this->get(route('two-factor.login'));

    // The limiter should still work, using null as the key (line 63)
    // We test by calling the limiter with a request that has session but no login.id
    $request = request();
    // Ensure session exists but login.id is not set

    $limit = $limiter($request);
    $this->assertNotNull($limit);
    $this->assertEquals(5, $limit->maxAttempts);
});
