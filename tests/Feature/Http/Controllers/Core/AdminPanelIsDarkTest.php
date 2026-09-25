<?php

use App\Models\User;

it('forces the admin panel dark', function (string $url) {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $response = $this->get($url);

    $response->assertOk();
    $response->assertSee('class="dark"', false);
})->with([
    '/dashboard',
    '/settings/appearance',
    '/core/users',
]);
