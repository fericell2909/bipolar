<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\DB::table('colors')->count() > 0) {
            /** @var \App\Models\Color $randomColor */
            $randomColor = \DB::table('colors')->get()->random();

            factory(\App\Models\Product::class, 20)->create(['color_id' => $randomColor->id]);
        } else {
            factory(\App\Models\Product::class, 20)->create();
        }
    }
}
