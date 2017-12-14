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
            'name'    => [
                'es' => 'Sandalia',
                'en' => 'Sandalia',
            ],
        ]);
        factory(\App\Models\Subtype::class)->create([
            'type_id' => 1,
            'name'    => [
                'es' => 'Ballerina',
                'en' => 'Ballerina',
            ],
        ]);
        factory(\App\Models\Subtype::class)->create([
            'type_id' => 1,
            'name'    => [
                'es' => 'Botín',
                'en' => 'Botín',
            ],
        ]);
        factory(\App\Models\Subtype::class)->create([
            'type_id' => 2,
            'name'    => [
                'es' => 'Bolso',
                'en' => 'Bolso',
            ],
        ]);
        factory(\App\Models\Subtype::class)->create([
            'type_id' => 2,
            'name'    => [
                'es' => 'Llavero',
                'en' => 'Llavero',
            ],
        ]);
    }
}
