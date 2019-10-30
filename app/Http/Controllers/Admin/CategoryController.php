<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }


    public function create()
    {
        return view('admin.category.create');
    }



    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories',
            'image' => 'required|mimes:jpg,jpeg,png,bmp'
        ]);

        $image = $request->file('image');
        $slug = Str::slug($request->name,'-');

        if (isset($image)){

            // set image name
            $currentDateTime = Carbon::now()->toDateString();
            $setImageName = $slug . '-' . $currentDateTime . '-' . uniqid(). '.' .$image->getClientOriginalExtension();


            // check  category dir is exists
            if (!Storage::disk('public')->exists('category')){ // you must be use stream()
                Storage::disk('public')->makeDirectory('category');
            }

            // resize image for category background and upload
            $category = Image::make($image)->resize(1600, 479)->stream();
            Storage::disk('public')->put('category/'.$setImageName,$category);



            // check  category slider dir is exists
            if (!Storage::disk('public')->exists('category/slider')){
                Storage::disk('public')->makeDirectory('category/slider');
            }

            // resize image for category  slider and upload
            $slider = Image::make($image)->resize(500, 333)->stream();
            Storage::disk('public')->put('category/slider/'.$setImageName,$slider);

        }else{
            $setImageName = "default.png";
        }


        $category = new Category();
        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $setImageName;
        $category->save();
        Toastr::success('Category Successfully create !', 'Success');
        return redirect()->route('admin.category.index');

    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name,'.$id.',id',
            'image' => 'mimes:jpg,jpeg,png,bmp'
        ]);

        $image = $request->file('image');
        $slug = Str::slug($request->name,'-');
        $category = Category::find($id);
        if (isset($image)){

            // set image name
            $currentDateTime = Carbon::now()->toDateString();
            $setImageName = $slug . '-' . $currentDateTime . '-' . uniqid(). '.' .$image->getClientOriginalExtension();


            // check  category dir is exists
            if (!Storage::disk('public')->exists('category')){ // you must be use stream()
                Storage::disk('public')->makeDirectory('category');
            }

            // delete old category background image
            if (Storage::disk('public')->exists('category')){
                Storage::disk('public')->delete('category/'.$category->image);
            }

            // resize image for category background and upload
            $categoryImage = Image::make($image)->resize(1600, 479)->stream();
            Storage::disk('public')->put('category/'.$setImageName,$categoryImage);



            // check  category slider dir is exists
            if (!Storage::disk('public')->exists('category/slider')){
                Storage::disk('public')->makeDirectory('category/slider');
            }

            // delete old category slider image
            if (Storage::disk('public')->exists('category/slider')){
                Storage::disk('public')->delete('category/slider/'.$category->image);
            }

            // resize image for category  slider and upload
            $sliderImage = Image::make($image)->resize(500, 333)->stream();
            Storage::disk('public')->put('category/slider/'.$setImageName,$sliderImage);

        }else{
            $setImageName = $category->image;
        }

        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $setImageName;
        $category->save();
        Toastr::success('Category Successfully Updated !', 'Success');
        return redirect()->route('admin.category.index');
    }


    public function destroy($id)
    {
        $category = Category::find($id);

        // delete category background image
        if (Storage::disk('public')->exists('category/'.$category->image)){
            Storage::disk('public')->delete('category/'.$category->image);
        }

        // delete category slider image
        if (Storage::disk('public')->exists('category/slider/'.$category->image)){
            Storage::disk('public')->delete('category/slider/'.$category->image);
        }


        $category->delete();
        Toastr::success('Category Successfully Deleted !', 'Success');
        return redirect()->route('admin.category.index');

    }
}
