<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShippingFeeToBuys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buys', function (Blueprint $table) {
            $table->string('currency', 3)->default('PEN')->after('total');
            $table->decimal('shipping_fee', 7, 2)->nullable()->after('subtotal');
            $table->boolean('showroom')->default(false)->after('payed');
            $table->dropColumn('total_dolar');
        });

        Schema::table('buy_details', function (Blueprint $table) {
            $table->dropColumn('total_dolar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buys', function (Blueprint $table) {
            //
        });
    }
}
