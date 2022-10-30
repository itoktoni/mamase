<?php

use App\Dao\Models\Category;
use Faker\Factory as Faker;
use Faker\Provider\Fakecar;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $faker->addProvider(new Fakecar($faker));
        (new Category())->delete();
        foreach (range(1, 5) as $item) {
            Category::create([
                'category_id' => $item,
                'category_name' => $faker->unique()->vehicleType,
                'category_description' => $faker->text($maxNbChars = 200),
                'category_active' => 1,
            ]);
        }
    }
}
