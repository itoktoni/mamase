<?php

use App\Dao\Models\WorkSheet;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class WorkSheetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(WorkSheet::class, 30)->create();
    }
}
