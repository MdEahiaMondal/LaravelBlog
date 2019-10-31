<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function add($id)
    {
        $user = auth()->user();

        $isFavorite = $user->favorite_posts()->where('post_id', $id)->count();
        if ($isFavorite == 0){
            $user->favorite_posts()->attach($id);
            Toastr::success('New Post Successfully Added to your Favorite List !', 'Success');
            return redirect()->back();
        }else{
            $user->favorite_posts()->detach($id);
            Toastr::warning('The Post Successfully Removed from your Favorite List !', 'Warning');
            return redirect()->back();
        }

    }
}
