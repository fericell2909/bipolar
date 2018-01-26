<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buys', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('billing_address_id');
            $table->unsignedInteger('shipping_address_id');
            $table->decimal('subtotal', 7, 2)->default(0.00);
            $table->decimal('total', 7, 2)->default(0.00);
            $table->decimal('total_dolar', 7, 2)->default(0.00);
            $table->timestamps();
        });

        Schema::table('buys', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('billing_address_id')->references('id')->on('addresses');
            $table->foreign('shipping_address_id')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buys');
    }
}
