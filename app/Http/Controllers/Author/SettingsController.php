<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class SettingsController extends Controller
{
    public function index()
    {
        return view('author.setting.index');
    }


    public function profileUpdate(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id.',id',
            'image' => 'nullable:image',
            'about' => 'nullable|string',
        ]);

        $image = $request->file('image');

        $user = User::findOrFail(auth()->id());
        $slug = Str::slug($request->name,'-');


        if (isset($image)){


            // set image name
            $currentdataTime = Carbon::now()->toDateString();
            $setImageName = $slug . '-' . $currentdataTime . '-' . uniqid() .'.'.$image->getClientOriginalExtension();


            // check dir
            if (!Storage::disk('public')->exists('profile')){
                Storage::disk('public')->makeDirectory('profile');
            }

            // delete old image
            if (Storage::disk('public')->exists('profile/'.$user->image)){
                Storage::disk('public')->delete('profile/'.$user->image);
            }

            // make image
            $profileImage = Image::make($image)->resize(500,500)->stream();

            // upload right dir
            Storage::disk('public')->put('profile/'.$setImageName,$profileImage);

        }else{
            $setImageName = $user->image;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $slug;
        $user->about = $request->about;
        $user->image = $setImageName;
        $user->save();

        Toastr::success('Profile Update Successfully Done !', 'Success');
        return redirect()->back();


    }



    public function passwordUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'currentPassword' => 'required',
            'password' => 'required|confirmed',
        ]);

        $hashedPassword = User::findOrFail($id)->password;


        if (Hash::check($request->currentPassword,$hashedPassword)){

            if (!Hash::check($request->password, $hashedPassword)){
                $user = User::findOrFail($id);
                $user->password = Hash::make($request->password);
                $user->save();

                Toastr::success('Password Update Successfully Done !', 'Success');
                auth()->logout();
                return redirect()->back();
            }else{
                Toastr::error('Current Password can not be same to old password', 'Error');
                return redirect()->back();
            }

        }else{
            Toastr::error('Current Password does not match ', 'Error');
            return redirect()->back();
        }



    }



}
