<?php

namespace Database\Factories;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fine>
 */
class FineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $reasons = ['late_return', 'damaged_item', 'lost_item', 'overdue'];

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'loan_id' => Loan::inRandomOrder()->first()->id ?? Loan::factory(),
            'amount' => $this->faker->randomFloat(2, 5, 50),
            'reason' => $this->faker->randomElement($reasons),
            'paid_at' => $this->faker->randomElement([null, $this->faker->dateTimeBetween('-6 months', 'now')]),
        ];
    }

    /**
     * Indicate that the fine has been paid.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'paid_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ]);
    }

    /**
     * Indicate that the fine has not been paid.
     */
    public function unpaid(): static
    {
        return $this->state(fn (array $attributes) => [
            'paid_at' => null,
        ]);
    }
}

