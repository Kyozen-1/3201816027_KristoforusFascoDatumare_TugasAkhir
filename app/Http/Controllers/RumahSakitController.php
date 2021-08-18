<?php

namespace App\Http\Controllers;

use App\Models\RS;
use App\Models\RS_Data;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
use Validator;
use DataTables;
use Carbon\Carbon;

class RumahSakitController extends Controller
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
            $data = RS::all();
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
        return view('backend.rs.index');
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
            'long' => 'required',
            'lat' => 'required'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        $rs_form = array(
            'nama' => $request->nama,
            'lng' => $request->long,
            'lat' => $request->lat
        );

        $rs = RS::firstOrCreate(
            $rs_form
        );

        if($rs->wasRecentlyCreated)
        {
            activity()->log('Menambah Rumah Sakit '.$request->nama.' pada tanggal '.Carbon::now()->format('d M Y'));
            return response()->json(['success' => 'Rumah Sakit ' .$request->nama. ' berhasil ditambahkan']);
        } else {
            return response()->json(['errors' => 'Rumah Sakit ' .$request->nama. ' sudah ada']);
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
        $data = RS::findOrFail($id);
        $array = [
            'nama' => $data->nama,
            'long' => $data->lng,
            'lat' => $data->lat
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
            $data = RS::findOrFail($id);
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
            'long' => 'required',
            'lat' => 'required'
        ]);

        if($errors -> fails()){
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        $rs_form = array(
            'nama' => $request->nama,
            'lng' => $request->long,
            'lat' => $request->lat
        );
        $rs = RS::where('id', $request->hidden_id)->first();
        activity()->log('Merubah Rumah Sakit '.$rs->nama. ' menjadi '.$request->nama.' pada tanggal '.Carbon::now()->format('d M Y'));
        DB::table('rs')->where('id', $request->hidden_id)->update($rs_form);
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
        $rs = RS::where('id', $id)->first();
        activity()->log('Menghapus Kelurahan '.$rs->nama.' pada tanggal '.Carbon::now()->format('d M Y'));
        RS_Data::where('id_rs', $id)->delete();
        RS::where('id', $id)->delete();
    }
}