<?php

use App\Category;
use App\Post;
use App\Tag;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        Post::all()->each(function (Post $post) use($faker){
            $post->image()->create([
                'path' => $faker->imageUrl(1600,1066)
            ]);
        });
    }
}
