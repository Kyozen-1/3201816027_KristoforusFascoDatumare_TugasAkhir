<?php

namespace App\Http\Controllers;
use App\Models\RS_Data;
use App\Models\RS;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use DB;
use Validator;
use DataTables;
use Carbon\Carbon;

class RumahSakitRujukanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $rs = RS::all();
            $tgl = RS_Data::orderBy('created_at', 'desc')->first();
            $data = RS_Data::where('tgl', $tgl->tgl)->get();

            return DataTables::of($data)
            ->editColumn('bor_icu', function($data){
                if ($data->jlh_tmpt_icu == "0")
                {
                    $bor_icu = "0";
                } else {
                    $k_icu = $data->k_icu;
                    $jlh_tmpt_icu = $data->jlh_tmpt_icu;
                    $bor_icu = ($jlh_tmpt_icu * 100) / $k_icu;
                }
                return number_format($bor_icu,2);
            })
            ->editColumn('bor_isolasi', function($data){
                if ($data->jlh_tmpt_positif == "0" && $data->jlh_tmpt_suspek == "0")
                {
                    $bor_isolasi = "0";
                } else {
                    $k_isolasi = $data->k_isolasi;
                    $jlh_tmpt_positif = $data->jlh_tmpt_positif;
                    $jlh_tmpt_suspek = $data->jlh_tmpt_suspek;
                    $bor_isolasi = (($jlh_tmpt_positif + $jlh_tmpt_suspek) * 100) / $k_isolasi;
                }
                return number_format($bor_isolasi,2);
            })
            ->editColumn('rs', function($data){
                return $data->rs->nama;
            })
            ->rawColumns(['rs', 'bor_icu', 'bor_isolasi'])
            ->make(true);
        }
        $rss = RS::all();
        return view('frontend.rumah_sakit', compact('rss'));
    }

    public function data_covid()
    {
        if(request()->ajax())
        {
            $tgl = DB::table('data_rs')
                    ->select('tgl')
                    ->orderBy('tgl', 'desc')
                    ->first();
            $t = $tgl->tgl;
            $datas = DB::table('rs')
                    ->join('data_rs', 'rs.id', '=', 'data_rs.id_rs')
                    ->select('rs.*', 'data_rs.k_icu', 'data_rs.jlh_tmpt_icu', 'data_rs.k_isolasi', 'data_rs.jlh_tmpt_positif', 'data_rs.jlh_tmpt_suspek', 'data_rs.tgl')
                    ->where('data_rs.tgl', '=', $t)
                    ->get();
            // $rss = RS::orderBy('created_at', 'desc')->get();
            $customLocations = [];
            foreach($datas as $data)
            {
                if ($data->jlh_tmpt_icu == "0")
                {
                    $bor_icu = "0";
                } else {
                    $k_icu = $data->k_icu;
                    $jlh_tmpt_icu = $data->jlh_tmpt_icu;
                    $bor_icu = ($jlh_tmpt_icu * 100) / $k_icu;
                    $tersisa_icu = $k_icu - $jlh_tmpt_icu; 
                }

                if ($data->jlh_tmpt_positif == "0" && $data->jlh_tmpt_suspek == "0")
                {
                    $bor_isolasi = "0";
                } else {
                    $k_isolasi = $data->k_isolasi;
                    $jlh_tmpt_positif = $data->jlh_tmpt_positif;
                    $jlh_tmpt_suspek = $data->jlh_tmpt_suspek;
                    $bor_isolasi = (($jlh_tmpt_positif + $jlh_tmpt_suspek) * 100) / $k_isolasi;
                    $tersisa_isolasi = $k_isolasi - ($jlh_tmpt_positif + $jlh_tmpt_suspek);
                }

                $customLocations[] = [
                    'type' => 'Feature',
                    'geometry' => [
                        'coordinates' => [$data->lng, $data->lat],
                        'type' => 'point'
                    ],
                    'properties' => [
                        'locationId' => $data->id,
                        'title' => $data->nama,
                        'k_icu' => $data->k_icu,
                        'jlh_tmpt_icu' => $data->jlh_tmpt_icu,
                        'bor_icu' => number_format($bor_icu,2),
                        'tersisa_icu'=>$tersisa_icu,
                        'k_isolasi' => $data->k_isolasi,
                        'jlh_tmpt_positif' => $data->jlh_tmpt_positif,
                        'jlh_tmpt_suspek' => $data->jlh_tmpt_suspek,
                        'bor_isolasi' => number_format($bor_isolasi,2),
                        'tersisa_isolasi' => $tersisa_isolasi,
                        'tgl' => Carbon::parse($data->tgl)->format('d M Y')
                    ]
                ];
            }

            $geoLocation = [
                'type' => 'FeatureCollection',
                'features' => $customLocations
            ];

            $geoJson = collect($geoLocation)->toJson();

            return $geoJson;
        }
    }

    public function tanggal()
    {
        if(request()->ajax())
        {
            $data = RS_Data::orderBy('created_at', 'desc')->first();
            $items = Carbon::parse($data->tgl);
            $t = $items->format('d M Y');
            $array = [
                'tgl' => $t
            ];
            return response()->json(['result' => $array]);
        }
    }
}