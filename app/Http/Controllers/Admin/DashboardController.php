<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index()
   {
       $posts = Post::all();
       $popular_posts = Post::withCount('comments')
                       ->withCount('favorite_to_users')
                       ->orderBy('view_count', 'desc')
                       ->orderBy('favorite_to_users_count', 'desc')
                       ->orderBy('comments_count', 'desc')
                       ->take(5)
                       ->get();

        $total_pending = Post::where('is_approved', false)
                        ->count();
        $total_authors = User::authors()
                        ->count(); // authors() it is a scope method that defined to user model
        $total_post_view = Post::sum('view_count');
        $new_authors_today = User::authors()
                            ->whereDate('created_at', Carbon::today())
                            ->count();
        $active_authors = User::authors()
                           ->withCount('posts')
                           ->withCount('comments')
                           ->withCount('favorite_posts')
                           ->orderBy('favorite_posts_count', 'desc')
                           ->orderBy('comments_count', 'desc')
                           ->take(10)
                           ->get();
        $category_count = Category::all()->count();
        $tag_count = Tag::all()->count();
       $comments = Comment::all()->count();
       return view('admin.dashboard', compact('posts','popular_posts','total_pending','total_authors','total_post_view',
           'new_authors_today','active_authors','category_count','tag_count', 'comments'));
   }
}
