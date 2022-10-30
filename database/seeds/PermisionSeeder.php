<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('system_menu')->delete();
        DB::table('system_menu')->insert([

        ]);

        DB::table('system_permision')->delete();
        DB::table('system_permision')->insert(array (
            [
                'system_permision_code' => 'getCreate',
                'system_permision_name' => 'Create Product',
                'system_permision_module' => 'product',
                'system_permision_reset' => 1,
                'system_permision_show' => 1,
                'system_permision_active' => 1,
            ],
            [
                'system_permision_code' => 'getTable',
                'system_permision_name' => 'List Product',
                'system_permision_module' => 'product',
                'system_permision_reset' => 0,
                'system_permision_show' => 1,
                'system_permision_active' => 1,
            ],
            [
                'system_permision_code' => 'getUpdate',
                'system_permision_name' => 'Update',
                'system_permision_module' => 'product',
                'system_permision_reset' => 1,
                'system_permision_show' => 0,
                'system_permision_active' => 1,
            ],
            [
                'system_permision_code' => 'postDelete',
                'system_permision_name' => 'Delete',
                'system_permision_module' => 'product',
                'system_permision_reset' => 1,
                'system_permision_show' => 0,
                'system_permision_active' => 1,
            ],
        ));
    }
}
