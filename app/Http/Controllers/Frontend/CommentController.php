<?php

namespace App\Http\Controllers\Frontend;

use App\Comment;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request,$id)
    {
        $this->validate($request, [
            'body' => 'required',
        ]);

        $comment = new Comment();
        $comment->user_id = auth()->id();
        $comment->post_id = $id;
        $comment->body = $request->body;
        $comment->save();

        Toastr::success('Comment Successfully Published !', 'Success');
        return redirect()->back();
    }
}
