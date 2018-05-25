<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('discount_pen');
            $table->unsignedInteger('discount_usd');
            $table->dateTime('begin');
            $table->dateTime('end');
            $table->json('products')->nullable();
            $table->json('product_subtypes')->nullable();
            $table->json('product_types')->nullable();
            $table->boolean('available')->default(false);
            $table->boolean('executed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_tasks');
    }
}
