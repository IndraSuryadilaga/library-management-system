<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'isbn' => $this->faker->unique()->isbn13(),
            'publication_year' => $this->faker->year(),
            'author_id' => Author::inRandomOrder()->first()->id,
            'publisher_id' => Publisher::inRandomOrder()->first()->id,
        ];
    }
}
