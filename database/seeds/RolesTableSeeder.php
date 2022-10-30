<?php

use App\Dao\Models\Roles;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public $model;

    public function __construct(Roles $model)
    {
        $this->model = $model;
    }

    public function run()
    {
        $this->model->delete();

        $this->model->insert(array(
            [
                'role_code' => 'admin',
                'role_name' => 'Administrator',
                'role_description' => 'Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.',
                'role_active' => 1,
            ],
            [
                'role_code' => 'user',
                'role_name' => 'Pengguna',
                'role_description' => 'Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.',
                'role_active' => 1,
            ],
            [
                'role_code' => 'pengawas',
                'role_name' => 'Pengawas',
                'role_description' => 'Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.',
                'role_active' => 1,
            ],
            [
                'role_code' => 'pelaksana',
                'role_name' => 'Pelaksana',
                'role_description' => 'Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.',
                'role_active' => 1,
            ],
        ));

    }
}
