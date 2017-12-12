<?php

use Illuminate\Database\Seeder;

class HomePostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\PostType::class, 2)->create()->each(function ($postType) {
            factory(\App\Models\HomePost::class, 4)->create([
                'post_type_id' => $postType,
            ]);
        });
    }
}
