<?php

use App\Http\Controllers\LandingPages\AutomationController;
use App\Http\Controllers\LandingPages\HomeController;
use App\Http\Controllers\LandingPages\MarketingController;
use App\Http\Controllers\LandingPages\SoftwareDevelopmentController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

//Home
Route::get('/', [HomeController::class, 'index'])->name('home');

//Automation
Route::get('/automation', [AutomationController::class, 'index'])->name('automation');
Route::get('/automation/thank-you', [AutomationController::class, 'thanks'])->name('automation.thank-you');

//Software Development
Route::get('/software-development', [SoftwareDevelopmentController::class, 'index'])->name('software-development');
Route::get('/software-development/thank-you', [SoftwareDevelopmentController::class, 'thanks'])->name('software-development.thank-you');

//Marketing
Route::get('/marketing', [MarketingController::class, 'index'])->name('marketing');
Route::get('/marketing/thank-you', [MarketingController::class, 'thanks'])->name('marketing.thank-you');

Route::middleware(['auth'])
    ->prefix('core')
    ->group(function () {
        Route::view('dashboard', 'dashboard')
            ->middleware(['auth', 'verified'])
            ->name('dashboard');

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
