<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

beforeEach(function () {
    Route::get('/__test/layout', function () {
        $seo = [
            'title' => 'Case notes · Rogerio Pereira',
            'description' => 'Short notes about real work.',
            'image' => 'https://cdn.example.com/cover.jpg',
        ];

        return Inertia::render('testing/Layout', ['title' => 'Case notes'])
            ->withViewData('seo', $seo);
    });

    Route::get('/__test/layout-defaults', function () {
        return Inertia::render('testing/Layout', ['title' => 'Defaults']);
    });
});

it('prints the SEO tags with the values passed by the controller', function () {
    $response = $this->get('/__test/layout');

    $response->assertOk()
        ->assertSee('<title inertia>Case notes · Rogerio Pereira</title>', false)
        ->assertSee('<meta name="description" content="Short notes about real work.">', false)
        ->assertSee('<link rel="canonical" href="'.url('/__test/layout').'">', false)
        ->assertSee('<meta property="og:type" content="website">', false)
        ->assertSee('<meta property="og:title" content="Case notes · Rogerio Pereira">', false)
        ->assertSee('<meta property="og:description" content="Short notes about real work.">', false)
        ->assertSee('<meta property="og:url" content="'.url('/__test/layout').'">', false)
        ->assertSee('<meta property="og:image" content="https://cdn.example.com/cover.jpg">', false)
        ->assertSee('<meta name="twitter:card" content="summary_large_image">', false)
        ->assertSee('<meta name="twitter:site" content="@rpereira_dev">', false)
        ->assertSee('<meta name="twitter:image" content="https://cdn.example.com/cover.jpg">', false)
        ->assertSee('<meta name="theme-color" content="#151719">', false);
});

it('falls back to the defaults of config/site.php', function () {
    $response = $this->get('/__test/layout-defaults');

    $response->assertOk()
        ->assertSee('<title inertia>Rogerio Pereira · Web systems that hold up in production</title>', false)
        ->assertSee('<meta property="og:image" content="'.url('/og-image.jpg').'">', false)
        ->assertSee('<meta name="twitter:image" content="'.url('/og-image.jpg').'">', false);
});

it('does not print JSON-LD', function () {
    $response = $this->get('/__test/layout');

    $response->assertDontSee('application/ld+json', false);
});
