<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

class AddUuidToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id');
        });

        $products = DB::table('products')->get();

        foreach ($products as $product) {
            DB::table('products')
                ->where('id', $product->id)
                ->update(['uuid' => Str::uuid()]);
        }

        Schema::table('products', function (Blueprint $table) {
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
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
}
