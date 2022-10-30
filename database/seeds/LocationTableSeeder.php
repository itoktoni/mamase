<?php

use App\Dao\Models\Location;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new Location())->delete();
        foreach (range(1, 10) as $item) {
            $faker = Faker::create('id_ID');
            Location::create([
                'location_name' => $faker->colorName, //nama lokasi nama2 warna
                'location_description' => $faker->text($maxNbChars = 200),
                'location_building_id' => $faker->numberBetween($min = 1, $max = 10),
            ]);
        }
    }
}
