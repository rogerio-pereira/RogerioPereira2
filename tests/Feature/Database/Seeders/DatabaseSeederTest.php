<?php

use App\Models\User;
use Database\Seeders\UserLocalSeeder;

/**
 * These tests intentionally skip UserSeeder: it inserts the production founder
 * accounts with fixed bcrypt cost-12 hashes, which conflict with phpunit's
 * BCRYPT_ROUNDS=4 via the Eloquent "hashed" cast.
 */
it('seeds the local test user and stays idempotent', function () {
    $this->seed(UserLocalSeeder::class);
    $this->seed(UserLocalSeeder::class);

    $userCount = User::where('email', 'test@example.com')
                    ->count();

    expect($userCount)->toBe(1);
});
