<?php

use App\Comment;
use App\Post;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::all()->each(function (Post $post){
            $comments = factory(Comment::class, random_int(5,20))->make();
            $post->comments()->saveMany($comments);
        });
    }
}
