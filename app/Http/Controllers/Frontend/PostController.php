<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index($slug)
    {

         $post = Post::where('slug', $slug)->first();
        $randomPosts = Post::all()->random(3);

        return view('frontend.single-post.index', compact('post', 'randomPosts'));
    }
}
