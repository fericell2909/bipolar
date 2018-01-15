<?php

use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($talla = 20; $talla <= 30; $talla++) {
            factory(\App\Models\Size::class)->create(['name' => $talla]);
        }
    }
}
