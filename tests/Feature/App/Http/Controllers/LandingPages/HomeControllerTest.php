<?php

namespace Tests\Feature\App\Http\Controllers\LandingPages;

test('home page can be accessed by anyone', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200);
    $response->assertViewIs('landing-pages.home.index');
});

test('home page does not require authentication', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200);
    $this->assertGuest();
});
