<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationshipsToPostHomes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_posts', function (Blueprint $table) {
            $table->foreign('post_type_id')->references('id')->on('post_types');
            $table->foreign('state_id')->references('id')->on('states');
        });

        Schema::table('photos', function (Blueprint $table) {
            $table->foreign('home_post_id')->references('id')->on('home_posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
