<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cases>
 */
class CasesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'suspect_id' => fake()->numberBetween(1, 10),
            'number' => fake()->unique()->numerify('CASE-########'),
            'name' => fake()->sentence(3),
            'chapter' => fake()->randomElement(['Chapter 1', 'Chapter 2', 'Chapter 3']),
            'place' => fake()->city(),
            'datetime' => fake()->dateTime(),
//            'decision' => fake()->randomElement(['Guilty', 'Not Guilty', 'Dismissed']),
            'division' => fake()->randomElement(['Division A', 'Division B', 'Division C']),
            'description' => fake()->paragraph(),

        ];
    }
}
