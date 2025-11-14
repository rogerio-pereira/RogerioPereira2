<?php

namespace Tests\Feature\App\Http\Controllers\LandingPages;

test('software development page can be accessed by anyone', function () {
    $response = $this->get(route('software-development'));

    $response->assertStatus(200);
    $response->assertViewIs('landing-pages.software-development.index');
});

test('software development page does not require authentication', function () {
    $response = $this->get(route('software-development'));

    $response->assertStatus(200);
    $this->assertGuest();
});

test('software development thank you page can be accessed by anyone', function () {
    $response = $this->get(route('software-development.thank-you'));

    $response->assertStatus(200);
    $response->assertViewIs('landing-pages.software-development.thank-you');
});

test('software development thank you page does not require authentication', function () {
    $response = $this->get(route('software-development.thank-you'));

    $response->assertStatus(200);
    $this->assertGuest();
});

