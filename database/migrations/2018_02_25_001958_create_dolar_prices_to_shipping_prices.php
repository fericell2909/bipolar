<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDolarPricesToShippingPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shippings', function (Blueprint $table) {
            $table->decimal('g200_dolar', 7, 2)->nullable()->after('g200');
            $table->decimal('g500_dolar', 7, 2)->nullable()->after('g500');
            $table->decimal('kg1_dolar', 7, 2)->nullable()->after('kg1');
            $table->decimal('kg2_dolar', 7, 2)->nullable()->after('kg2');
            $table->decimal('kg3_dolar', 7, 2)->nullable()->after('kg3');
            $table->decimal('kg4_dolar', 7, 2)->nullable()->after('kg4');
            $table->decimal('kg5_dolar', 7, 2)->nullable()->after('kg5');
            $table->decimal('kg6_dolar', 7, 2)->nullable()->after('kg6');
            $table->decimal('kg7_dolar', 7, 2)->nullable()->after('kg7');
            $table->decimal('kg8_dolar', 7, 2)->nullable()->after('kg8');
            $table->decimal('kg9_dolar', 7, 2)->nullable()->after('kg9');
            $table->decimal('kg10_dolar', 7, 2)->nullable()->after('kg10');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shippings', function (Blueprint $table) {
            //
        });
    }
}
