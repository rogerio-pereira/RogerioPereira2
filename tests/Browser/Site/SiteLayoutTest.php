<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

beforeEach(function () {
    Route::get('/__test/layout', function () {
        return Inertia::render('testing/Layout', ['title' => 'Layout test']);
    });
})->flaky();

it('shows the header, the footer and the page head on a public page', function () {
    visit('/__test/layout')
        ->assertSee('Rogerio Pereira')
        ->assertSee('Start a project')
        ->assertSee('LAYOUT TEST')
        ->assertPresent('@site-header')
        ->assertPresent('@site-footer')
        ->assertPresent('@page-head')
        ->assertPresent('main#main');
});

it('links the main navigation', function () {
    visit('/__test/layout')
        ->assertPresent('header a[href="/#services"]')
        ->assertPresent('header a[href="/cases"]')
        ->assertPresent('header a[href="/#process"]')
        ->assertPresent('header a[href="/#faq"]')
        ->assertPresent('header a[href="/blog"]')
        ->assertPresent('header a[href="/#start"]');
});

it('has a skip link to the main content', function () {
    visit('/__test/layout')
        ->assertPresent('a.sr-only[href="#main"]')
        ->assertPresent('#main');
});

it('opens and closes the mobile menu', function () {
    visit('/__test/layout')
        ->on()->mobile()
        ->assertMissing('@main-menu')
        ->assertAttribute('@menu-button', 'aria-expanded', 'false')
        ->click('@menu-button')
        ->assertVisible('@main-menu')
        ->assertAttribute('@menu-button', 'aria-expanded', 'true')
        ->click('#main-menu a[href="/#faq"]')
        ->assertMissing('@main-menu');
});

it('does not load fonts from an external host', function () {
    visit('/__test/layout')
        ->assertSourceMissing('fonts.bunny.net')
        ->assertSourceMissing('fonts.googleapis.com');
});

it('shows the pagination', function () {
    visit('/__test/layout')
        ->assertPresent('@pagination')
        ->assertPresent('@pagination-previous')
        ->assertPresent('@pagination-next')
        ->assertAttribute('.pager a[aria-current="page"]', 'aria-current', 'page');
});
