<?php

use App\Dao\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        (new User())->delete();

        User::create([
            'id' => 2,
            'name' => 'Pengguna',
            'username' => 'pengguna',
            'email' => 'pengguna@gmail.com',
            'phone' => '08111040159',
            'active' => 1,
            'role' => 'user',
            'email_verified_at' => now(),
            'password' => bcrypt('secret'),
            'remember_token' => null,
        ]);

        foreach (range(11, 20) as $item) {

            User::create([
                'id' => $item,
                'name' => $faker->name,
                'username' => $faker->userName(),
                'email' => $faker->unique()->email,
                'phone' => '08111040159',
                'active' => 1,
                'role' => 'pengawas',
                'email_verified_at' => now(),
                'password' => bcrypt('secret'),
                'remember_token' => null,
            ]);
        }

        foreach (range(21, 30) as $item) {

            User::create([
                'id' => $item,
                'name' => $faker->name,
                'username' => $faker->userName(),
                'email' => $faker->unique()->email,
                'active' => 1,
                'role' => 'admin',
                'email_verified_at' => now(),
                'password' => bcrypt('secret'),
                'remember_token' => null,
            ]);
        }

        foreach (range(31, 40) as $item) {

            User::create([
                'id' => $item,
                'name' => $faker->name,
                'username' => $faker->userName(),
                'email' => $faker->unique()->email,
                'active' => 1,
                'role' => 'pelaksana',
                'email_verified_at' => now(),
                'password' => bcrypt('secret'),
                'remember_token' => null,
            ]);
        }

        foreach (range(41, 50) as $item) {

            User::create([
                'id' => $item,
                'name' => $faker->name,
                'username' => $faker->userName(),
                'email' => $faker->unique()->email,
                'active' => 1,
                'role' => 'user',
                'email_verified_at' => now(),
                'password' => bcrypt('secret'),
                'remember_token' => null,
            ]);
        }
    }
}
