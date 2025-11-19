<?php

namespace Database\Factories;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Purchase::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->optional()->phoneNumber(),
            'stripe_payment_intent_id' => 'pi_'.fake()->uuid(),
            'amount' => fake()->randomFloat(2, 9.99, 99.99),
            'currency' => 'usd',
            'status' => 'completed',
            'completed_at' => now(),
        ];
    }
}
