<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Dao\Models\Product;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Faker\Provider\Fakecar;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$factory->define(Product::class, function (Faker $faker) {
    $faker->addProvider(new Fakecar($faker));
    return [
        'product_name' => $faker->unique()->vehicle,
        'product_serial_number' => strtoupper($faker->unique()->vin),
        'product_category_id' => $faker->numberBetween($min = 1, $max = 5),
        'product_type_id' => $faker->numberBetween($min = 1, $max = 3),
        'product_brand_id' => $faker->numberBetween($min = 1, $max = 10),
        'product_unit_code' => 'PCS',
        'product_location_id' => $faker->numberBetween($min = 1, $max =5),
        'product_description' => $faker->text($maxNbChars = 100),
        'product_created_at' => date('Y-m-d H:i:s'),
        'product_prod_year' => $faker->year(),
        'product_buy_date' => $faker->date(),
        'product_status' => 1,
    ];
});
