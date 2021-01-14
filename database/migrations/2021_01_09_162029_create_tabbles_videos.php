<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabblesVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('attachments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('alt')->nullable();
            $table->text('name_original')->nullable();
            $table->text('s3_url')->nullable();
            $table->string('folder_path')->nullable();
            $table->string('mime_type', 150)->nullable();

            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });

        Schema::dropIfExists('videos');

        Schema::create('videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('product_id')->nullable();
            $table->unsignedBigInteger('attachment_id');
            $table->string('url',500)->default('');
            $table->string('relative_url',500)->default('');
            $table->unsignedInteger('order');
            $table->foreign('product_id')
                      ->references('id')->on('products')
                      ->onDelete('no action')
                      ->onUpdate('no action');

            $table->foreign('attachment_id')
                      ->references('id')->on('attachments')
                      ->onDelete('no action')
                      ->onUpdate('no action');          
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
        Schema::dropIfExists('videos');
        Schema::dropIfExists('attachments');
    }
}
