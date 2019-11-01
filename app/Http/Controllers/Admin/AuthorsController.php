<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function index()
    {
        $authors = User::authors()
           ->withCount('posts')
           ->withCount('favorite_posts')
           ->withCount('comments')
           ->get();
       return view('admin.author.index', compact('authors'));
    }


    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        Toastr::success('Author Deleted Successfully', 'Success');
        return redirect()->back();
    }

}
