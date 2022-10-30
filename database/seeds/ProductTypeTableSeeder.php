<?php

use App\Dao\Models\ProductType;
use Faker\Factory as Faker;
use Faker\Provider\Fakecar;
use Illuminate\Database\Seeder;

class ProductTypeTableSeeder extends Seeder
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
        (new ProductType())->delete();
        foreach (range(1, 3) as $item) {
            ProductType::create([
                'product_type_id' => $item,
                'product_type_name' => $faker->unique()->vehicleFuelType,
                'product_type_description' => $faker->text($maxNbChars = 200),
                'product_type_active' => 1,
            ]);
        }
    }
}
