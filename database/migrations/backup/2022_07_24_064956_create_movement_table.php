<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateMovementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movement', function (Blueprint $table) {
            $table->string('movement_code')->primary();
            $table->text('movement_description')->nullable();
            $table->text('movement_reason');
            $table->date('movement_date')->nullable();
            $table->integer('movement_product_id')->nullable(); // (update location di table product jika movement di approve)
            $table->string('movement_location_old')->nullable();
            $table->string('movement_location_new')->nullable();
            $table->tinyInteger('movement_status')->default(1); // (Pending, Approve, Reject)
            $table->dateTime('movement_created_at')->nullable();
            $table->integer('movement_created_by')->nullable();
            $table->dateTime('movement_updated_at')->nullable();
            $table->integer('movement_updated_by')->nullable();
            $table->dateTime('movement_requested_at')->nullable();
            $table->integer('movement_requested_by')->nullable(); // (relasi ke table user)
            $table->dateTime('movement_approved_at')->nullable();
            $table->integer('movement_approved_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movement');
    }
}
