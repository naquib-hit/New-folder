<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalesDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $cars = Car::Where('deleted_at', NULL)->pluck('id')->toArray();
        return [
            //
            'customer_name'  => $this->faker->name(),
            'customer_email' => $this->faker->email(),
            'customer_phone' => $this->faker->phoneNumber(),
            'sale_date'      => $this->faker->dateTimeBetween('-1 week', '+2 days'),
            'car'            => $this->faker->randomElement($cars)
        ];
    }
}
