<?php

use App\Http\Controllers\BriefingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Core\BriefingController as CoreBriefingController;
use App\Http\Controllers\Core\CategoryController;
use App\Http\Controllers\Core\DashboardController;
use App\Http\Controllers\Core\EbookController;
use App\Http\Controllers\LandingPages\AutomationController;
use App\Http\Controllers\LandingPages\HomeController;
use App\Http\Controllers\LandingPages\MarketingController;
use App\Http\Controllers\LandingPages\SoftwareDevelopmentController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UnsubscribeController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Automation
Route::get('/automation', [AutomationController::class, 'index'])->name('automation');
Route::post('/automation', [AutomationController::class, 'store'])->middleware('throttle.forms')->name('automation.store');
Route::get('/automation/thank-you', [AutomationController::class, 'thanks'])->name('automation.thank-you');

// Software Development
Route::get('/software-development', [SoftwareDevelopmentController::class, 'index'])->name('software-development');
Route::post('/software-development', [SoftwareDevelopmentController::class, 'store'])->middleware('throttle.forms')->name('software-development.store');
Route::get('/software-development/thank-you', [SoftwareDevelopmentController::class, 'thanks'])->name('software-development.thank-you');

// Marketing
Route::get('/marketing', [MarketingController::class, 'index'])->name('marketing');
Route::post('/marketing', [MarketingController::class, 'store'])->middleware('throttle.forms')->name('marketing.store');
Route::get('/marketing/thank-you', [MarketingController::class, 'thanks'])->name('marketing.thank-you');

// Briefing
Route::get('/briefing', [BriefingController::class, 'create'])->name('briefing.create');
Route::post('/briefing', [BriefingController::class, 'store'])->name('briefing.store');
Route::get('/briefing/thank-you', [BriefingController::class, 'thanks'])->name('briefing.thank-you');

// Shop - Public routes for buying ebooks
Route::get('/shop/ebook/{ebook}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/shop/{category?}', [ShopController::class, 'index'])->name('shop.index');

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

// Unsubscribe routes
Route::get('/unsubscribe/{id}', [UnsubscribeController::class, 'show'])->name('unsubscribe.show');
Route::post('/unsubscribe/{id}/confirm', [UnsubscribeController::class, 'confirm'])->name('unsubscribe.confirm');
Route::get('/unsubscribe/{id}/resubscribe', [UnsubscribeController::class, 'resubscribe'])->name('unsubscribe.resubscribe');
Route::post('/unsubscribe/{id}/resubscribe/confirm', [UnsubscribeController::class, 'resubscribeConfirm'])->name('unsubscribe.resubscribe.confirm');
Route::get('/unsubscribe/{id}/resubscribe/success', [UnsubscribeController::class, 'resubscribeSuccess'])->name('unsubscribe.resubscribe.success');

// Stripe Webhook (must be excluded from CSRF)
Route::post('/stripe/webhook', [WebhookController::class, 'handle'])
    ->name('stripe.webhook')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);

Route::middleware(['auth'])
    ->prefix('core')
    ->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

        // Briefings
        Route::get('briefings', [CoreBriefingController::class, 'index'])->name('core.briefings.index');
        Route::get('briefings/{briefing}', [CoreBriefingController::class, 'show'])->name('core.briefings.show');
        Route::patch('briefings/{briefing}/mark-as-done', [CoreBriefingController::class, 'markAsDone'])->name('core.briefings.mark-as-done');

    });
