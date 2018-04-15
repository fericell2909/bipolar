<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('type_id');
            $table->string('code')->unique();
            $table->unsignedInteger('amount')->default(0);
            $table->unsignedInteger('frequency')->default(0);
            $table->dateTime('begin');
            $table->dateTime('end');
            $table->timestamps();
        });

        Schema::table('coupons', function (Blueprint $table) {
            $table->foreign('type_id')->references('id')->on('coupon_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
        });

        Schema::dropIfExists('coupons');
    }
}
