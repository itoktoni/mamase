<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filters', function (Blueprint $table) {
            $table->bigIncrements('filter_id');
            $table->string('filter_code')->nullable();
            $table->string('filter_table')->nullable();
            $table->string('filter_module')->nullable();
            $table->tinyInteger('filter_from_user')->nullable();
            $table->string('filter_field')->nullable();
            $table->string('filter_function')->nullable();
            $table->string('filter_operator')->nullable();
            $table->string('filter_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filters');
    }
}
