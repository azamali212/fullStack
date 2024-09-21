<?php

namespace Database\Factories;

use App\Models\Hospital;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HospitalProfile>
 */
class HospitalProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'hospital_id' => Hospital::factory(),  // This will link to a Hospital using its factory
            'name' => $this->faker->name(),
            'profile_image' => $this->faker->imageUrl(400, 400, 'people', true, 'Faker'),  // Dummy image URL
            'phone_number' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'degree' => $this->faker->randomElement(['MBBS', 'MD', 'DO', 'PhD']),
        ];
    }
}
