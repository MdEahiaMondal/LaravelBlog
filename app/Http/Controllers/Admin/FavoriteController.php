<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $posts = auth()->user()->favorite_posts;
        return view('admin.favorite.index', compact('posts'));
    }
}
