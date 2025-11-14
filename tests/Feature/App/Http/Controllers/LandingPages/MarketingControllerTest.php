<?php

namespace Tests\Feature\App\Http\Controllers\LandingPages;

test('marketing page can be accessed by anyone', function () {
    $response = $this->get(route('marketing'));

    $response->assertStatus(200);
    $response->assertViewIs('landing-pages.marketing.index');
});

test('marketing page does not require authentication', function () {
    $response = $this->get(route('marketing'));

    $response->assertStatus(200);
    $this->assertGuest();
});

test('marketing thank you page can be accessed by anyone', function () {
    $response = $this->get(route('marketing.thank-you'));

    $response->assertStatus(200);
    $response->assertViewIs('landing-pages.marketing.thank-you');
});

test('marketing thank you page does not require authentication', function () {
    $response = $this->get(route('marketing.thank-you'));

    $response->assertStatus(200);
    $this->assertGuest();
});

