<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->boolean('active');
            $table->decimal('g200', 7, 2)->nullable();
            $table->decimal('g500', 7, 2)->nullable();
            $table->decimal('kg1', 7, 2)->nullable();
            $table->decimal('kg2', 7, 2)->nullable();
            $table->decimal('kg3', 7, 2)->nullable();
            $table->decimal('kg4', 7, 2)->nullable();
            $table->decimal('kg5', 7, 2)->nullable();
            $table->decimal('kg6', 7, 2)->nullable();
            $table->decimal('kg7', 7, 2)->nullable();
            $table->decimal('kg8', 7, 2)->nullable();
            $table->decimal('kg9', 7, 2)->nullable();
            $table->decimal('kg10', 7, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shippings');
    }
}
