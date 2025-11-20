<?php

namespace App\Providers;

use App\Models\Purchase;
use App\Observers\PurchaseObserver;
use App\Services\Contracts\StripeWebhookServiceInterface;
use App\Services\StripeWebhookService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Dependency Injection pattern
        $this->app->bind(StripeWebhookServiceInterface::class, StripeWebhookService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Purchase::observe(PurchaseObserver::class);
    }
}
