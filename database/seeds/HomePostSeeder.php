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
            ])->each(function ($post) {
                /** @var \App\Models\HomePost $post */
                return $post->photos()->saveMany(factory(\App\Models\Photo::class, 3)->make());
            });
        });
    }
}
