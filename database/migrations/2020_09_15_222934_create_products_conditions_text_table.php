<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateProductsConditionsTextTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_conditions_text', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->nullable();
            $table->mediumText('name')->nullable();
            $table->mediumText('description')->nullable();
            $table->json('products')->nullable();
            $table->boolean('available')->default(false);
            $table->timestamps();
        });

        Schema::table('products_conditions_text', function (Blueprint $table) {
            $table->uuid('uuid')->index()->nullable(false)->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_conditions_text');
    }
}
