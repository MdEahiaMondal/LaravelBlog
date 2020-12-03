<?php

namespace App\Http\Controllers\Frontend;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use Illuminate\Support\Facades\Cache;
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
        $post = Post::with('user', 'comments', 'comments.user', 'tags', 'favorite_to_users', 'categories')->where('slug', $slug)->approved()->publication()->first();
        $randomPosts = Post::with('user', 'comments', 'tags', 'favorite_to_users')->approved()->publication()->take(3)->inRandomOrder()->get();  // it {{ all()->random(3) }} remove

        // post view count
        $blogKey = "blog_" . $post->id;
        if (!Session::has($blogKey)) {
            $post->increment('view_count');
            Session::put($blogKey, 1);
        }

        $sessionId = session()->getId(); // get current user session id (it is unique for every user, it is predefine value)
        $counterKey = "blog-post-{$post->id}-counter"; // those key ($counterKey, $usersKey) who would be cache keys from which we will then read and store the counter. So how many user on the page
        $usersKey = "blog-post-{$post->id}-users"; // this key would be used to fetch and store the information about the users that visit the page

        $users = Cache::get($usersKey, []);
        $usersUpdate = []; // push user information (key, time)
        $difference = 0; // it is real counter
        $now = now(); // it is carbon function get present time

        foreach ($users as $sessionIdKey => $lastVisitTime) { // if old user visit time over one minute
            if ($now->diffInMinutes($lastVisitTime) >= 1) { // if over one minute  then counter decries
                $difference--;
            } else { // if not
                $usersUpdate[$sessionIdKey] = $lastVisitTime; // update old
            }
        }
        if (!array_key_exists($sessionId, $users) || $now->diffInMinutes($users[$sessionId])) { // if not present user key or user is preset many time
            $difference++;
        }

        $usersUpdate[$sessionId] = $now; // add every user info

        Cache::forever($usersKey, $usersUpdate);

        if (!Cache::has($counterKey)) { // if counterkey is not present
            Cache::forever($counterKey, 1); // add one count
        } else {
            Cache::increment($counterKey, $difference); // or increment
        }
        $counter = Cache::get($counterKey);

        return view('frontend.single-post.index', compact('post', 'randomPosts', 'counter'));
    }


    public function postByCategoory($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $posts = $category->posts()->approved()->publication()->get();

        return view('frontend.posts.post_by_category', compact('posts', 'category'));
    }


    public function postByTag($slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        $posts = $tag->posts()->approved()->publication()->get();
        return view('frontend.posts.post_by_tag', compact('posts', 'tag'));
    }


}
