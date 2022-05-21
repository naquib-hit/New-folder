<?php

namespace Database\Seeders;

use App\Models\SalesDetails;
use Illuminate\Database\Seeder;

class SalesDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        SalesDetails::factory(14)->create();
    }
}
