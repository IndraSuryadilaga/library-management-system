<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $loanDate = $this->faker->dateTimeBetween('-6 months', 'now');
        $dueDate = (clone $loanDate)->modify('+14 days');

        return [
            'item_id' => Item::inRandomOrder()->first()->id ?? Item::factory(),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'loan_date' => $loanDate,
            'due_date' => $dueDate,
            'return_date' => $this->faker->randomElement([null, $this->faker->dateTimeBetween($loanDate, 'now')]),
        ];
    }

    /**
     * Indicate that the loan has been returned.
     */
    public function returned(): static
    {
        return $this->state(fn (array $attributes) => [
            'return_date' => $this->faker->dateTimeBetween($attributes['loan_date'], 'now'),
        ]);
    }

    /**
     * Indicate that the loan has not been returned yet.
     */
    public function notReturned(): static
    {
        return $this->state(fn (array $attributes) => [
            'return_date' => null,
        ]);
    }
}

