<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function profile($username)
    {
        $author = User::where('username', $username)->first();
        $posts = $author->posts()->approved()->publication()->paginate(6);
        return view('frontend.posts.post_by_author', compact('author','posts'));
    }
}
