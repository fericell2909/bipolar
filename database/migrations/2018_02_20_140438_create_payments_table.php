<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('buy_id');
            $table->string('auth_result', 20)->nullable();
            $table->string('auth_result_text', 40)->nullable();
            $table->string('auth_code', 20)->nullable();
            $table->string('error_code', 20)->nullable();
            $table->string('card_brand', 20)->nullable();
            $table->string('reference', 20)->nullable();
            $table->text('verification')->nullable();
            $table->timestamps();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('buy_id')->references('id')->on('buys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
