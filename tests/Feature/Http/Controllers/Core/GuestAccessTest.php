<?php

it('redirects guests from the admin panel to the login page', function (string $url) {
    $loginUrl = route('login');

    $this->get($url)
        ->assertRedirect($loginUrl);
})->with([
    '/dashboard',
    '/settings/profile',
    '/settings/security',
    '/settings/appearance',
    '/core/users',
    '/core/users/create',
]);
