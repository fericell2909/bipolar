<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShowroomSaleToUserAndProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('has_showroom_sale')->default(false)->after('language');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_showroom_sale')->default(false)->after('free_shipping');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('has_showroom_sale');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_showroom_sale');
        });
    }
}
