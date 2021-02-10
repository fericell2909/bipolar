<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOrderCountryStates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('country_states', function (Blueprint $table) {
            $table->integer('order')->default(0);
        });


        $countries = DB::table('countries')->get();

        foreach($countries as $country ) {

            $country_states = DB::table('country_states')->where('country_id',$country->id)->get();
            $order = 1;
            $order_lima_provincia = 0;
            foreach($country_states as $country_state){

                // se reserva un order para Lima - Provincias ---
                // lima metropolitana y lima provincias deben aparecer juntos.
                if($country_state->id == 2826) {
                    $order_lima_provincia =  $order;
                    $order = $order  + 1;  
                    
                }

                if($country_state->id == 4121) {
                    DB::table('country_states')
                    ->where('id', $country_state->id)
                    ->update(['order' =>  $order_lima_provincia]);
                } else {

                    DB::table('country_states')
                    ->where('id', $country_state->id)
                    ->update(['order' => $order]);

                }
                    $order = $order  + 1;
            }
        }

        // 

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('country_states', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
}
