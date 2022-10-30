<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Dao\Models\TicketTopic;
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

$factory->define(TicketTopic::class, function (Faker $faker) {
    return [
        'ticket_topic_id' => $faker->unique()->numberBetween(1, 5),
        'ticket_topic_name' => $faker->word,
        'ticket_topic_active' => 1,
    ];
});