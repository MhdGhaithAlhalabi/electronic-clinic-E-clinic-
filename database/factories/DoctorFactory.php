<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Region;
use App\Models\Specialization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' =>bcrypt('password'),
        //'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            //$2y$10$je3lUyAukw.WDeuQ2RIN5.uAghy1ul/BGoqyatK386u8IjvEW88F6
            'mobile_number' => fake()->phoneNumber(),
            'clinic_number' => fake()->phoneNumber(),
            'region_id' => Region::factory(),
            'sex'=> fake()->boolean(),
            'image'=> fake()->image(),
            'specialization_id'=> Specialization::factory(),
            'rate'=> fake()->numberBetween(1,5),
            'main_title' => fake()->sentence(),
            'title' => fake()->text(),
            'certificate_image' => fake()->image(),
            'opening_time' => fake()->text(),
            'full_address' => fake()->text(),
            'status' => 0,
        ];
    }
}
