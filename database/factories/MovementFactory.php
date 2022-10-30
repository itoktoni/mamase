<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Dao\Models\Movement;
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

$factory->define(Movement::class, function (Faker $faker) {
    return [
        'movement_code' => $faker->uuid,
        'movement_description' => $faker->text($maxNbChars = 50),
        'movement_reason' => $faker->text($maxNbChars = 50),
        'movement_date' => date('Y-m-d H:i:s'),
        'movement_product_id' => $faker->numberBetween(1, 50), //(update location di table product jika movement di approve)
        'movement_location_new' => $faker->numberBetween(1, 5), //(relation product)
        'movement_status' => $faker->numberBetween(1, 3),
        'movement_created_at' => date('Y-m-d H:i:s'),
        'movement_created_by' => '1',
        'movement_updated_at' => date('Y-m-d H:i:s'),
        'movement_updated_by' => '1',
        'movement_requested_at' => date('Y-m-d H:i:s'),
        'movement_requested_by' => $faker->numberBetween(11, 21),
    ];
});
