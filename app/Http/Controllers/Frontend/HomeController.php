<?php

namespace App\Http\Controllers\Frontend;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        $posts = Post::latest()->approved()->publication()->take(6)->get();  // where(['is_approved'=>true, 'status'=>true]) that is removed
                                                                                        // ,, now we use laravel local scope method in post model
        return view('frontend.welcome', compact('categories','posts'));
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
