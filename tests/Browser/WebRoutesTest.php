<?php

use App\Models\User;

beforeEach()->flaky();

it('smoke tests public web routes', function (string $url, string $text) {
    visit($url)
        ->assertSee($text);
})
->with([
    ['/login', 'Email address'],
    ['/forgot-password', 'Forgot password'],
]);

it('smoke tests authenticated app routes', function (string $url, string $text) {
    $user = User::factory()
                ->create();

    $this->actingAs($user);
    $this->withSession(['auth.password_confirmed_at' => time()]);

    visit($url)
        ->waitForEvent('networkidle')
        ->assertSee($text);
})
->with([
    ['/dashboard', 'Dashboard'],
    ['/settings/profile', 'Update your name and email address'],
    ['/settings/security', 'Update password'],
    ['/settings/appearance', 'Appearance settings'],
    ['/core/users', 'Users'],
]);

it('redirects guests from the admin panel to the login page', function (string $url) {
    visit($url)
        ->assertPathIs('/login');
})
->with([
    '/dashboard',
    '/core/users',
]);
