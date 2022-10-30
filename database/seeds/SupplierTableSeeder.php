<?php

use App\Dao\Models\Supplier;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class SupplierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        (new Supplier())->delete();
        foreach (range(1, 5) as $item) {
            Supplier::create([
                'supplier_name' => $faker->company,
                'supplier_contact' => $faker->name,
                'supplier_address' => $faker->streetAddress,
                'supplier_email' => $faker->email,
                'supplier_phone' => $faker->phoneNumber,
            ]);
        }
    }
}
