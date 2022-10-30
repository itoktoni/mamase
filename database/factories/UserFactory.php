<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Dao\Models\User;
use Illuminate\Support\Str;
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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => 'Admin',
        'username' => 'admin',
        'email' => 'admin@demo.com',
        'phone' => '08111040159',
        'active' => 1,
        'role' => 1,
        'email_verified_at' => now(),
        'password' =>  bcrypt('admin'), // password
    ];
});
