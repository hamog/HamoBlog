<?php

use App\Post;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Post::class, 100)->create()->each(function ($post) {
            $post->tags()->attach(\App\Tag::inRandomOrder()->take(3)->pluck('id')->toArray());
        });
    }
}
