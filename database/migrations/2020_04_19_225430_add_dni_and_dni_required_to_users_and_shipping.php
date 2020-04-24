<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDniAndDniRequiredToUsersAndShipping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('dni', 30)->nullable()->after('lastname');
        });

        Schema::table('shippings', function (Blueprint $table) {
            $table->boolean('is_dni_required')->default(false)->after('allow_showroom');
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
            $table->dropColumn('dni');
        });

        Schema::table('shippings', function (Blueprint $table) {
            $table->dropColumn('is_dni_required');
        });
    }
}
