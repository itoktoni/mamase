<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_module', function (Blueprint $table) {
            $table->string('system_module_code', 50)->primary();
            $table->string('system_module_name', 100)->nullable();
            $table->string('system_module_description')->nullable();
            $table->string('system_module_link', 100)->nullable();
            $table->string('system_module_folder', 100)->nullable();
            $table->string('system_module_controller')->nullable();
            $table->string('system_module_filters')->nullable();
            $table->tinyInteger('system_module_sort')->nullable();
            $table->boolean('system_module_single')->nullable();
            $table->boolean('system_module_show')->nullable();
            $table->boolean('system_module_enable')->nullable();
            $table->boolean('system_module_module')->nullable();
            $table->string('system_module_path')->nullable();
            $table->boolean('system_module_api')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_module');
    }
}
