<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserLocalSeeder extends Seeder
{
    /**
     * Seed the default local development user.
     */
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')
                    ->first();

        if ($user !== null) {
            return;
        }

        User::factory()
            ->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
    }
}
