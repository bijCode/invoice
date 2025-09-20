<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;

class CustomerFactory extends Factory
{
    public function definition()
    {
        return [
            'company_id' => Company::inRandomOrder()->first()->id ?? Company::factory(),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'billing_address' => $this->faker->address,
            'delivery_address' => $this->faker->address,
            'mobile_number' => $this->faker->phoneNumber,
            'send_docket_to' => $this->faker->randomElement(['billing','delivery']),
        ];
    }
}
