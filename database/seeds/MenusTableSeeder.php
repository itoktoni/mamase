<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        DB::table('menus')->delete();
        DB::table('menus')->insert(array (
            [
                'menu_code' => 'getCreate',
                'menu_name' => 'Create Product',
                'menu_module' => 'product',
                'menu_reset' => 1,
                'menu_show' => 1,
                'menu_active' => 1,
            ],
            [
                'menu_code' => 'getTable',
                'menu_name' => 'List Product',
                'menu_module' => 'product',
                'menu_reset' => 0,
                'menu_show' => 1,
                'menu_active' => 1,
            ],
            [
                'menu_code' => 'getUpdate',
                'menu_name' => 'Update',
                'menu_module' => 'product',
                'menu_reset' => 1,
                'menu_show' => 0,
                'menu_active' => 1,
            ],
            [
                'menu_code' => 'postDelete',
                'menu_name' => 'Delete',
                'menu_module' => 'product',
                'menu_reset' => 1,
                'menu_show' => 0,
                'menu_active' => 1,
            ],
        ));
    }
}