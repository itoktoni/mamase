<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemGroupModuleConnectionModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_group_module_connection_module', function (Blueprint $table) {
            $table->string('system_group_module_code');
            $table->string('system_module_code');

            $table->primary(['system_group_module_code', 'system_module_code']);
            $table->index(['system_group_module_code', 'system_module_code'], 'conn_gm_group_module');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_group_module_connection_module');
    }
}
