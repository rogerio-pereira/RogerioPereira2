<?php

namespace Database\Seeders;

use App\Models\Ebook;
use Illuminate\Database\Seeder;

class EbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 ebooks with random categories (IDs 1-3)
        Ebook::factory()
            ->count(10)
            ->create();
    }
}
