<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spk', function (Blueprint $table) {
            $table->string('spk_id')->primary();
            $table->string('spk_vendor_id')->nullable();
            $table->date('spk_date')->nullable();
            $table->string('spk_code')->nullable();
            $table->text('spk_description')->nullable();
            $table->integer('spk_product_id')->nullable();
            $table->text('spk_check')->nullable();
            $table->text('spk_result')->nullable();
            $table->string('spk_work_sheet_code')->nullable();
            $table->integer('spk_estimation')->nullable();
            $table->integer('spk_realisation')->nullable();
            $table->tinyInteger('spk_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spk');
    }
}
