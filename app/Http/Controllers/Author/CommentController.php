<?php

namespace App\Http\Controllers\Author;

use App\Comment;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CommentController extends Controller
{
       public function index()
       {
           $comments = auth()->user()->comments;
           return view('author.comment.index', compact('comments'));
       }


       public function destroy($id)
       {
           $comment = Comment::findOrFail($id);

           if ($comment->user->id == auth()->id()){
               $comment->delete();
               Toastr::success('Comment Deleted Successfully Done !', 'Success');
           }else{
               Toastr::warning('Your are not authorized to delete thie comment', 'Warning');
           }

           return redirect()->back();

       }



}
