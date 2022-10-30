<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkSheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_sheet', function (Blueprint $table) {
            $table->string('work_sheet_code')->primary();
            $table->integer('work_sheet_type_id')->nullable();
            $table->string('work_sheet_name')->nullable();
            $table->text('work_sheet_description')->nullable();
            $table->text('work_sheet_check')->nullable();
            $table->text('work_sheet_result')->nullable();
            $table->tinyInteger('work_sheet_status');
            $table->string('work_sheet_ticket_code')->nullable();
            $table->integer('work_sheet_product_id')->nullable();
            $table->date('work_sheet_reported_at')->nullable();
            $table->string('work_sheet_reported_by')->nullable();
            $table->dateTime('work_sheet_created_at')->nullable();
            $table->string('work_sheet_created_by')->nullable();
            $table->dateTime('work_sheet_updated_at')->nullable();
            $table->string('work_sheet_updated_by')->nullable();
            $table->dateTime('work_sheet_deleted_at')->nullable();
            $table->string('work_sheet_deleted_by')->nullable();
            $table->dateTime('work_sheet_finished_at')->nullable();
            $table->string('work_sheet_finished_by')->nullable();
            $table->dateTime('work_sheet_implement_at')->nullable();
            $table->string('work_sheet_implement_by')->nullable();
            $table->tinyInteger('work_sheet_contract')->nullable();
            $table->integer('work_sheet_vendor_id')->nullable();
            $table->string('work_sheet_implementor')->nullable();
            $table->string('work_sheet_picture')->nullable();
            $table->integer('work_sheet_location_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_sheet');
    }
}
