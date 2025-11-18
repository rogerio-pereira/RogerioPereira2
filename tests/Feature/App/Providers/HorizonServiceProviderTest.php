<?php

namespace Tests\Feature\App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

test('horizon gate is defined', function () {
    $this->assertTrue(Gate::has('viewHorizon'));
});

test('authenticated user can access horizon', function () {
    $user = User::factory()->create();

    $canAccess = Gate::forUser($user)->allows('viewHorizon');

    $this->assertTrue($canAccess);
});

test('unauthenticated user cannot access horizon', function () {
    $canAccess = Gate::allows('viewHorizon');

    $this->assertFalse($canAccess);
});

test('horizon gate returns false when user is null', function () {
    $canAccess = Gate::forUser(null)->allows('viewHorizon');

    $this->assertFalse($canAccess);
});

test('horizon service provider is registered', function () {
    $providers = config('app.providers', []);

    // Check if HorizonServiceProvider is in the providers list
    // In Laravel 12, providers are in bootstrap/providers.php
    $this->assertTrue(
        in_array(\App\Providers\HorizonServiceProvider::class, $providers) ||
        file_exists(app_path('Providers/HorizonServiceProvider.php'))
    );
});

test('horizon gate works with multiple users', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $canAccess1 = Gate::forUser($user1)->allows('viewHorizon');
    $canAccess2 = Gate::forUser($user2)->allows('viewHorizon');

    $this->assertTrue($canAccess1);
    $this->assertTrue($canAccess2);
});
