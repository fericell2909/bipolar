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
            $table->decimal('amount_pen', 7, 2);
            $table->decimal('amount_usd', 7, 2);
            $table->unsignedInteger('frequency')->default(0);
            $table->decimal('minimum_pen', 7, 2);
            $table->decimal('minimum_usd', 7, 2);
            $table->dateTime('begin');
            $table->dateTime('end');
            $table->json('products')->nullable();
            $table->json('product_subtypes')->nullable();
            $table->json('product_types')->nullable();
            $table->boolean('discounted_products')->default(false);
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
            if (\DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['type_id']);
            }
        });

        Schema::dropIfExists('coupons');
    }
}
