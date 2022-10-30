<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemGroupModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_group_module', function (Blueprint $table) {
            $table->string('system_group_module_code')->primary();
            $table->string('system_group_module_name')->nullable();
            $table->string('system_group_module_description')->nullable();
            $table->string('system_group_module_link')->nullable();
            $table->integer('system_group_module_sort')->nullable()->default(0);
            $table->string('system_group_module_visible')->nullable();
            $table->string('system_group_module_enable')->nullable();
            $table->boolean('system_group_module_modular')->nullable();
            $table->string('system_group_module_folder')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_group_module');
    }
}
