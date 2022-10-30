<?php

use App\Dao\Models\WorkType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkTypeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */

    public $model;

    public function __construct(WorkType $model)
    {
        $this->model = $model;
    }

    public function run()
    {
        $this->model->delete();
        $this->model->insert(array (
            [
                'work_type_id' => 1,
                'work_type_name' => 'Preventif',
            ],
            [
                'work_type_id' => 2,
                'work_type_name' => 'Korektif',
            ],
            [
                'work_type_id' => 3,
                'work_type_name' => 'Penjadwalan',
            ],
        ));
    }
}