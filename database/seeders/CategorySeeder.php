<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Automation',
                'color' => '#2CBFB3',
            ],
            [
                'name' => 'Marketing',
                'color' => '#C3329E',
            ],
            [
                'name' => 'Software Development',
                'color' => '#7D49CC',
            ],
        ]);
    }
}


