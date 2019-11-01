<?php

namespace App\Http\Controllers\Frontend;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use Session;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::latest()->approved()->publication()->paginate(12); //  {{  where(['is_approved'=> true, 'status'=>true])  }}   i will use scope in post model
        return view('frontend.posts.index', compact('posts'));
    }

    public function singlePost($slug)
    {
        $post = Post::where('slug', $slug)->approved()->publication()->first();
        $randomPosts = Post::approved()->publication()->take(3)->inRandomOrder()->get();  // it {{ all()->random(3) }} remove

        // post view count
        $blogKey = "blog_".$post->id;
        if (!Session::has($blogKey)){
            $post->increment('view_count');
            Session::put($blogKey, 1);
        }

        return view('frontend.single-post.index', compact('post', 'randomPosts'));
    }


    public function postByCategoory($slug)
    {
         $category = Category::where('slug',$slug)->first();
         $posts = $category->posts()->approved()->publication()->get();

         return view('frontend.posts.post_by_category', compact('posts','category'));
    }



    public function postByTag($slug)
    {
         $tag = Tag::where('slug',$slug)->first();
         $posts = $tag->posts()->approved()->publication()->get();
         return view('frontend.posts.post_by_tag', compact('posts','tag'));
    }


}
