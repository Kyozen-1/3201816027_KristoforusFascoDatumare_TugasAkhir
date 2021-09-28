<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentangWarnaZona;
use App\Models\Zona;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
use Validator;
use DataTables;
use Carbon\Carbon;

class RentangWarnaZonaController extends Controller
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
            $data = RentangWarnaZona::all();
            $zona = Zona::all();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function($data){
                $button = '<button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-sm btn-clean btn-icon" title="Detail Data"><i class="la la-eye"></i></button>';
                $button .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" 
                class="edit btn btn-sm btn-clean btn-icon" title="Edit Data"><i class="la la-pen"></i></button>';
                $button .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-sm btn-clean btn-icon" title="Delete Data"><i class="la la-trash"></i></button>';
                return $button;
            })
            ->addColumn('warna', function($data){
                $warna = '<input type="color" class="form-control" value="'.$data->hexa_warna.'" disabled>';
                return $warna;
            })
            ->editColumn('zona', function($data){
                return $data->zona->nama;
            })
            ->rawColumns(['actions','zona', 'warna'])
            ->make(true);
        }
        $zonas = Zona::pluck('nama', 'id');
        return view('backend.rentang_warna_zona.index', ['zonas' => $zonas]);
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
            'zona' => 'required',
            'nama' => 'required',
            'color' => 'required',
            'awal' => 'required | integer | min:0',
            'akhir' => 'required | integer | min:0'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $rentang_warna_zona = array(
            'zona_id' => $request->zona,
            'nama' => $request->nama,
            'hexa_warna' => $request->color,
            'awal' => $request->awal,
            'akhir' => $request->akhir
        );

        $rentang_warna_zona = RentangWarnaZona::firstOrCreate(
            $rentang_warna_zona
        );

        if($rentang_warna_zona->wasRecentlyCreated)
        {
            activity()->log('Menambah rentang warna zona '.$request->nama.' pada tanggal '.Carbon::now()->format('d M Y'));
            return response()->json(['success' => 'rentang warna zona ' .$request->nama. ' berhasil ditambahkan']);
        } else 
        {
            return response()->json(['errors' => 'rentang warna zona ' .$request->nama. ' sudah ada']);
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
            $data = RentangWarnaZona::findOrFail($id);
            $zona = Zona::findOrFail($data->zona_id);
            $array = [
                'zona' => $zona->nama,
                'nama' => $data->nama,
                'color' => $data->hexa_warna,
                'awal' => $data->awal,
                'akhir' => $data->akhir
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
            $data = RentangWarnaZona::findOrFail($id);
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
            'zona' => 'required',
            'nama' => 'required',
            'color' => 'required',
            'awal' => 'required | integer | min:0',
            'akhir' => 'required | integer | min:0'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $rentang_warna_zona_form = array(
            'zona_id' => $request->zona,
            'nama' => $request->nama,
            'hexa_warna' => $request->color,
            'awal' => $request->awal,
            'akhir' => $request->akhir
        );
        $zona = Zona::where('id', $request->hidden_id)->first();
        activity()->log('Merubah Kecamatan '.$zona->nama. ' menjadi '.$request->nama.' pada tanggal '.Carbon::now()->format('d M Y'));
        DB::table('rentang_warna_zona')->where('id', $request->hidden_id)->update($rentang_warna_zona_form);
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
        $rentang_warna_zona = RentangWarnaZona::where('id', $id)->first();
        activity()->log('Rentang warna'.$rentang_warna_zona->nama.' pada tanggal '.Carbon::now()->format('d M Y'));
        RentangWarnaZona::where('id', $id)->delete();
    }
}