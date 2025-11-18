<?php

namespace App\Providers;

use App\Events\NewLead;
use App\Listeners\NewLeadSlackListener;
use App\Models\Purchase;
use App\Observers\PurchaseObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Event::listen(
            NewLead::class,
            NewLeadSlackListener::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Purchase::observe(PurchaseObserver::class);
    }
}
