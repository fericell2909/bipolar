<?php

use Illuminate\Database\Seeder;

class TypeAndSubTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Type::class)->create([
            'name' => [
                'es' => 'Zapatos',
                'en' => 'Zapatos',
            ],
        ])
            ->each(function ($t) {
                /** @var \App\Models\Type $t */
                $t->subtypes()->save(factory(\App\Models\Subtype::class)->make([
                    'name' => [
                        'es' => 'Sandalia',
                        'en' => 'Sandalia',
                    ],
                ]));
                $t->subtypes()->save(factory(\App\Models\Subtype::class)->make([
                    'name' => [
                        'es' => 'Ballerina',
                        'en' => 'Ballerina',
                    ],
                ]));
            });
        factory(\App\Models\Type::class)->create([
            'name' => [
                'es' => 'Accesorios',
                'en' => 'Accesorios',
            ],
        ])->each(function ($t) {
            /** @var \App\Models\Type $t */
            $t->subtypes()->save(factory(\App\Models\Subtype::class)->make([
                'name' => [
                    'es' => 'Bolso',
                    'en' => 'Bolso',
                ],
            ]));
            $t->subtypes()->save(factory(\App\Models\Subtype::class)->make([
                'name' => [
                    'es' => 'Llavero',
                    'en' => 'Llavero',
                ],
            ]));
        });
    }
}
