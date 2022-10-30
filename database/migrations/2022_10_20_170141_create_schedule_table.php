<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule', function (Blueprint $table) {
            $table->bigIncrements('schedule_id');
            $table->string('schedule_name');
            $table->integer('schedule_product_id')->nullable();
            $table->integer('schedule_location_id')->nullable();
            $table->text('schedule_description')->nullable();
            $table->integer('schedule_number')->nullable();
            $table->tinyInteger('schedule_every')->nullable();
            $table->date('schedule_start_date')->nullable();
            $table->date('schedule_end_date')->nullable();
            $table->tinyInteger('schedule_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule');
    }
}
