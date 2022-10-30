<?php

use App\Dao\Models\Movement;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class MovementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Movement::class, 10)->create();
    }
}
