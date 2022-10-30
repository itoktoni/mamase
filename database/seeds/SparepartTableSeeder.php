<?php

use App\Dao\Models\Sparepart;
use Faker\Factory as Faker;
use Faker\Provider\Fakecar;
use Illuminate\Database\Seeder;

class SparepartTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 20) as $item) {

            $faker = Faker::create('id_ID');
            $faker->addProvider(new Fakecar($faker));
            Sparepart::create([
                'sparepart_name' => $faker->vehicleModel,
                'sparepart_location_id' => $faker->unique()->numberBetween($min = 1, $max = 10),
                'sparepart_brand_id' => $faker->unique()->numberBetween($min = 1, $max = 10),
                'sparepart_type_id' => $faker->unique()->numberBetween($min = 1, $max = 3),
                'sparepart_unit_code' => 'PCS',
                'sparepart_description' => $faker->text($maxNbChars = 200),
                'sparepart_stock' => $faker->randomDigit,
                'sparepart_product_id' => $faker->numberBetween($min = 1, $max = 10),
            ]);
        }
    }
}
