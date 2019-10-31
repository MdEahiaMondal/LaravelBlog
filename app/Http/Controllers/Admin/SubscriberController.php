<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Subscriber;
use Brian2694\Toastr\Facades\Toastr;

class SubscriberController extends Controller
{
   public function index()
   {
       $subscribers = Subscriber::latest()->get();
       return view('admin.subscriber.index', compact('subscribers'));
   }


   public function destroy($id)
   {
       $subscribe = Subscriber::findOrFail($id);
       $subscribe->delete();
       Toastr::success('Subscriber Deleted Successfully Done !');
       return redirect()->back();
   }
}
