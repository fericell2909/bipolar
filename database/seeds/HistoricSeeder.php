<?php

use Illuminate\Database\Seeder;
use App\Models\Historic;

class HistoricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 100) as $number) {
            factory(Historic::class)->create([
                'name' => $number,
                'order' => $number,
            ]);
        }
    }
}
