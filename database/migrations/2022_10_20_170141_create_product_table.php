<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements('product_id');
            $table->string('product_name');
            $table->string('product_serial_number')->nullable();
            $table->string('product_internal_number')->nullable();
            $table->string('product_auto_number')->nullable();
            $table->string('product_image')->nullable();
            $table->integer('product_category_id')->nullable();
            $table->integer('product_type_id')->nullable();
            $table->integer('product_brand_id')->nullable();
            $table->string('product_unit_code')->nullable();
            $table->integer('product_location_id')->nullable();
            $table->integer('product_department_id')->nullable();
            $table->integer('product_supplier_id')->nullable();
            $table->bigInteger('product_price')->nullable();
            $table->tinyInteger('product_is_asset')->default(1);
            $table->tinyInteger('product_status')->default(1);
            $table->text('product_description')->nullable();
            $table->year('product_acqu_year')->nullable();
            $table->year('product_prod_year')->nullable();
            $table->date('product_buy_date')->nullable();
            $table->dateTime('product_created_at')->nullable();
            $table->dateTime('product_updated_at')->nullable();
            $table->dateTime('product_deleted_at')->nullable();
            $table->integer('product_deleted_by')->nullable();
            $table->integer('product_updated_by')->nullable();
            $table->integer('product_created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
