<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['available', 'loaned', 'lost', 'damaged'];

        return [
            'book_id' => Book::inRandomOrder()->first()->id ?? Book::factory(),
            'barcode' => $this->faker->unique()->isbn13(),
            'status' => $this->faker->randomElement($statuses),
        ];
    }

    /**
     * Indicate that the item is available.
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'available',
        ]);
    }

    /**
     * Indicate that the item is loaned.
     */
    public function loaned(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'loaned',
        ]);
    }

    /**
     * Indicate that the item is lost.
     */
    public function lost(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'lost',
        ]);
    }

    /**
     * Indicate that the item is damaged.
     */
    public function damaged(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'damaged',
        ]);
    }
}

