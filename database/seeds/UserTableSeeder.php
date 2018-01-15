<?php

use Illuminate\Database\Seeder;
use App\Models\Cart;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        factory(\App\Models\User::class, 20)->create()->each(function ($u) {
            $u->carts()->save(factory(Cart::class)->make());
        });

        factory(\App\Models\User::class)->create([
            'email' => 'info@helmerdavila.com',
            'password' => bcrypt('123456'),
            'active' => now(),
        ]);
    }
}
