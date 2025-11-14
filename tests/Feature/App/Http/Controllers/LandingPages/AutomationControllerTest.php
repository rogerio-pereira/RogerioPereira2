<?php

namespace Tests\Feature\App\Http\Controllers\LandingPages;

test('automation page can be accessed by anyone', function () {
    $response = $this->get(route('automation'));

    $response->assertStatus(200);
    $response->assertViewIs('landing-pages.automation.index');
});

test('automation page does not require authentication', function () {
    $response = $this->get(route('automation'));

    $response->assertStatus(200);
    $this->assertGuest();
});

test('automation thank you page can be accessed by anyone', function () {
    $response = $this->get(route('automation.thank-you'));

    $response->assertStatus(200);
    $response->assertViewIs('landing-pages.automation.thank-you');
});

test('automation thank you page does not require authentication', function () {
    $response = $this->get(route('automation.thank-you'));

    $response->assertStatus(200);
    $this->assertGuest();
});
