<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = rand(100, 200);
        $categories = ['automation', 'marketing', 'software-development'];

        Contact::factory($count)->create()->each(function ($contact) use ($categories) {
            // Randomly assign one category
            $category = $categories[array_rand($categories)];

            // Map category key to database column name
            $categoryColumn = match ($category) {
                'automation' => 'automation',
                'marketing' => 'marketing',
                'software-development' => 'software_development',
                default => 'automation',
            };

            $contact->update([
                $categoryColumn => true,
                'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
            ]);
        });
    }
}
