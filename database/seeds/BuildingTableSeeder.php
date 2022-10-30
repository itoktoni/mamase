<?php

use App\Dao\Models\Building;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class BuildingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create('id_ID');
        (new Building())->delete();
        foreach (range(1, 50) as $item) {
            Building::create([
                'building_name' => $faker->state,
                'building_description' => $faker->text($maxNbChars = 200),
                'building_contact_person' => $faker->name,
                'building_contact_phone' => $faker->phoneNumber,
                'building_address' => $faker->address,
            ]);
        }
    }
}
