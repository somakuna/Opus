<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Work>
 */
class WorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client' => fake()->company,
            'priority' => fake()->numberBetween(0, 3),
            'source' => fake()->randomElement(['WhatsApp', 'Signal', 'Walk in', 'E-mail']),
            'description' => fake()->paragraph,
            'note' => fake()->optional()->sentence,
            'price' => fake()->numberBetween(100, 1000),
            'payment_method' => fake()->randomElement(['Cash', 'R1']),
            'outsourced' => fake()->boolean,
            'design' => fake()->boolean,
            'ready' => fake()->boolean,
            'delivered' => fake()->boolean,
            'paid' => fake()->boolean,
            'outsourced_price' => fake()->optional()->numberBetween(50, 500),
            'printed' => fake()->boolean,
            'partner_id' => null,
        ];
    }
}
