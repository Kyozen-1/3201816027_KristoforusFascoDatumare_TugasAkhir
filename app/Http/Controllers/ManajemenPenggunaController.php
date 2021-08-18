<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use App\Rules\MatchOldPassword;
use DB;
use Validator;
use DataTables;

class ManajemenPenggunaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        if($request->ajax())
        {
            $data = User::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function($data){
                    $button = '<button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-sm btn-clean btn-icon" title="Detail Data"><i class="la la-eye"></i></button>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" 
                    class="edit btn btn-sm btn-clean btn-icon" title="Edit Data"><i class="la la-pen"></i></button>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-sm btn-clean btn-icon" title="Delete Data"><i class="la la-trash"></i></button>';
                    return $button;
                })
                ->editColumn('role', function($data){
                    return $data->role->roles;
                })
                ->editColumn('avatar', function($data){
                    return '<img src="'.asset('images/avatars/'. $data->avatar).'" alt="" style="width: 5rem;">';
                })
                ->rawColumns(['actions', 'avatar', 'role'])
                ->make(true);
        }
        return view('backend.manpu.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function sesi(Request $request)
    {
        $image = $request->avatar;
        list($type, $image) = explode(';', $image);
        list(, $image)      = explode(',', $image);
        $image = base64_decode($image);
        $image_name= time().'.png';
        $path = public_path('/images/avatars/'.$image_name);
        $img = Image::make($image);
        $img->save($path, 60);
        session(['image'=>$image_name]);
    }
    
    public function store(Request $request)
    {
        $errors = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required | unique:users',
            'email' => 'required',
            'password' => 'required',
            'password_confirm' => 'required'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        if($request->password != $request->password_confirm)
        {
            return response()->json(['errors'=> 'Password harus sama!!!']);
        }

        $cek = User::where('username', $request->username)->first();
        if($cek != null)
        {
            return response()->json(['errors' => 'Username '.$request->username.' sudah ada']);
        } else {
            $user = User::insert([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'avatar' => $request->session()->get('image'),
                'remember_token' => uniqid()
            ]);

            $id = DB::getPdo()->lastInsertId();

            Role::create([
                'user_id' => $id,
                'roles' => $request->role
            ]);
            return response()->json(['success' => 'Berhasil sudah didaftar']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::where('user_id', $id)->first();
        $data = User::findOrFail($id);
        $array = [
            'role' => $role->roles,
            'name' => $data->name,
            'email' => $data->email,
            'username' => $data->username,
            'avatar' => $data->avatar
        ];
        return response()->json(['result' => $array]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required']
        ]);
        User::where('id', $request->edit_hidden_id)->update(['password' => Hash::make($request->new_password)]);
        return response()->json(['success' => 'Password berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->first();
        if(Auth::user()->id  == $user->id)
        {
            return response()->json(['errors'=>'Anda tidak dapat menghapus akun yang sedang anda gunakan']);
        } else {
            $role = Role::where('user_id', $id)->delete();
            $data = User::findOrFail($id);
            File::delete(public_path("images/avatars/$data->avatar"));
            $data->delete();
            return response()->json(['success'=>'Anda berhasil menghapus akun']);
        }
    }
}