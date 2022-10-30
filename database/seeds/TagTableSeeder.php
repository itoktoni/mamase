<?php

use App\Dao\Models\Tag;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $fakers = str_replace(".", "", $faker->sentence(2));
        Tag::create([
            'tag_name' => $fakers,
            'tag_code' => strtoupper(str_replace(" ", "_", $fakers)),
        ]);
    }
}
