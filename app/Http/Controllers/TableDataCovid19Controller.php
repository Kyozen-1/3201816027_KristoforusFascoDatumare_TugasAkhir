<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\C19_Klh;
use App\Models\C19_Ptk;
use DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
use Carbon\Carbon;

class TableDataCovid19Controller extends Controller
{
    public function index()
    {
        $kecamatans = Kecamatan::all();
        return view('frontend.table_data', compact('kecamatans'));
    }

    public function peta_kecamatan()
    {
        if(request()->ajax())
        {
            $dataKecamatan = [];
            $kecamatans = Kecamatan::all();
            foreach($kecamatans as $kecamatan)
            {
                $dataKecamatan[] = [
                    'type' => 'Feature',
                    'geometry' => [
                        'coordinates' => $kecamatan->kord,
                        'type' => 'Polygon'
                    ],
                    'properties' => [
                        'kecamatanId' => $kecamatan->id,
                        'nama' => $kecamatan->nama,
                        'color' => $kecamatan->color
                    ]
                ];
            }
            $geoLocation = [
                'type' => 'FeatureCollection',
                'features' => $dataKecamatan
            ];

            $geoJson = collect($geoLocation)->toJson();
            return $geoJson;
        }        
    }

    public function table_data_pontura()
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
    public function table_data_pontur(Request $request)
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
    public function table_data_ponteng(Request $request)
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
    public function table_data_ponko(Request $request)
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
    public function table_data_ponsel(Request $request)
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
    public function table_data_ponbar(Request $request)
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

    public function table_data_tgl1()
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

    public function table_data_tgl2()
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

    public function table_data_tgl3()
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

    public function table_data_tgl4()
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

    public function table_data_tgl5()
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

    public function table_data_tgl6()
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