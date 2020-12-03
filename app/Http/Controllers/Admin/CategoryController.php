<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Helpers;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
            'background_image' => 'required|mimes:jpg,jpeg,png,bmp|max:1024',/*|dimensions:min_width=1600,min_height=479*/
            'slider_image' => 'required|mimes:jpg,jpeg,png,bmp|max:1024'
        ]);

        DB::beginTransaction();
        try {

            $category = Category::create([
                'name' => $request->name
            ]);

            $bg_image = $request->file('background_image');
            $sl_image = $request->file('slider_image');

            if ($bg_image && $sl_image) {
                $bg_image_url = Helpers::upload($request, 'background_image', '', 'categories', 1600, 479);
                $sl_image_url = Helpers::upload($request, 'slider_image', '', 'categories', 500, 333);
            }

            $images = [
                ['path' => $bg_image_url, 'cat_type' => 'background'],
                ['path' => $sl_image_url, 'cat_type' => 'slider']
            ];


            $category->images()->createMany($images);

            DB::commit();

//            smilify('success', 'Category Successfully created');

            Toastr::success('Category Successfully create !', 'Success');

            return redirect()->route('admin.category.index');

        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            notify()->error($exception->getMessage());
            return redirect()->back();
        }


    }

    public function show(Category $category)
    {
        //
    }


    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }


    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name,' . $category->id . ',id',
            'background_image' => 'sometimes|mimes:jpg,jpeg,png,bmp|max:1024',/*|dimensions:min_width=1600,min_height=479*/
            'slider_image' => 'sometimes|mimes:jpg,jpeg,png,bmp|max:1024'
        ]);

        DB::beginTransaction();

        try {

            $category->name = $request->name;
            $category->save();

            if ($request->hasFile('background_image')) {

                if (Storage::exists($category->BgImg())) {
                    Storage::delete($category->BgImg());
                }
                $bg_image_url = Helpers::upload($request, 'background_image', '', 'categories', 1600, 479);
            } else {
                $bg_image_url = $category->BgImg();
            }

            if ($request->hasFile('slider_image')) {

                if (Storage::exists($category->SliderImg())) {
                    Storage::delete($category->SliderImg());
                }
                $sl_image_url = Helpers::upload($request, 'slider_image', '', 'categories', 500, 333);
            } else {
                $sl_image_url = $category->SliderImg();
            }

            $images = [
                ['path' => $bg_image_url, 'cat_type' => 'background'],
                ['path' => $sl_image_url, 'cat_type' => 'slider']
            ];

            $category->images()->delete();
            $category->images()->createMany($images);

            DB::commit();

            Toastr::success('Category Successfully Updated !', 'Success');
            return redirect()->route('admin.category.index');

        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            notify()->error($exception->getMessage());
            return redirect()->back();
        }


    }


    public function destroy(Category $category)
    {
        if (Storage::exists($category->SliderImg())) {
            Storage::delete($category->SliderImg());
        }
        if (Storage::exists($category->BgImg())) {
            Storage::delete($category->BgImg());
        }
        $category->delete();
        Toastr::success('Category Successfully Deleted !', 'Success');
        return redirect()->route('admin.category.index');

    }
}
