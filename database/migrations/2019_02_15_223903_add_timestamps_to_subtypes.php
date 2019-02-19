<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimestampsToSubtypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subtypes', function (Blueprint $table) {
            $table->timestamps();
        });

        // Add a default creation date to subtypes to now
        \DB::table('subtypes')->update(['created_at' => now(), 'updated_at' => now()]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subtypes', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
}
