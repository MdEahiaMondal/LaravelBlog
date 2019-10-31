<?php

namespace App\Http\Controllers\Author;

use App\Category;
use App\Http\Controllers\Controller;
use App\Notifications\NewAuthorPost;
use App\Post;
use App\Tag;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{

    public function index()
    {
        $posts = auth()->user()->posts()->latest()->get();
        return view('author.post.index', compact('posts'));
    }



    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('author.post.create', compact('categories', 'tags'));
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

        $post->is_approved = false;
        $post->save();

        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);

        $AdminUsers = User::where('role_id', 1)->get();
        Notification::send($AdminUsers, new NewAuthorPost($post));

        Toastr::success('New Post Create Successfully Done !');
        return redirect()->route('author.post.index');
    }



    public function show(Post $post)
    {
        if($post->user_id != auth()->id())
        {
            Toastr::error('You are not authorized to access this post!', 'Error');
            return redirect()->back();
        }
        return  view('author.post.show', compact('post'));
    }


    public function edit(Post $post)
    {
        if($post->user_id != auth()->id())
        {
            Toastr::error('You are not authorized to access this post!', 'Error');
            return redirect()->back();
        }

        $categories = Category::all();
        $tags = Tag::all();
        return view('author.post.edit', compact('post','categories', 'tags'));
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

        $post->is_approved = false;
        $post->save();

        $post->categories()->sync($request->categories); // (sync) it delete old post tags and category and update new
        $post->tags()->sync($request->tags);

        Toastr::success('Post Update Successfully Done !');
        return redirect()->route('author.post.index');
    }



    public function destroy(Post $post)
    {

        if($post->user_id != auth()->id())
        {
            Toastr::error('You are not authorized to access this post!', 'Error');
            return redirect()->back();
        }

        if ( Storage::disk('public')->exists('post/'.$post->image) ){
            Storage::disk('public')->delete('post/'.$post->image);
        }

        $post->categories()->detach(); // it will delete related category_post table
        $post->tags()->detach(); // it will delete related post_tag table

        $post->delete();
        Toastr::success('Post Deleted Successfully Done !');
        return redirect()->route('author.post.index');
    }
}
