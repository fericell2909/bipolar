<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('post_type_id');
            $table->unsignedInteger('state_id')->nullable();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('redirection_link', 1000)->nullable();
            $table->unsignedInteger('order')->default(0);
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
        Schema::dropIfExists('home_posts');
    }
}
