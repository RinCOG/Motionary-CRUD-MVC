<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\VocabularyWord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VocabularyWord>
 */
class VocabularyWordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'term' => fake()->unique()->word(),
            'part_of_speech' => fake()->randomElement(['noun', 'verb', 'adjective', 'adverb']),
            'phonetic' => '/'.fake()->lexify('?????').'/',
            'definition' => fake()->sentence(),
            'example' => fake()->sentence(),
        ];
    }
}
