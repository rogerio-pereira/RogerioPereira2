<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\Core\CategoryController;
use App\Http\Controllers\Core\EbookController;
use App\Http\Controllers\LandingPages\AutomationController;
use App\Http\Controllers\LandingPages\HomeController;
use App\Http\Controllers\LandingPages\MarketingController;
use App\Http\Controllers\LandingPages\SoftwareDevelopmentController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Automation
Route::get('/automation', [AutomationController::class, 'index'])->name('automation');
Route::post('/automation', [AutomationController::class, 'store'])->name('automation.store');
Route::get('/automation/thank-you', [AutomationController::class, 'thanks'])->name('automation.thank-you');

// Software Development
Route::get('/software-development', [SoftwareDevelopmentController::class, 'index'])->name('software-development');
Route::post('/software-development', [SoftwareDevelopmentController::class, 'store'])->name('software-development.store');
Route::get('/software-development/thank-you', [SoftwareDevelopmentController::class, 'thanks'])->name('software-development.thank-you');

// Marketing
Route::get('/marketing', [MarketingController::class, 'index'])->name('marketing');
Route::post('/marketing', [MarketingController::class, 'store'])->name('marketing.store');
Route::get('/marketing/thank-you', [MarketingController::class, 'thanks'])->name('marketing.thank-you');

// Shop - Public routes for buying ebooks
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

// Ebook download route (public, requires confirmation hash)
Route::get('/ebooks/{ebook}/download/{confirmation?}', [ShopController::class, 'downloadEbook'])->name('ebooks.download');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{ebook}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{ebook}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout routes
Route::get('/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');
Route::post('/checkout/process', [ShopController::class, 'processCheckout'])->name('shop.checkout.process');
Route::get('/shop/success/{purchase}', [ShopController::class, 'success'])->name('shop.success');

// Stripe Webhook (must be excluded from CSRF)
Route::post('/stripe/webhook', [WebhookController::class, 'handle'])
    ->name('stripe.webhook')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);

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

        // Categories
        Route::resource('categories', CategoryController::class)->names('core.categories');

        // Ebooks
        Route::resource('ebooks', EbookController::class)->names('core.ebooks');
        Route::get('ebooks/{ebook}/download', [EbookController::class, 'download'])->name('core.ebooks.download');

    });
