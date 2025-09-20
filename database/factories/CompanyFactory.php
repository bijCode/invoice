<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'email' => $this->faker->companyEmail,
            'bn_number' => 'BN' . $this->faker->numerify('######'),
        ];
    }
}
