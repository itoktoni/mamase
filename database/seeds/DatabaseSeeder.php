<?php

use App\Dao\Models\User;
use Faker\Factory as Faker; // https://github.com/fzaninotto/Faker#formatters
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    {
        factory(User::class, 1)->create();
        $faker = Faker::create('id_ID');

        $this->call([
            //system
            GroupsTableSeeder::class,
            RoutesTableSeeder::class,
            RolesTableSeeder::class,
            MenusTableSeeder::class,
            UsersTableSeeder::class,
            // master
            TicketTopicTableSeeder::class,
            WorkTypeTableSeeder::class,
            UnitTableSeeder::class,
            BuildingTableSeeder::class,
            LocationTableSeeder::class,
            TagTableSeeder::class,
            SparepartTableSeeder::class,
            SupplierTableSeeder::class,
            DepartmentTableSeeder::class,
            BrandTableSeeder::class,
            CategoryTableSeeder::class,
            ProductTypeTableSeeder::class,
            ProductTableSeeder::class,
            // transaction
            TicketSystemTableSeeder::class,
            WorkSheetTableSeeder::class,
            MovementTableSeeder::class,
            SpkTableSeeder::class,
            ScheduleTableSeeder::class,
        ]);
    }
}
