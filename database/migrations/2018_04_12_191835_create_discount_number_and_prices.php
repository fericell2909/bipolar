<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountNumberAndPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->date('end_discount')->nullable()->after('description');
            $table->date('begin_discount')->nullable()->after('description');
            $table->unsignedInteger('discount_usd')->nullable()->after('description');
            $table->unsignedInteger('discount_pen')->nullable()->after('description');
            $table->decimal('price_pen_discount', 7, 2)->nullable()->after('price');
            $table->decimal('price_usd_discount', 7, 2)->nullable()->after('price_dolar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(
                'begin_discount',
                'end_discount',
                'discount_usd',
                'discount_pen',
                'price_pen_discount',
                'price_usd_discount'
            );
        });
    }
}
