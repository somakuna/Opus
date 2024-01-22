<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

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
        return [
            'method' => fake()->randomElement(['in', 'out']),
            'amount' => fake()->numberBetween(100, 1000),
            'description' => fake()->city,
            'partner_id' => fake()->numberBetween(1, 5),
            'work_id' => null,
            'created_at' => fake()->dateTimeBetween('-20 days', '+12 months')
        ];
    }
}
