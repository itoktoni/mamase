<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Dao\Models\Spk;
use Faker\Generator as Faker;

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

$factory->define(Spk::class, function (Faker $faker) {
    return [
        'spk_id' => $faker->uuid,
        'spk_vendor_id'=> null,
        'spk_date'=> date('Y-m-d H:i:s'),
        'spk_code'=> null,
        'spk_description'=> $faker->text($maxNbChars = 50),
        'spk_product_id' => $faker->numberBetween($min = 1, $max = 50), //(relation product)
        'spk_check'=> $faker->text($maxNbChars = 50),
        'spk_result'=> $faker->text($maxNbChars = 50),
        'spk_work_sheet_code' => null,
        'spk_status'=> $faker->numberBetween(1, 5),
    ];
});
