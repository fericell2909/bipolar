<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingIncludesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_includes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shipping_id');
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('country_state_id')->nullable();
            $table->boolean('all_countries')->default(false);
        });

        Schema::table('shipping_includes', function (Blueprint $table) {
            $table->foreign('shipping_id')->references('id')->on('shippings');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('country_state_id')->references('id')->on('country_states');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_includes');
    }
}
