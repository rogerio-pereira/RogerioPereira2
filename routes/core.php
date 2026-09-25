<?php

use App\Http\Controllers\Core\UserController;
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
        Route::resource('users', UserController::class);
    });
