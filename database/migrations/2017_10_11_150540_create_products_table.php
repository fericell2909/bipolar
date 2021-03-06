<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->string('slug', 300)->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 7, 2);
            $table->decimal('price_dolar', 7, 2);
            $table->decimal('weight', 7, 2)->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->boolean('free_shipping')->default(false);
            $table->timestamp('is_salient')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
