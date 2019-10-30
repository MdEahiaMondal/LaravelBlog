<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::latest()->get();
        return view('admin.post.index', compact('posts'));
    }


    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
       return view('admin.post.create', compact('categories', 'tags'));
    }


    public function store(Request $request)
    {
       $this->validate($request, [
          'title' => 'required|string',
          'image' => 'required|mimes:jpg,jpeg,png',
          'categories' => 'required',
          'tags' => 'required',
          'body' => 'required',
       ]);

       $image = $request->file('image');
        $slug = Str::slug($request->title,'-');
       if (isset($image)){

           // set image name
           $currentdataTime = Carbon::now()->toDateString();
           $setImageName = $slug . '-' . $currentdataTime . '-' . uniqid() .'.'.$image->getClientOriginalExtension();

           // check dir
           if (!Storage::disk('public')->exists('post')){
               Storage::disk('public')->makeDirectory('post');
           }

           // make image
           $postImage = Image::make($image)->resize(1600,1066)->stream();

           // upload right dir
           Storage::disk('public')->put('post/'.$setImageName,$postImage);

       }else{
           $setImageName = 'default.png';
       }

       $post = new Post();
       $post->user_id = auth()->id();
       $post->title = $request->title;
       $post->slug = $slug;
       $post->image = $setImageName;
       $post->body = $request->body;

       if (isset($request->status)){
           $post->status = true;
       }else{
           $post->status = false;
       }

       $post->is_approved = true;
       $post->save();

       $post->categories()->attach($request->categories);
       $post->tags()->attach($request->tags);

       Toastr::success('New Post Create Successfully Done !');
       return redirect()->route('admin.post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return  view('admin.post.show', compact('post'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.post.edit', compact('post','categories', 'tags'));
    }



    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'image' => 'image',
            'categories' => 'required',
            'tags' => 'required',
            'body' => 'required',
        ]);

        $image = $request->file('image');
        $slug = Str::slug($request->title,'-');
        if (isset($image)){

            // set image name
            $currentdataTime = Carbon::now()->toDateString();
            $setImageName = $slug . '-' . $currentdataTime . '-' . uniqid() .'.'.$image->getClientOriginalExtension();

            // check dir
            if (!Storage::disk('public')->exists('post')){
                Storage::disk('public')->makeDirectory('post');
            }

            // delete old image
            if (Storage::disk('public')->exists('post/'.$post->image)){
                Storage::disk('public')->delete('post/'.$post->image);
            }

            // make image
            $postImage = Image::make($image)->resize(1600,1066)->stream();

            // upload right dir
            Storage::disk('public')->put('post/'.$setImageName,$postImage);

        }else{
            $setImageName = $post->image;
        }

        $post->user_id = auth()->id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->image = $setImageName;
        $post->body = $request->body;

        if (isset($request->status)){
            $post->status = true;
        }else{
            $post->status = false;
        }

        $post->is_approved = true;
        $post->save();

        $post->categories()->sync($request->categories); // (sync) it delete old post tags and category and update new
        $post->tags()->sync($request->tags);

        Toastr::success('Post Update Successfully Done !');
        return redirect()->route('admin.post.index');
    }


    public function destroy(Post $post)
    {

            if ( Storage::disk('public')->exists('post/'.$post->image) ){
                Storage::disk('public')->delete('post/'.$post->image);
            }

            $post->categories()->detach(); // it will delete related category_post table
            $post->tags()->detach(); // it will delete related post_tag table

            $post->delete();
            Toastr::success('Post Deleted Successfully Done !');
            return redirect()->route('admin.post.index');

    }
}
