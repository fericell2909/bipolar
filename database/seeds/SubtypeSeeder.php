<?php

use Illuminate\Database\Seeder;

class SubtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Subtype::class)->create([
            'type_id' => 1,
            'name'    => 'Sandalia',
        ]);
        factory(\App\Models\Subtype::class)->create([
            'type_id' => 1,
            'name'    => 'Ballerina',
        ]);
        factory(\App\Models\Subtype::class)->create([
            'type_id' => 1,
            'name'    => 'Botín',
        ]);
        factory(\App\Models\Subtype::class)->create([
            'type_id' => 2,
            'name'    => 'Bolso',
        ]);
        factory(\App\Models\Subtype::class)->create([
            'type_id' => 2,
            'name'    => 'Llavero',
        ]);
    }
}
