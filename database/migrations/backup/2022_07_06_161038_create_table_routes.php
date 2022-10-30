<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRoutes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->string('route_code')->primary();
            $table->string('route_name');
            $table->tinyInteger('route_sort')->default(0);
            $table->string('route_group');
            $table->string('route_controller');
            $table->tinyInteger('route_active')->default(1);
            $table->tinyInteger('route_report')->default(0);
            $table->string('route_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_routes');
    }
}
