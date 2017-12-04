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
        $this->call(UserTableSeeder::class);
        $this->call(SizeSeeder::class);
        $this->call(ColorSeeder::class);
        //$this->call(PhotoSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(SubtypeSeeder::class);
        $this->call(ProductSeeder::class);
    }
}
