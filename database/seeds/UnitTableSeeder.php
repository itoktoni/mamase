<?php

use App\Dao\Models\Unit;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public $model;

    public function __construct(Unit $model)
    {
        $this->model = $model;
    }

    public function run()
    {
        $faker = Faker::create('id_ID');
        $this->model->delete();
        $this->model->insert(array (
            [
                'unit_code' => 'PCS',
                'unit_name' => 'Pcs',
            ],
        ));
    }
}
