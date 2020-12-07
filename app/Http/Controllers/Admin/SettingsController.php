<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helpers;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.setting.index');
    }


    public function profileUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id . ',id',
            'image' => 'nullable:image',
            'about' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {

            $image = $request->file('image');

            $user = User::findOrFail(auth()->id());

            $slug = Str::slug($request->name, '-');

            if (isset($image)) {
                $image_url = Helpers::upload($request, 'image', '', 'users', 500, 500);
                if (Storage::exists($user->profileImage->path)) {
                    Storage::delete($user->profileImage->path);
                }
                $user->profileImage()->delete();
                $user->profileImage()->create([
                    'path' => $image_url
                ]);
            } else {
                $image_url = $user->profileImage->path;
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $slug;
            $user->about = $request->about;
            $user->image = $image_url;
            $user->save();

            DB::commit();

            Toastr::success('Profile Update Successfully Done !', 'Success');
            return redirect()->back();

        }catch (\Exception $exception){
            report($exception);
            DB::rollBack();
        }

    }


    public function passwordUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'currentPassword' => 'required',
            'password' => 'required|confirmed',
        ]);

        $hashedPassword = User::findOrFail($id)->password;


        if (Hash::check($request->currentPassword, $hashedPassword)) {

            if (!Hash::check($request->password, $hashedPassword)) {
                $user = User::findOrFail($id);
                $user->password = Hash::make($request->password);
                $user->save();

                Toastr::success('Password Update Successfully Done !', 'Success');
                auth()->logout();
                return redirect()->back();
            } else {
                Toastr::error('Current Password can not be same to old password', 'Error');
                return redirect()->back();
            }

        } else {
            Toastr::error('Current Password does not match ', 'Error');
            return redirect()->back();
        }


    }


}
