<?php

namespace Database\Seeders;

use App\Models\Ebook;
use App\Models\Purchase;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = rand(50, 100);

        // Get all ebooks with files
        $ebooks = Ebook::whereNotNull('file')->get();

        if ($ebooks->isEmpty()) {
            $this->command->warn('No ebooks with files found. Please create ebooks first.');

            return;
        }

        Purchase::withoutEvents(function () use ($ebooks, $count) {
            for ($i = 0; $i < $count; $i++) {
                $ebook = $ebooks->random();

                Purchase::create([
                    'ebook_id' => $ebook->id,
                    'name' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'phone' => fake()->optional()->phoneNumber(),
                    'amount' => $ebook->price,
                    'currency' => 'usd',
                    'status' => 'completed',
                    'completed_at' => fake()->dateTimeBetween('-30 days', 'now'),
                    'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
                ]);
            }
        });
    }
}
