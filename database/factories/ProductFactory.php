<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => 'LPG ' . $this->faker->word,
            'price_per_liter' => $this->faker->randomFloat(2, 40, 80),
        ];
    }
}
