<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
use Validator;
use DataTables;
use Carbon\Carbon;

class ColorController extends Controller
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
            $data = Color::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function($data){
                    $button = '<button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-sm btn-clean btn-icon" title="Detail Data"><i class="la la-eye"></i></button>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" 
                    class="edit btn btn-sm btn-clean btn-icon" title="Edit Data"><i class="la la-pen"></i></button>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-sm btn-clean btn-icon" title="Delete Data"><i class="la la-trash"></i></button>';
                    return $button;
                })
                ->addColumn('color', function($data){
                    $warna = '<input type="color" class="form-control" value="'.$data->color.'" disabled>';
                    return $warna;
                })
                ->rawColumns(['actions','color'])
                ->make(true);
        }
        return view('backend.color.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'nama' => 'required',
            'color' => 'required',
            'keterangan' => 'required'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        $color_form = array(
            'nama' => $request->nama,
            'color' => $request->color,
            'keterangan' => $request->keterangan
        );

        $color = Color::firstOrCreate(
            $color_form
        );

        if($color->wasRecentlyCreated)
        {
            activity()->log('Menambah Warna '.$request->nama.' pada tanggal '.Carbon::now()->format('d M Y'));
            return response()->json(['success' => 'Warna ' .$request->nama. ' berhasil ditambahkan']);
        } else {
            return response()->json(['errors' => 'Warna ' .$request->nama. ' sudah ada']);
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
        $data = Color::findOrFail($id);
        $array = [
            'nama' => $data->nama,
            'color' => $data->color,
            'keterangan' => $data->keterangan
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
            $data = Color::findOrFail($id);
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
            'nama' => 'required',
            'color' => 'required',
            'keterangan' => 'required'
        ]);

        if($errors -> fails()){
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        $color_form = array(
            'nama' => $request->nama,
            'color' => $request->color,
            'keterangan' => $request->keterangan
        );
        $color = Color::where('id', $request->hidden_id)->first();
        activity()->log('Merubah Warna '.$color->nama. ' menjadi '.$request->nama.' pada tanggal '.Carbon::now()->format('d M Y'));
        DB::table('colors')->where('id', $request->hidden_id)->update($color_form);
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
        $color = Color::where('id', $id)->first();
        activity()->log('Menghapus Warna '.$color->nama.' pada tanggal '.Carbon::now()->format('d M Y'));
        Color::where('id', $id)->delete();
    }
}