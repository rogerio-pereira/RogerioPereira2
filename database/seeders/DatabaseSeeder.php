<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
        ]);

        if (config('app.env') === 'local') {
            $this->call([
                EbookSeeder::class,
                LeadSeeder::class,
                SalesSeeder::class,
            ]);
        }
    }
}
