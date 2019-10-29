<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tag;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{

    public function index()
    {
        $tags = Tag::latest()->get();
        return view('admin.tag.index', compact('tags'));
    }


    public function create()
    {
       return view('admin.tag.create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
           'name' => 'required',
        ]);

       $data = new Tag();
       $data->name = $request->name;
       $data->slug = Str::slug($request->name, '-');
       $data->save();
        Toastr::success('Tag Successfully create !', 'Success');
       return redirect()->route('admin.tag.index');

    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $tag = Tag::find($id);
        return view('admin.tag.edit', compact('tag'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $tag = Tag::find($id);
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->name, '-');
        $tag->save();
        Toastr::success('Tag Updated Successfully', 'Success');
        return redirect()->route('admin.tag.index');
    }


    public function destroy($id)
    {
        dd();
        $tag = Tag::find($id);
        $tag->delete();
        Toastr::success('Tag Deleted Successfully', 'Success');
        return redirect()->route('admin.tag.index');
    }
}
