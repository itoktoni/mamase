<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Dao\Models\TicketSystem;
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

$factory->define(TicketSystem::class, function (Faker $faker) {
    return [
        'ticket_system_code' => $faker->uuid,
        'ticket_system_topic_id' => $faker->numberBetween(1, 3), //(relation ticket_topic)
        'ticket_system_name' => $faker->word,
        'ticket_system_description' => $faker->text($maxNbChars = 50),
        'ticket_system_priority' => $faker->numberBetween(1, 3),
        'ticket_system_status' => '1',
        'ticket_system_department_id' => 1, //(relation department)
        'ticket_system_reported_at' => date('Y-m-d H:i:s'),
        'ticket_system_reported_by' => '1',
        'ticket_system_created_at' => date('Y-m-d H:i:s'),
        'ticket_system_created_by' => '1',
        'ticket_system_updated_at' => date('Y-m-d H:i:s'),
        'ticket_system_updated_by' => '1',
    ];
});
