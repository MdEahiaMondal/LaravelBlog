<?php

use App\Category;
use App\Post;
use App\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class PostCategoryTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::all()->each(function (Post $post){
            $tags = Tag::all()->pluck('id')->toArray();
            $categories = Category::all()->pluck('id')->toArray();
            for ($i = 0; $i < random_int(2,5); $i++){
                $post->categories()->attach(Arr::random($categories));
                $post->tags()->attach(Arr::random($tags));
            }
        });
    }
}
