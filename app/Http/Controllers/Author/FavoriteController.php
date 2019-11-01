<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $posts = auth()->user()->favorite_posts;
        return view('author.favorite.index', compact('posts'));
    }
}
