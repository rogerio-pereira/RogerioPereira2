<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Ebook;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ebook>
 */
class EbookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Ebook::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'category_id' => rand(1,3),
            'price' => fake()->randomFloat(2, 9.99, 199.99),
            'file' => 'ebooks/files/fake-' . fake()->uuid() . '.pdf',
            'image' => 'ebooks/images/no-image-book.png',
        ];
    }
}
