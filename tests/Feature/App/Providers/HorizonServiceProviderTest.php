<?php

namespace Tests\Feature\App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

test('horizon gate allows authenticated users', function () {
    $user = User::factory()->create();

    $canViewHorizon = Gate::forUser($user)->allows('viewHorizon');

    $this->assertTrue($canViewHorizon);
});

test('horizon gate denies unauthenticated users', function () {
    $canViewHorizon = Gate::allows('viewHorizon');

    $this->assertFalse($canViewHorizon);
});

test('horizon gate denies null user', function () {
    $canViewHorizon = Gate::forUser(null)->allows('viewHorizon');

    $this->assertFalse($canViewHorizon);
});

test('horizon gate is registered', function () {
    $this->assertTrue(Gate::has('viewHorizon'));
});

test('horizon gate returns false for guest', function () {
    $this->assertGuest();

    $canViewHorizon = Gate::allows('viewHorizon');

    $this->assertFalse($canViewHorizon);
});

test('horizon gate returns true for authenticated user', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $canViewHorizon = Gate::allows('viewHorizon');

    $this->assertTrue($canViewHorizon);
});
