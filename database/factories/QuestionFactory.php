<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\Specialization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'body' => fake()->text(),
            'specialization_id'=> Specialization::factory(),
            'patient_id'=> Patient::factory(),
            'answered'=> 0,
        ];
    }
}
