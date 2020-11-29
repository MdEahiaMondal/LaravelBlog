<?php

namespace App\Http\Controllers\Frontend;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        $posts = Post::with('user', 'comments')->latest()->approved()->publication()->take(6)->get();  // where(['is_approved'=>true, 'status'=>true]) that is removed ... now we use laravel local scope method in post model
        $most_commented = Post::mostCommented()->take(5)->get();
        $most_active_users = User::withMostposts()->take(5)->get();
        $most_active_users_last_month = User::MostActiveUsersLastMonth()->take(5)->get();


        return view('frontend.welcome', compact(
            'categories','posts', 'most_commented',
            'most_active_users','most_active_users_last_month'
        ));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
