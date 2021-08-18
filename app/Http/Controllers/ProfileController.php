<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use Validator;
use App\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view ('backend.profile.index', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if($request->avatar)
        {
            $rules = array(
                'name' => 'required',
            );
            $error = Validator::make($request->all(), $rules);
            if($error->fails())
            {
                return back()->with('toast_error', $error->messages()->all()[0])->withInput();
            }

            $user = User::find($id);
            $avatarName = $user->avatar;
            File::delete(public_path('images/avatars/'.$avatarName));

            $extension = $request->avatar->extension();
            $avtName = uniqid().'.'.$extension;

            $avt = Image::make($request->avatar);
            $croppath = public_path('images/avatars/'.$avtName);
            $avt->save($croppath, 60);

            User::find($id)->update([
                'name' => $request->name,
                'avatar' => $avtName
            ]);

            return redirect("admin/dashboard")->with('success', 'Data Berhasil Diubah');
        } else
        {
            $rules = array(
                'name' => 'required',
            );
            $error = Validator::make($request->all(), $rules);
            if($error->fails()){
                return back()->with('toast_error', $error->messages()->all()[0])->withInput();
            }

            User::find($id)->update([
                'name'=>$request->name
            ]);

            return redirect("admin/dashboard")->with('success', 'Data Berhasil Diubah');
        }
    }
}