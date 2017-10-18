<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoleIdManagers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('managers', function (Blueprint $table) {
            $table->unsignedInteger('role_id')->after('id')->nullable();
        });

        Schema::table('managers', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
        });

        if (Schema::hasTable('roles')) {
            DB::table('managers')->insert([
                [
                    'email'    => 'andrea.guzmangarcia@gmail.com',
                    'name'     => 'Andrea',
                    'role_id'  => 1,
                    'password' => bcrypt('123456'),
                ],
                [
                    'email'    => 'info@helmerdavila.com',
                    'name'     => 'Helmer',
                    'role_id'  => 1,
                    'password' => bcrypt('123456'),
                ],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
