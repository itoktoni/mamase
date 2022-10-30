<?php

use App\Dao\Models\TicketSystem;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TicketSystemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(TicketSystem::class, 2000)->create();
    }
}
