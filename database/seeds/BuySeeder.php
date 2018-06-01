<?php

use Illuminate\Database\Seeder;
use App\Models\Buy;
use App\Models\BuyDetail;

class BuySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Buy::class, 40)->create()->each(function ($buy) {
            $buy->details()->save(factory(BuyDetail::class)->make(['buy_id' => $buy->id]));
        });
    }
}
