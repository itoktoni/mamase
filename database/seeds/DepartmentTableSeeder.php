<?php

use App\Dao\Models\Department;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    public function __construct(Department $model)
    {
        $this->model = $model;
    }

    public function run()
    {
        $this->model->delete();

        $this->model->insert(array(
            [
                'department_id' => '1',
                'department_user_id' => random_int(11, 20),
                'department_name' => 'Bagian Umum',
                'department_pic' => 'Pak Joni',
            ],
        ));

        $this->model->insert(array(
            [
                'department_id' => '2',
                'department_user_id' => random_int(11, 20),
                'department_name' => 'Departemen Medis',
                'department_pic' => 'Pak Badu',
            ],
        ));

        $this->model->insert(array(
            [
                'department_id' => '3',
                'department_user_id' => random_int(11, 20),
                'department_name' => 'Departemen Konstruksi',
                'department_pic' => 'Pak Paijo',
            ],
        ));

        $this->model->insert(array(
            [
                'department_id' => '4',
                'department_user_id' => random_int(11, 20),
                'department_name' => 'Departemen Pantry',
                'department_pic' => 'Pak Romli',
            ],
        ));

        $this->model->insert(array(
            [
                'department_id' => '5',
                'department_user_id' => random_int(11, 20),
                'department_name' => 'Departemen IT',
                'department_pic' => 'Pak Seto',
            ],
        ));
    }
}
