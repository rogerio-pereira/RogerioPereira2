<?php

namespace App\Providers;

use App\Models\Ebook;
use App\Observers\EbookObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Observers
        Ebook::observe(EbookObserver::class);
    }
}
