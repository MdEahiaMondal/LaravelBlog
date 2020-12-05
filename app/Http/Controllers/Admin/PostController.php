<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Helpers;
use App\Http\Requests\PostRequest;
use App\Notifications\AuthorPostApproved;
use App\Notifications\NewPostNotify;
use App\Post;
use App\Subscriber;
use App\Tag;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
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


    public function store(PostRequest $request)
    {

        DB::beginTransaction();

        try {
            $post = Post::create([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'body' => $request->body,
                'status' => $request->status ? true : false,
                'is_approved' => true,
            ]);

            $post->categories()->attach($request->categories);
            $post->tags()->attach($request->tags);

            // upload an image using helper function
            $image_url = Helpers::upload($request, 'image', '', 'posts', 1600, 1066);
            $post->image()->create([ // save an image
                'path' => $image_url
            ]);

            /*
            $subscribers = Subscriber::all();
            $image_url = Helpers::upload($request, 'image', '' , 'posts', 1600, 1066);

            /* On-Demand Notifications
                 Sometimes you may need to send a notification to
                 someone who is not stored as a "user" of your application.
                Using the Notification::route method, you may specify ad-hoc
                 notification routing information before
                sending the notification:*/

            /* foreach ($subscribers as $subscriber) {

                 Notification::route('mail', $subscriber->email)->notify(new NewPostNotify($post));
             }*/

            Toastr::success('New Post Create Successfully Done !');

            DB::commit();

            return redirect()->route('admin.posts.index');

        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return Application|Factory|Response|View
     */
    public function show(Post $post)
    {
        return view('admin.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     * @return Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.post.edit', compact('post', 'categories', 'tags'));
    }


    public function update(PostRequest $request, Post $post)
    {


        DB::beginTransaction();

        try {

            $post->update([
                'title' => $request->title,
                'body' => $request->body,
                'status' => isset($request->status) ? true : $post->status,
            ]);

            $post->categories()->sync($request->categories); // (sync) it delete old post tags and category and update new
            $post->tags()->sync($request->tags);

            if ($request->hasFile('image')) {
                if (Storage::exists($post->image->path)) {
                    Storage::delete($post->image->path);
                }
                // upload new one
                $image_url = Helpers::upload($request, 'image', '', 'posts', 1600, 1066);

            } else {
                $image_url = $post->image->path;
            }

            $post->image()->update([ // save an image
                'path' => $image_url,
            ]);

            DB::commit();

            Toastr::success('Post Update Successfully Done !');
            return redirect()->route('admin.post.index');

        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }

    }


    public function pending()
    {
        $posts = Post::where('is_approved', false)->get();
        return view('admin.post.pending', compact('posts'));
    }


    public function approval(Post $post)
    {
        if ($post->is_approved == false) {
            $post->is_approved = true;
            $post->save();

//            $post->user->notify(new AuthorPostApproved($post));

            /*   $subscribers = Subscriber::all();*/
            /* // On-Demand Notifications
     Sometimes you may need to send a notification to
     someone who is not stored as a "user" of your application.
    Using the Notification::route method, you may specify ad-hoc
     notification routing information before
            sending the notification:*/

            /* foreach ($subscribers as $subscriber) {

                 Notification::route('mail', $subscriber->email)->notify(new NewPostNotify($post));
             }*/

            Toastr::success('Post Approved Successfully', 'Success');
        } else {
            Toastr::info('Post Already Approved ', 'Warning');
        }

        return redirect()->back();
    }


    public function destroy(Post $post)
    {

        if (Storage::exists($post->image->path)) {
            Storage::delete($post->image->path);
        }

        $post->categories()->detach(); // it will delete related category_post table
        $post->tags()->detach(); // it will delete related post_tag table
        $post->image()->delete(); // it will delete related images table

        $post->delete();
        Toastr::success('Post Deleted Successfully Done !');
        return redirect()->route('admin.posts.index');

    }
}
