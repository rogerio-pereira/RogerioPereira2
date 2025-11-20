<?php

namespace Database\Seeders;

use App\Models\Briefing;
use Illuminate\Database\Seeder;

class BriefingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Briefing::factory(10)
            ->create();
    }
}
