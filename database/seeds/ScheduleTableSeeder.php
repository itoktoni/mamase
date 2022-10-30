<?php

use App\Dao\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public $model;

    public function __construct(Schedule $model)
    {
        $this->model = $model;
    }

    public function run()
    {
        $this->model->delete();

        $this->model->insert(array(
            [
                'schedule_name' => 'Schedule 1',
                'schedule_product_id' => 1,
                'schedule_description' => 'Officiis repudiandae vitae iusto.',
                'schedule_number' => 1,
                'schedule_start_date' => date("Y-m-d"),
                'schedule_status' => 1,
            ],
            [
                'schedule_name' => 'Schedule 2',
                'schedule_product_id' => 2,
                'schedule_description' => 'Mauris blandit aliquet elit, eget.',
                'schedule_number' => 2,
                'schedule_start_date' => date("Y-m-d", strtotime(' + 2 days')),
                'schedule_status' => 2,
            ],
            [
                'schedule_name' => 'Schedule 3',
                'schedule_product_id' => 3,
                'schedule_description' => 'Vestibulum ante ipsum primis in.',
                'schedule_number' => 3,
                'schedule_start_date' => date("Y-m-d", strtotime(' + 3 days')),
                'schedule_status' => 2,
            ],
        ));

    }
}
