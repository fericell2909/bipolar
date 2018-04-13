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
            $table->unsignedInteger('discount')->nullable()->after('description');
            $table->decimal('price_discount', 7, 2)->nullable()->after('price');
            $table->decimal('price_dolar_discount', 7, 2)->nullable()->after('price_dolar');
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
            $table->dropColumn('discount', 'price_discount', 'price_dolar_discount');
        });
    }
}
