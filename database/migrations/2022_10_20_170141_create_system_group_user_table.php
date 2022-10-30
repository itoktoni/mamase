<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemGroupUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_group_user', function (Blueprint $table) {
            $table->string('system_group_user_code')->primary();
            $table->string('system_group_user_name');
            $table->string('system_group_user_description')->nullable();
            $table->boolean('system_group_user_show')->nullable();
            $table->tinyInteger('system_group_user_level')->nullable();
            $table->string('system_group_user_dashboard')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_group_user');
    }
}
