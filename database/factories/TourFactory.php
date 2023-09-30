<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour>
 */
class TourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'starting_date' => $this->faker->dateTimeBetween('now', '+1 years'),
            'ending_date' => $this->faker->dateTimeBetween('+1 years', '+2 years'),
            'price' => fake()->randomFloat(2, 100, 1000),
        ];
    }
}
