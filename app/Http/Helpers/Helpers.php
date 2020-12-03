<?php

namespace App\Http\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Helpers
{
    public static function upload(Request $request, $name = "image",$custom_name = '', $dir, $width, $height)
    {
        $image = $request->file($name);
        $extension = $image->getClientOriginalExtension();
        if ($custom_name){
            $imagePath = $image->storeAs($dir, $custom_name);
        }else{
            $imagePath = $image->store($dir);
        }
        $image = Image::make(Storage::get($imagePath))->resize($width, $height)->encode($extension, 100);
        Storage::put($imagePath, $image);
        return $imagePath;
    }

}
