<?php

use App\Dao\Models\Groups;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public $model;

    public function __construct(Groups $model)
    {
        $this->model = $model;
    }

    public function run()
    {
        $this->model->delete();

        $this->model->insert(array(
            [
                'group_code' => 'master',
                'group_name' => 'Master Data',
                'group_icon' => 'database',
                'group_url' => null,
                'group_sort' => 1,
                'group_active' => 1,
            ],
            [
                'group_code' => 'transaction',
                'group_name' => 'Transaction',
                'group_icon' => 'package',
                'group_url' => null,
                'group_sort' => 2,
                'group_active' => 1,
            ],
            [
                'group_code' => 'scheduling',
                'group_name' => 'Scheduling',
                'group_icon' => 'clock',
                'group_url' => null,
                'group_sort' => 4,
                'group_active' => 1,
            ],
            [
                'group_code' => 'report',
                'group_name' => 'Report',
                'group_icon' => 'printer',
                'group_url' => null,
                'group_sort' => 99,
                'group_active' => 1,
            ],
            [
                'group_code' => 'system',
                'group_name' => 'System',
                'group_icon' => 'settings',
                'group_url' => null,
                'group_sort' => 100,
                'group_active' => 1,
            ],
        ));

    }
}
