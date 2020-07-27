<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommonSizeIntstepWidthFootToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('photo');
            $table->decimal('common_size', 4, 2)->nullable()->after('dni');
            $table->unsignedSmallInteger('foot_width')->nullable()->after('dni');
            $table->unsignedSmallInteger('foot_instep')->nullable()->after('dni');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('photo')->nullable();
            $table->dropColumn('common_size');
            $table->dropColumn('foot_width');
            $table->dropColumn('foot_instep');
        });
    }
}
