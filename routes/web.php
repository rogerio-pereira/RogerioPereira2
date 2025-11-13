<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('landing-pages/home/index');
})->name('home');

Route::get('/automation', function () {
    return view('landing-pages/automation/index');
})->name('automation');

Route::get('/automation/thank-you', function () {
    return view('landing-pages/automation/thank-you');
})->name('automation.thank-you');


Route::get('/software-development', function () {
    return view('landing-pages/software-development/index');
})->name('software-development');

Route::get('/software-development/thank-you', function () {
    return view('landing-pages/software-development/thank-you');
})->name('software-development.thank-you');

Route::get('/marketing', function () {
    return view('landing-pages/marketing/index');
})->name('marketing');

Route::get('/marketing/thank-you', function () {
    return view('landing-pages/marketing/thank-you');
})->name('marketing.thank-you');










Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
