<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->string('menu_code');
            $table->string('menu_name')->nullable();
            $table->string('menu_module');
            $table->tinyInteger('menu_reset')->nullable()->default(1);
            $table->tinyInteger('menu_show')->nullable()->default(0);
            $table->tinyInteger('menu_active')->nullable()->default(1);

            $table->primary(['menu_code', 'menu_module']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
