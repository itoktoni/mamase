<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemFilterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_filter', function (Blueprint $table) {
            $table->integer('key', true);
            $table->string('name')->nullable();
            $table->string('table')->nullable();
            $table->string('module')->nullable();
            $table->boolean('custom')->nullable();
            $table->string('field')->nullable();
            $table->string('function')->nullable();
            $table->string('operator')->nullable();
            $table->string('value')->nullable();

            $table->index(['key'], 'key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_filter');
    }
}
