<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Suspect>
 */
class SuspectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik' => fake()->unique()->numerify('################'),
            'name' => fake()->name(),
            'alias' => fake()->name(),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'place_of_birth' => fake()->city(),
            'date_of_birth' => fake()->date(),
            'age' => fake()->numberBetween(18, 60),
            'religion' => fake()->randomElement(['Islam', 'Christianity', 'Hinduism', 'Buddhism']),
            'education' => fake()->randomElement(['High School', 'Bachelor', 'Master', 'Doctorate']),
            'occupation' => fake()->jobTitle(),
            'address' => fake()->address(),
            'finger_code' => fake()->optional()->numerify('FC-########'),
            'photo' => fake()->optional()->imageUrl(640, 480, 'people'),

        ];
    }
}
