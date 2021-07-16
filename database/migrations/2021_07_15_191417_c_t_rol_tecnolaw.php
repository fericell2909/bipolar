<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CTRolTecnolaw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('roles')) {
            DB::table('managers')->insert([
                [
                    'email'    => 'samuelgonzales90@gmail.com',
                    'name'     => 'Samuel',
                    'role_id'  => 1,
                    'password' => bcrypt('bimita2020'),
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
