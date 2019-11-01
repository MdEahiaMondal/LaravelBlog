<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Post;
use Session;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::where(['is_approved'=> true, 'status'=>true])->paginate(12);
        return view('frontend.posts.index', compact('posts'));
    }

    public function singlePost($slug)
    {

         $post = Post::where('slug', $slug)->first();
        $randomPosts = Post::all()->random(3);

        // post view count
        $blogKey = "blog_".$post->id;
        if (!Session::has($blogKey)){
            $post->increment('view_count');
            Session::put($blogKey, 1);
        }

        return view('frontend.single-post.index', compact('post', 'randomPosts'));
    }
}
