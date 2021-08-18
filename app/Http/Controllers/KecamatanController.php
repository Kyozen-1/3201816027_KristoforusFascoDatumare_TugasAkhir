<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use DataTables;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\C19_Klh;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __contruct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = Kecamatan::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function($data){
                    $button = '<button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-sm btn-clean btn-icon" title="Detail Data"><i class="la la-eye"></i></button>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" 
                    class="edit btn btn-sm btn-clean btn-icon" title="Edit Data"><i class="la la-pen"></i></button>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-sm btn-clean btn-icon" title="Delete Data"><i class="la la-trash"></i></button>';
                    return $button;
                })
                ->editColumn('jlh_klh', function($data){
                    $jlh_data = Kelurahan::where('id_kecamatan', $data->id)->count();
                    return $jlh_data;
                })
                ->rawColumns(['actions', 'jlh_klh'])
                ->make(true);
        }

        return view('backend.kecamatan.index');
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
            'nama' => 'required',
            'kord' => 'required'
        );
        $error = Validator::make($request->all(), $rules);
        if ($error->fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        $kecamatan_form = array(
            'nama' => $request->nama,
            'kord' => $request->kord
        );

        $kecamatan = Kecamatan::firstOrCreate(
            $kecamatan_form
        );

        if ($kecamatan->wasRecentlyCreated)
        {
            activity()->log('Menambah Kecamatan '.$request->nama.' pada tanggal '.Carbon::now()->format('d M Y'));
            return response()->json(['success' => 'Kecamatan ' .$request->nama.' berhasil ditambahkan']);
        } else
        {
            return response()->json(['errors' => 'Kecamatan ' .$request->nama.' sudah ada']);
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
            $data = Kecamatan::findOrFail($id);
            $jlh_klh = Kelurahan::where('id_kecamatan', $data->id)->count();
            $array = [
                'nama' => $data->nama,
                'jlh_klh' => $jlh_klh,
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
        if(request()->ajax()){
            $data = Kecamatan::findOrFail($id);
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
            'nama' => 'required',
            'kord' => 'required'
        );

        $errors = Validator::make($request->all(), $rules);
        if ($errors->fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        $kecamatan_form = array(
            'nama' => $request->nama,
            'kord' => $request->kord
        );
        $kct = Kecamatan::where('id', $request->hidden_id)->first();
        activity()->log('Merubah Kecamatan '.$kct->nama. ' menjadi '.$request->nama.' pada tanggal '.Carbon::now()->format('d M Y'));
        DB::table('kecamatan')->where('id', $request->hidden_id)->update($kecamatan_form);
        return response()->json(['success' => 'Berhasil diubah.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kecamatan = Kecamatan::where('id', $id)->first();

        $kelurahans = Kelurahan::where('id_kecamatan', $kecamatan->id)->get();

        foreach ($kelurahans as $kelurahan) {
            C19_Klh::where('id_kelurahan', $kelurahan->id)->delete();
        }
        activity()->log('Menghapus Kecamatan '.$kecamatan->nama.' pada tanggal '.Carbon::now()->format('d M Y'));
        Kelurahan::where('id_kecamatan', $kecamatan->id)->delete();
        Kecamatan::where('id', $id)->delete();
    }
}