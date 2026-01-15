<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 *
 * Factory for generating fake Patient data for testing purposes.
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * Generates realistic fake data for patient attributes.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,           // Generate a fake first name
            'last_name' => $this->faker->lastName,             // Generate a fake last name
            'email' => $this->faker->unique()->safeEmail,     // Generate a unique fake email
            'phone' => $this->faker->phoneNumber,              // Generate a fake phone number
            'date_of_birth' => $this->faker->date('Y-m-d', '-18 years'), // Generate a date of birth (18+ years ago)
            'address' => $this->faker->address,                // Generate a fake address
        ];
    }
}
