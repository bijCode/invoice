<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;
use App\Models\Product;

class OrderFactory extends Factory
{
    public function definition()
    {
        return [
            'customer_id' => Customer::inRandomOrder()->first()->id ?? Customer::factory(),
            'product_id' => Product::inRandomOrder()->first()->id ?? Product::factory(),
            'liters' => $this->faker->randomFloat(3, 10, 500),
            'delivery_date' => $this->faker->dateTimeThisYear(),
        ];
    }
}
