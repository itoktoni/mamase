<?php

use App\Dao\Models\Spk;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class SpkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Spk::class, 30)->create();
    }
}