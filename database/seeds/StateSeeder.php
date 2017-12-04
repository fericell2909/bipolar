<?php

use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\State::class)->create(['name' => 'Borrador']);
        factory(\App\Models\State::class)->create(['name' => 'Pendiente de revisión']);
        factory(\App\Models\State::class)->create(['name' => 'Activo']);
    }
}
