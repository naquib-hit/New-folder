<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $cars = ['Honda', 'Toyota', 'Suzuki', 'Mitsubishi', 'Wuling', 'Haval'];

        return [
            //
            'car_name'  => $this->faker->unique->randomElement($cars),
            'car_price' => $this->faker->numberBetween(10000000, 999999990),
            'stock'     => $this->faker->randomNumber(3, true)
        ];
    }
}
