<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Dao\Models\WorkType;
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

$factory->define(WorkType::class, function (Faker $faker) {
    return [
        'work_type_id' => $faker->unique()->numberBetween(1, 100),
        'work_type_name' => $faker->word,
    ];
});
