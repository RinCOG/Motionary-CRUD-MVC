<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'price' => fake()->randomFloat(2, 5, 2500),
            'quantity' => fake()->numberBetween(0, 80),
            'category' => fake()->randomElement(['Electronics', 'Furniture', 'Kitchen', 'Office', 'Clothing', 'Books', 'Sports', 'Other']),
            'description' => fake()->sentence(),
            'created_date' => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
        ];
    }
}
