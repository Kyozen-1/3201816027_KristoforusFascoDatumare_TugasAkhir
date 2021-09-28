<?php

namespace App\Http\Controllers;
use App\Models\Zona;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
use Validator;
use DataTables;
use Carbon\Carbon;

use Illuminate\Http\Request;

class ZonaController extends Controller
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
    public function index()
    {
        if(request()->ajax())
        {
            $data = Zona::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function($data){
                    $button = '<button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-sm btn-clean btn-icon" title="Detail Data"><i class="la la-eye"></i></button>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" 
                    class="edit btn btn-sm btn-clean btn-icon" title="Edit Data"><i class="la la-pen"></i></button>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-sm btn-clean btn-icon" title="Delete Data"><i class="la la-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('backend.zona.index');
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
    public function store(Request $request)
    {
        $errors = Validator::make($request->all(), [
            'nama' => 'required'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        $zona_form = array(
            'nama' => $request->nama
        );

        $zona = Zona::firstOrCreate(
            $zona_form
        );

        if($zona->wasRecentlyCreated)
        {
            activity()->log('Menambah Zona '.$request->nama.' pada tanggal '.Carbon::now()->format('d M Y'));
            return response()->json(['success' => 'Zona ' .$request->nama. ' berhasil ditambahkan']);
        } else {
            return response()->json(['errors' => 'Zona ' .$request->nama. ' sudah ada']);
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
        $data = Zona::findOrFail($id);
        $array = [
            'nama' => $data->nama
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
        if(request()->ajax())
        {
            $data = Zona::findOrFail($id);
            return response()->json(['result' => $data]);
        }
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
        $errors = Validator::make($request->all(), [
            'nama' => 'required'
        ]);

        if($errors -> fails()){
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        $zona_form = array(
            'nama' => $request->nama
        );
        $zona = Zona::where('id', $request->hidden_id)->first();
        activity()->log('Merubah Zona '.$zona->nama. ' menjadi '.$request->nama.' pada tanggal '.Carbon::now()->format('d M Y'));
        DB::table('zona')->where('id', $request->hidden_id)->update($zona_form);
        return response()->json(['success' => 'Berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $zona = Zona::where('id', $id)->first();
        activity()->log('Menghapus Zona '.$zona->nama.' pada tanggal '.Carbon::now()->format('d M Y'));
        Zona::where('id', $id)->delete();
    }
}