<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('buy_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('stock_id')->nullable();
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedDecimal('total', 7, 2)->default(0);
            $table->unsignedDecimal('total_dolar', 7, 2)->default(0);
        });

        Schema::table('buy_details', function (Blueprint $table) {
            $table->foreign('buy_id')->references('id')->on('buys');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('stock_id')->references('id')->on('stocks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buy_details');
    }
}
