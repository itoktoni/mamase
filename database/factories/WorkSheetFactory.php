<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Dao\Models\WorkSheet;
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

$factory->define(WorkSheet::class, function (Faker $faker) {
    return [
        'work_sheet_code' => $faker->uuid,
        'work_sheet_type_id' => $faker->numberBetween(1, 2), //(relation work_type)
        'work_sheet_name' => $faker->word,
        'work_sheet_description' => $faker->text($maxNbChars = 50),
        'work_sheet_check' => $faker->text($maxNbChars = 50),
        'work_sheet_result' => $faker->text($maxNbChars = 50),
        'work_sheet_ticket_code' => null,
        'work_sheet_product_id' => $faker->numberBetween($min = 1, $max = 50), //(relation product)
        'work_sheet_reported_at' => date('Y-m-d H:i:s'),
        'work_sheet_reported_by' => '1',
        'work_sheet_created_at' => date('Y-m-d H:i:s'),
        'work_sheet_created_by' => '1',
        'work_sheet_updated_at' => date('Y-m-d H:i:s'),
        'work_sheet_updated_by' => '1',
        'work_sheet_finished_at' => date('Y-m-d H:i:s'),
        'work_sheet_finished_by' => '1',
    ];
});
