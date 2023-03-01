<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Specialization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Consultation>
 */
class ConsultationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->text(),
            'details' => fake()->text(),
            'time' => fake()->time(),
            'status_pain' => fake()->word(),
            'frequency' =>fake()->word(),
            'type_complaint' => fake()->word(),
            'severity_pain' => fake()->word(),
            'nature_complaint' => fake()->word(),
            'factors_increase_complaint' => fake()->word(),
            'factors_reduce_complaint' => fake()->word(),
            'place_pain' => fake()->word(),
            'images' => fake()->word(),
            'status' => 'waiting',
            'patient_id'=> Patient::factory(),
            'specialization_id'=> Specialization::factory(),
            'doctor_id'=> null,
        ];
    }
}
