<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_system', function (Blueprint $table) {
            $table->string('ticket_system_code')->primary();
            $table->integer('ticket_system_topic_id')->nullable();
            $table->integer('ticket_system_location_id')->nullable();
            $table->integer('ticket_system_product_id')->nullable();
            $table->integer('ticket_system_work_type_id')->nullable();
            $table->string('ticket_system_name')->nullable();
            $table->text('ticket_system_description')->nullable();
            $table->tinyInteger('ticket_system_priority');
            $table->tinyInteger('ticket_system_status');
            $table->string('ticket_system_implementor')->nullable();
            $table->integer('ticket_system_department_id')->nullable();
            $table->date('ticket_system_reported_at')->nullable();
            $table->string('ticket_system_reported_by')->nullable();
            $table->string('ticket_system_picture')->nullable();
            $table->date('ticket_system_approved_at')->nullable();
            $table->string('ticket_system_approved_by')->nullable();
            $table->dateTime('ticket_system_created_at')->nullable();
            $table->string('ticket_system_created_by')->nullable();
            $table->dateTime('ticket_system_updated_at')->nullable();
            $table->string('ticket_system_updated_by')->nullable();
            $table->dateTime('ticket_system_deleted_at')->nullable();
            $table->string('ticket_system_deleted_by')->nullable();
            $table->dateTime('ticket_system_finished_at')->nullable();
            $table->string('ticket_system_finished_by')->nullable();
            $table->string('ticket_system_schedule_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_system');
    }
}
