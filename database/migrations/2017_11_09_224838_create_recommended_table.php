<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecommendedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommendeds', function (Blueprint $table) {
            $table->unsignedInteger('parent_product_id');
            $table->unsignedInteger('recommended_product_id');
        });

        Schema::table('recommendeds', function (Blueprint $table) {
            $table->foreign('parent_product_id')->references('id')->on('products');
            $table->foreign('recommended_product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recommendeds', function (Blueprint $table) {
            if (\DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['parent_product_id']);
                $table->dropForeign(['recommended_product_id']);
            }
        });

        Schema::dropIfExists('recommendeds');
    }
}
