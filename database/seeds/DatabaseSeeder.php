<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (config('app.env') === 'production') {
            $this->call(CountriesTableSeeder::class);
            $this->call(CountryStatesTableSeeder::class);
            $this->call(StateSeeder::class);
        } else {
            $this->call(UserTableSeeder::class);
            $this->call(SizeSeeder::class);
            $this->call(ColorSeeder::class);
            $this->call(StateSeeder::class);
            $this->call(TypeAndSubTypeSeeder::class);
            $this->call(ProductSeeder::class);
            $this->call(HomePostSeeder::class);
            $this->call(BannerSeeder::class);
            $this->call(CountriesTableSeeder::class);
            $this->call(CountryStatesTableSeeder::class);
            $this->call(HistoricSeeder::class);
            $this->call(CategorySeeder::class);
            $this->call(TagSeeder::class);
            $this->call(PostSeeder::class);
            $this->call(BuySeeder::class);
        }
    }
}
