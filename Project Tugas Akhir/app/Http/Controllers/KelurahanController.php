<?php

namespace App\Http\Controllers;

use App\Models\Kelurahan;
use App\Models\Kecamatan;
use App\Models\C19_Klh;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
use Validator;
use DataTables;
use Carbon\Carbon;

class KelurahanController extends Controller
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
        if($request->ajax()){
            $kecamatan = Kecamatan::all();
            $data = Kelurahan::all();
            
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function($data){
                $button = '<button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-sm btn-clean btn-icon" title="Detail Data"><i class="la la-eye"></i></button>';
                $button .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" 
                class="edit btn btn-sm btn-clean btn-icon" title="Edit Data"><i class="la la-pen"></i></button>';
                $button .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-sm btn-clean btn-icon" title="Delete Data"><i class="la la-trash"></i></button>';
                return $button;
            })
            ->editColumn('kecamatan', function($data){
                return $data->kecamatan->nama;
            })
            ->rawColumns(['actions','kecamatan'])
            ->make(true);
        }
        $kecamatan = Kecamatan::all();
        return view('backend.kelurahan.index', compact('kecamatan'));
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
        $rules = array(
            'kecamatan' => 'required',
            'nama' => 'required',
            'koordinat' => 'required'
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $kelurahan_form = array(
            'id_kecamatan' => $request->kecamatan,
            'nama' => $request->nama,
            'kord' => $request->koordinat
        );

        $kelurahan = Kelurahan::firstOrCreate(
            $kelurahan_form
        );

        if($kelurahan->wasRecentlyCreated)
        {
            activity()->log('Menambah Kelurahan '.$request->nama.' pada tanggal '.Carbon::now()->format('d M Y'));
            return response()->json(['success' => 'Kelurahan ' .$request->nama. ' berhasil ditambahkan']);
        } else 
        {
            return response()->json(['errors' => 'Kelurahan ' .$request->nama. ' sudah ada']);
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
        if(request()->ajax())
        {
            $data = Kelurahan::findOrFail($id);
            $kct = Kecamatan::findOrFail($data->id_kecamatan);
            $array = [
                'kecamatan' => $kct->nama,
                'nama' => $data->nama,
                'kord' => $data->kord
            ];
            return response()->json(['result' => $array]);
        }
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
            $data = Kelurahan::findOrFail($id);
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
        $rules = array(
            'kecamatan' => 'required',
            'nama' => 'required',
            'koordinat' => 'required'
        );

        $errors = Validator::make($request->all(), $rules);
        if ($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        $kelurahan_form = array(
            'id_kecamatan' => $request->kecamatan,
            'nama' => $request->nama,
            'kord' => $request->koordinat
        );
        $klh = Kelurahan::where('id', $request->hidden_id)->first();
        activity()->log('Merubah Kecamatan '.$klh->nama. ' menjadi '.$request->nama.' pada tanggal '.Carbon::now()->format('d M Y'));
        DB::table('kelurahan')->where('id', $request->hidden_id)->update($kelurahan_form);
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
        $klh = Kelurahan::where('id', $id)->first();
        activity()->log('Menghapus Kelurahan '.$klh->nama.' pada tanggal '.Carbon::now()->format('d M Y'));
        C19_Klh::where('id_kelurahan', $id)->delete();
        Kelurahan::where('id', $id)->delete();
    }
}