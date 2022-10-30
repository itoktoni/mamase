<?php

use App\Dao\Models\Brand;
use Faker\Factory as Faker;
use Faker\Provider\Fakecar;
use Illuminate\Database\Seeder;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $faker->addProvider(new Fakecar($faker));
        (new Brand())->delete();
        foreach (range(1, 10) as $item) {
            Brand::create([
                'brand_id' => $item,
                'brand_name' => $faker->vehicleBrand,
                'brand_description' => $faker->text($maxNbChars = 200),
            ]);
        }
    }
}
