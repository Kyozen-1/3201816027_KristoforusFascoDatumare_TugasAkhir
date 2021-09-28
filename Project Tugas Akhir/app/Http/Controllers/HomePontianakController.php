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

class HomePontianakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kecamatans = Kecamatan::all();
        return view('frontend.index', compact('kecamatans'));
    }

    public function peta_utama()
    {
        $dataKelurahan = [];
        if(request()->ajax()){
            $tgl = DB::table('klh_cvd')
                        ->select('tgl')
                        ->orderBy('tgl', 'desc')
                        ->first();
            $t = $tgl->tgl;
            $datas = DB::table('kelurahan')
                        ->join('klh_cvd', 'kelurahan.id', '=', 'klh_cvd.id_kelurahan')
                        ->select('kelurahan.*', 'klh_cvd.kontak_erat', 'klh_cvd.suspek', 'klh_cvd.positif', 'klh_cvd.positif_isolasi', 'klh_cvd.meninggal', 'klh_cvd.color', 'klh_cvd.tgl')
                        ->where('klh_cvd.tgl', '=', $t)
                        ->get();

            foreach ($datas as $data) {
                $items = Carbon::parse($data->tgl);
                $t = $items->format('d M Y');
                
                $color = "";
                if($data->color == ""){
                    $color = "#000000";
                } else {
                    $color = $data->color;
                }
                $dataKelurahan[] = [
                    'type' => 'Feature',
                    'geometry' => [
                        'coordinates' => $data->kord,
                        'type' => 'Polygon'
                    ],
                    'properties' => [
                        'kelurahanId' => $data->id,
                        'nama' => $data->nama,
                        'kontak_erat' => $data->kontak_erat,
                        'suspek' => $data->suspek,
                        'positif' => $data->positif,
                        'positif_isolasi' => $data->positif_isolasi,
                        'meninggal' => $data->meninggal,
                        'color' => $color,
                        'tgl' => $t
                    ]
                ] ;
            }
            $geoLocation = [
                'type' => 'FeatureCollection',
                'features' => $dataKelurahan
            ];

            $geoJson = collect($geoLocation)->toJson();

            return $geoJson;
        }
    }

    public function data_ptk()
    {
        if(request()->ajax())
        {
            $tgl = C19_Klh::orderBy('tgl', 'desc')->first();
            $items = Carbon::parse($tgl->tgl);
            $t = $items->format('d M Y');
            $c19_klh = C19_Klh::where('tgl', $tgl->tgl)
                ->select(
                    DB::raw("sum(kontak_erat) as kontak_erat"),
                    DB::raw("sum(suspek) as suspek"),
                    DB::raw("sum(positif) as positif"))
                ->get();
            $c19_ptk = C19_Ptk::orderBy('tgl', 'desc')->first();
            $array = [
                'di_rs' => $c19_ptk->di_rs,
                'probable' => $c19_ptk->probable,
                'discarded' => $c19_ptk->discarded,
                'isolasi' => $c19_ptk->isolasi,
                'sembuh' => $c19_ptk->sembuh,
                'meninggal' => $c19_ptk->meninggal,
                'tgl' => $t
            ];

            return response()->json([
                'c19_klh' => $c19_klh,
                'c19_ptk' => $array
            ]);
        }
    }
}