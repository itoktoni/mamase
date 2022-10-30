<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_action', function (Blueprint $table) {
            $table->string('system_action_code');
            $table->string('system_action_module')->nullable();
            $table->string('system_action_name');
            $table->string('system_action_description')->nullable();
            $table->string('system_action_link')->nullable();
            $table->string('system_action_controller')->nullable();
            $table->string('system_action_function')->nullable();
            $table->tinyInteger('system_action_sort')->nullable();
            $table->boolean('system_action_show')->nullable();
            $table->boolean('system_action_enable')->nullable();
            $table->string('system_action_path')->nullable();
            $table->string('system_action_method')->nullable();
            $table->boolean('system_action_api')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_action');
    }
}
