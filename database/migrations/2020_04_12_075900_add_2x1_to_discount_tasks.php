<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add2x1ToDiscountTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discount_tasks', function (Blueprint $table) {
            $table->boolean('is_2x1')->after('product_types')->default(false);
            $table->unsignedInteger('discount_pen')->nullable()->change();
            $table->unsignedInteger('discount_usd')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discount_tasks', function (Blueprint $table) {
            $table->dropColumn('is_2x1');
            $table->unsignedInteger('discount_pen')->change();
            $table->unsignedInteger('discount_usd')->change();
        });
    }
}
