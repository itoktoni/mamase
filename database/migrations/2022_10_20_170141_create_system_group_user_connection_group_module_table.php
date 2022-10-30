<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemGroupUserConnectionGroupModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_group_user_connection_group_module', function (Blueprint $table) {
            $table->string('system_group_user_code');
            $table->string('system_group_module_code');

            $table->primary(['system_group_user_code', 'system_group_module_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_group_user_connection_group_module');
    }
}
