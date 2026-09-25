<?php

use Illuminate\Support\Facades\Route;

// Temporary until the public home page (F07) takes over this route.
Route::redirect('/', '/login')
    ->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

require __DIR__.'/core.php';
