<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $posts = $user->posts;
        $popular_posts = $user->posts()
          ->withCount('comments')
          ->withCount('favorite_to_users')
          ->orderBy('view_count', 'desc')
          ->orderBy('favorite_to_users_count', 'desc')
          ->orderBy('comments_count', 'desc')
          ->take(5)
          ->get();
        $total_pending = $posts->where('is_approved', false)->count();
        $total_post_view = $posts->sum('view_count');


        return view('author.dashboard', compact('user','posts','popular_posts','total_pending', 'total_post_view'));
    }
}
