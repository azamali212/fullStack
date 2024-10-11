<?php

namespace Database\Factories;

use App\Models\Hospital;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nurse>
 */
class NurseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
           'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone_no' => $this->faker->phoneNumber,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'postal_code' => $this->faker->postcode,
            'country' => $this->faker->country,
            'contact_person_name' => $this->faker->name,
            'profile_picture' => 'default_profile.jpg', // or use faker to generate an image
            'study_details' => $this->faker->sentence,
            'pdf_cv' => 'default_cv.pdf', // or you can generate a dummy file name if needed
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
