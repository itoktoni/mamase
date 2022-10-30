<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSparepartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sparepart', function (Blueprint $table) {
            $table->bigIncrements('sparepart_id');
            $table->string('sparepart_name');
            $table->integer('sparepart_location_id')->nullable();
            $table->integer('sparepart_brand_id')->nullable();
            $table->integer('sparepart_type_id')->nullable();
            $table->string('sparepart_unit_code')->nullable();
            $table->text('sparepart_description')->nullable();
            $table->integer('sparepart_stock')->nullable();
            $table->integer('sparepart_product_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sparepart');
    }
}
