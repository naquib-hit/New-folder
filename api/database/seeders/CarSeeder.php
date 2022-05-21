<?php

namespace Database\Seeders;

use App\Models\Car as Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Car::factory(5)->create();
    }
}
