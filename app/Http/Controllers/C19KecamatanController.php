<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\C19_Klh;
use DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use DB;

class C19KecamatanController extends Controller
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
        $kecamatans = Kecamatan::all();
        return view('backend.c19_kct.index', compact('kecamatans'));
    }

    public function pontura(Request $request)
    {
        if(request()->ajax())
        {
            if(!empty($request->tgl1))
            {
                $kelurahans = Kelurahan::where('id_kecamatan', 1)->get();
                foreach($kelurahans as $klh) {
                    $data[] = C19_Klh::where('id_kelurahan', $klh->id)->where('tgl', $request->tgl1)->first();
                }
            } else {
                $kelurahans = Kelurahan::where('id_kecamatan', 1)->get();
                foreach($kelurahans as $klh) {
                    $data[] = C19_Klh::where('id_kelurahan', $klh->id)->orderBy('created_at', 'desc')->first();
                }                
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('kelurahan', function($data){
                    return $data->kelurahan->nama;
                })
                ->rawColumns(['kelurahan'])
                ->make(true);
        }
    }
    public function pontur(Request $request)
    {
        if(request()->ajax())
        {
            if(!empty($request->tgl2)){
                $kelurahans = Kelurahan::where('id_kecamatan', 2)->get();
                foreach($kelurahans as $klh) {
                    $data[] = C19_Klh::where('id_kelurahan', $klh->id)->where('tgl', $request->tgl2)->first();
                }
            } else {
                $kelurahans = Kelurahan::where('id_kecamatan', 2)->get();
                foreach($kelurahans as $klh) {
                    $data[] = C19_Klh::where('id_kelurahan', $klh->id)->orderBy('created_at', 'desc')->first();
                }
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('kelurahan', function($data){
                    return $data->kelurahan->nama;
                })
                ->rawColumns(['kelurahan'])
                ->make(true);
        }
    }
    public function ponteng(Request $request)
    {
        if(request()->ajax())
        {
            if(!empty($request->tgl3))
            {
                $kelurahans = Kelurahan::where('id_kecamatan', 3)->get();
                foreach($kelurahans as $klh) {
                    $data[] = C19_Klh::where('id_kelurahan', $klh->id)->where('tgl', $request->tgl3)->first();
                }
            } else{
                $kelurahans = Kelurahan::where('id_kecamatan', 3)->get();
                foreach($kelurahans as $klh) {
                    $data[] = C19_Klh::where('id_kelurahan', $klh->id)->orderBy('created_at', 'desc')->first();
                }
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('kelurahan', function($data){
                    return $data->kelurahan->nama;
                })
                ->rawColumns(['kelurahan'])
                ->make(true);
        }
    }
    public function ponko(Request $request)
    {
        if(request()->ajax())
        {
            if(!empty($request->tgl4))
            {
                $kelurahans = Kelurahan::where('id_kecamatan', 4)->get();
                foreach($kelurahans as $klh) {
                    $data[] = C19_Klh::where('id_kelurahan', $klh->id)->where('tgl', $request->tgl4)->first();
                }
            } else {
                $kelurahans = Kelurahan::where('id_kecamatan', 4)->get();
                foreach($kelurahans as $klh) {
                    $data[] = C19_Klh::where('id_kelurahan', $klh->id)->orderBy('created_at', 'desc')->first();
                }
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('kelurahan', function($data){
                    return $data->kelurahan->nama;
                })
                ->rawColumns(['kelurahan'])
                ->make(true);
        }
    }
    public function ponsel(Request $request)
    {
        if(request()->ajax())
        {
            if(!empty($request->tgl5))
            {
                $kelurahans = Kelurahan::where('id_kecamatan', 5)->get();
                foreach($kelurahans as $klh) {
                    $data[] = C19_Klh::where('id_kelurahan', $klh->id)->where('tgl', $request->tgl5)->first();
                }
            } else {
                $kelurahans = Kelurahan::where('id_kecamatan', 5)->get();
                foreach($kelurahans as $klh) {
                    $data[] = C19_Klh::where('id_kelurahan', $klh->id)->orderBy('created_at', 'desc')->first();
                }
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('kelurahan', function($data){
                    return $data->kelurahan->nama;
                })
                ->rawColumns(['kelurahan'])
                ->make(true);
        }
    }
    public function ponbar(Request $request)
    {
        if(request()->ajax())
        {
            if(!empty($request->tgl6))
            {
                $kelurahans = Kelurahan::where('id_kecamatan', 6)->get();
                foreach($kelurahans as $klh) {
                    $data[] = C19_Klh::where('id_kelurahan', $klh->id)->where('tgl', $request->tgl6)->first();
                }
            } else {
                $kelurahans = Kelurahan::where('id_kecamatan', 6)->get();
                foreach($kelurahans as $klh) {
                    $data[] = C19_Klh::where('id_kelurahan', $klh->id)->orderBy('created_at', 'desc')->first();
                }
            }            
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('kelurahan', function($data){
                    return $data->kelurahan->nama;
                })
                ->rawColumns(['kelurahan'])
                ->make(true);
        }
    }

    public function ponturaTgl()
    {
        if(request()->ajax())
        {
            $data = C19_Klh::orderBy('created_at', 'desc')->first();
            $array = [
                'tgl' => $data->tgl
            ];
            return response()->json(['result' => $array]);
        }
    }

    public function ponturTgl()
    {
        if(request()->ajax())
        {
            $data = C19_Klh::orderBy('created_at', 'desc')->first();
            $array = [
                'tgl' => $data->tgl
            ];
            return response()->json(['result' => $array]);
        }
    }

    public function pontengTgl()
    {
        if(request()->ajax())
        {
            $data = C19_Klh::orderBy('created_at', 'desc')->first();
            $array = [
                'tgl' => $data->tgl
            ];
            return response()->json(['result' => $array]);
        }
    }

    public function ponkoTgl()
    {
        if(request()->ajax())
        {
            $data = C19_Klh::orderBy('created_at', 'desc')->first();
            $array = [
                'tgl' => $data->tgl
            ];
            return response()->json(['result' => $array]);
        }
    }

    public function ponselTgl()
    {
        if(request()->ajax())
        {
            $data = C19_Klh::orderBy('created_at', 'desc')->first();
            $array = [
                'tgl' => $data->tgl
            ];
            return response()->json(['result' => $array]);
        }
    }

    public function ponbarTgl()
    {
        if(request()->ajax())
        {
            $data = C19_Klh::orderBy('created_at', 'desc')->first();
            $array = [
                'tgl' => $data->tgl
            ];
            return response()->json(['result' => $array]);
        }
    }
}