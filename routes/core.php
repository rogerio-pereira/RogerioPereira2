<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Core (admin) routes
|--------------------------------------------------------------------------
|
| Authenticated back-office under /core.
|
*/
Route::middleware(['auth'])
    ->prefix('core')
    ->name('core.')
    ->group(function (): void {
        //
    });
