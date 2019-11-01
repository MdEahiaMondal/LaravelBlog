<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('searchText');
        $posts = Post::where('title', 'LIKE', "%$query%")->approved()->publication()->get();
        return view('frontend.posts.search', compact('posts', 'query'));
    }
}
