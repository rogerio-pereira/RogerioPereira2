<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Model events stay enabled so observers run exactly as they do through
     * the admin panel.
     */
    public function run(): void
    {
        /*
         * =============================================================================================================
         * REAL DATA
         * =============================================================================================================
         */
        $this->call([
            UserSeeder::class,
        ]);

        /*
         * =============================================================================================================
         * FAKE DATA
         * =============================================================================================================
         */
        $currentEnv = config('app.env');
        if (
            $currentEnv === 'local' ||
            $currentEnv === 'testing'
        ) {
            $this->call([
                UserLocalSeeder::class,
            ]);
        }
    }
}
