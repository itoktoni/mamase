<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communication', function (Blueprint $table) {
            $table->bigIncrements('communication_id');
            $table->tinyInteger('communication_type');
            $table->tinyInteger('communication_status');
            $table->string('communication_reference_code');
            $table->dateTime('communication_created_at');
            $table->dateTime('communication_updated_at');
            $table->dateTime('communication_created_by');
            $table->dateTime('communication_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communication');
    }
}
