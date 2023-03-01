<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personal>
 */
class PersonalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'mobile_number' => fake()->phoneNumber(),
            'age' => fake()->numberBetween(1,100),
            'height' =>fake()->numberBetween(1,100),
            'weight' =>fake()->numberBetween(1,100),
            'sex' => fake()->boolean(),
            'social_situation' => fake()->boolean(),
            'address' => fake()->text(),
            'patient_id'=> Patient::factory(),
        ];
    }
}
