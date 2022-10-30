<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_menu', function (Blueprint $table) {
            $table->string('system_menu_code');
            $table->string('system_menu_module')->nullable();
            $table->string('system_menu_name');
            $table->string('system_menu_description')->nullable();
            $table->string('system_menu_link')->nullable();
            $table->string('system_menu_controller')->nullable();
            $table->string('system_menu_function')->nullable();
            $table->tinyInteger('system_menu_sort')->nullable();
            $table->boolean('system_menu_show')->nullable();
            $table->boolean('system_menu_enable')->nullable();
            $table->string('system_menu_path')->nullable();
            $table->string('system_menu_method')->nullable();
            $table->boolean('system_menu_api')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_menu');
    }
}
