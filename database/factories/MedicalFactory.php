<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medical>
 */
class MedicalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'practices' => fake()->word(),
            'medicines' => fake()->word(),
            'surgery' => fake()->word(),
            'blood_thinner' => fake()->word(),
            'hypertension' =>fake()->boolean(),
            'diabetes' => fake()->boolean(),
            'genetic_diseases' => fake()->word(),
            'vaccines' => fake()->word(),
            'sensitive' =>  fake()->word(),
            'patient_id'=> Patient::factory(),
        ];
    }
}
