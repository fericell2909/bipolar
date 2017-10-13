<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColorsProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colors_products', function (Blueprint $table) {
            $table->unsignedInteger('color_id');
            $table->unsignedInteger('product_id');
        });

        Schema::table('colors_products', function (Blueprint $table) {
            $table->foreign('color_id')->references('id')->on('colors');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
