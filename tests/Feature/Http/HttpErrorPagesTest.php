<?php

use Illuminate\Support\Facades\Route;

it('renders the branded 404 page without exposing exception details', function () {
    $response = $this->get('/this-page-does-not-exist');

    $response->assertNotFound()
        ->assertSee('This page does not exist', false)
        ->assertSee('Back to home', false)
        ->assertSee('/fonts/SpaceGrotesk-Variable.woff2', false)
        ->assertDontSee('exception', false)
        ->assertDontSee('Stack', false)
        ->assertDontSee('APP_', false);
});

it('renders the branded 500 page without exposing exception details', function () {
    Route::get('/__http-error-500', function () {
        abort(500);
    });

    $response = $this->get('/__http-error-500');

    $response->assertStatus(500)
        ->assertSee('Something went wrong', false)
        ->assertSee('Back to home', false)
        ->assertDontSee('exception', false)
        ->assertDontSee('Stack', false)
        ->assertDontSee('APP_', false)
        ->assertDontSee('vendor/', false);
});

it('renders the branded 503 page without exposing exception details', function () {
    Route::get('/__http-error-503', function () {
        abort(503);
    });

    $response = $this->get('/__http-error-503');

    $response->assertStatus(503)
        ->assertSee('Back soon', false)
        ->assertSee('Try home again', false)
        ->assertDontSee('exception', false)
        ->assertDontSee('Stack', false)
        ->assertDontSee('APP_', false)
        ->assertDontSee('vendor/', false);
});
