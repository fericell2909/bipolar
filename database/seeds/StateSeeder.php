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
        factory(\App\Models\State::class)->create(['name' => 'Borrador', 'color' => 'secondary']);
        factory(\App\Models\State::class)->create(['name' => 'Pendiente de revisión', 'color' => 'danger']);
        factory(\App\Models\State::class)->create(['name' => 'Activo', 'color' => 'success']);
    }
}
