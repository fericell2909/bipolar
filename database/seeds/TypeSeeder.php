<?php

use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Type::class)->create(['name' => ['es' => 'Zapatos', 'en' => 'Zapatos']]);
        factory(\App\Models\Type::class)->create(['name' => ['es' => 'Accesorios', 'en' => 'Accesorios']]);
    }
}
