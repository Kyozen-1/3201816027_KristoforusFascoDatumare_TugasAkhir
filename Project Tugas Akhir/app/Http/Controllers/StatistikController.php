<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\C19_Klh;
use App\Models\C19_Ptk;
use Illuminate\Http\Request;
use DB;
use Validator;
use DataTables;
use Carbon\Carbon;

class StatistikController extends Controller
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
            $t = C19_Klh::select('tgl')->orderBy('tgl', 'desc')->distinct()->first();
            $period = explode('-', $t->tgl);
            $tgls = DB::table('klh_cvd')
                        ->select('tgl')
                        ->whereYear('tgl', '=', $period[0])
                        ->whereMonth('tgl', '=', $period[1])
                        ->distinct()
                        ->get();
            foreach ($tgls as $tgl) {
                $positif[] = DB::table('klh_cvd')
                                ->select('positif')
                                ->where('tgl', $tgl->tgl)
                                ->sum('positif');
                $data = DB::table('c19_ptk')
                            ->select('sembuh', 'meninggal')
                            ->where('tgl', $tgl->tgl)
                            ->first();
                $sembuh[] = $data->sembuh;
                $meninggal[] = $data->meninggal;
                $items = Carbon::parse($tgl->tgl);
                $t = $items->format('d M Y');
                $tl[] = $t;
            }
            return response()->json([
                'positif' => $positif, 
                'sembuh' => $sembuh,
                'meninggal'=>$meninggal,
                'tgl' => $tl]
            );
        }

        $kecamatans = Kecamatan::all();
        $bulanans = DB::table('klh_cvd')
                    ->select(DB::raw('DATE_FORMAT(tgl, "%M %Y") as bulan'))
                    ->orderBy('tgl', 'desc')
                    ->distinct()
                    ->get();
        return view('frontend.statistik', compact('kecamatans', 'bulanans'));
    }

    public function peta_kecamatan()
    {
        if(request()->ajax())
        {
            $tgl = DB::table('klh_cvd')
                    ->select('tgl')
                    ->orderBy('tgl', 'desc')
                    ->first();
            $t = Carbon::parse($tgl->tgl)->format('d M Y');
            $dataCovid = [];
            $kecamatans = Kecamatan::all();
            foreach ($kecamatans as $kecamatan) {
                $kelurahans = Kelurahan::where('id_kecamatan', $kecamatan->id)->get();
                foreach ($kelurahans as $klh) {
                    $p[]= DB::table('klh_cvd')
                                ->select('positif')
                                ->where('id_kelurahan', $klh->id)
                                ->where('tgl', $tgl->tgl)
                                ->sum('positif');
                    $pi[] = DB::table('klh_cvd')
                                        ->select('positif_isolasi')
                                        ->where('id_kelurahan',$klh->id)
                                        ->where('tgl', $tgl->tgl)
                                        ->sum('positif_isolasi');
                    $m[] = DB::table('klh_cvd')
                                    ->select('meninggal')
                                    ->where('id_kelurahan', $klh->id)
                                    ->where('tgl', $tgl->tgl)
                                    ->sum('meninggal');
                    $s[] = DB::table('klh_cvd')
                                    ->select('suspek')
                                    ->where('id_kelurahan', $klh->id)
                                    ->where('tgl', $tgl->tgl)
                                    ->sum('suspek');
                    $ke[] = DB::table('klh_cvd')
                                        ->select('kontak_erat')
                                        ->where('id_kelurahan', $klh->id)
                                        ->where('tgl', $tgl->tgl)
                                        ->sum('kontak_erat');
                }
                $dataCovid[] = [
                    'type' => 'Feature',
                    'geometry' => [
                        'coordinates' => $kecamatan->kord,
                        'type' => 'Polygon'
                    ],
                    'properties' => [
                        'kecamatanId' => $kecamatan->id,
                        'nama' => $kecamatan->nama,
                        'color' => $kecamatan->color,
                        'positif' => array_sum($p),
                        'positif_isolasi' => array_sum($pi),
                        'meninggal' => array_sum($m),
                        'suspek' => array_sum($s),
                        'kontak_erat' => array_sum($ke),
                        'tgl' => $t
                    ]
                ];
            }
            $geoLocation = [
                'type' => 'FeatureCollection',
                'features' => $dataCovid
            ];

            $geoJson = collect($geoLocation)->toJson();
            return $geoJson;
        }   
    }

    public function filter($filter, $bln)
    {
        if(request()->ajax()){
            if($filter == 'harian')
            {
                $date = date('Y-m', strtotime($bln));
                $period = explode('-', $date);
                $tgls = DB::table('klh_cvd')
                            ->select('tgl')
                            ->whereYear('tgl', '=', $period[0])
                            ->whereMonth('tgl', '=', $period[1])
                            ->distinct()
                            ->get();
                foreach ($tgls as $tgl) {
                    $positif[] = DB::table('klh_cvd')
                                    ->select('positif')
                                    ->where('tgl', $tgl->tgl)
                                    ->sum('positif');
                    $data = DB::table('c19_ptk')
                                ->select('sembuh', 'meninggal')
                                ->where('tgl', $tgl->tgl)
                                ->first();
                    $sembuh[] = $data->sembuh;
                    $meninggal[] = $data->meninggal;
                    $items = Carbon::parse($tgl->tgl);
                    $t = $items->format('d M Y');
                    $tl[] = $t;
                }
                return response()->json([
                    'positif' => $positif, 
                    'sembuh' => $sembuh,
                    'meninggal'=>$meninggal,
                    'tgl' => $tl]
                );
            }
            if($filter == 'bulanan')
            {
                $tgls = DB::table('klh_cvd')
                    ->select(DB::raw('YEAR(tgl) as year'), DB::raw('MONTH(tgl) as month'), DB::raw('max(tgl) as tgl'))
                    ->groupBy('year', 'month')
                    ->get();
                foreach($tgls  as $tgl)
                {
                    $positif[] = DB::table('klh_cvd')
                                    ->select('positif')
                                    ->where('tgl', $tgl->tgl)
                                    ->sum('positif');
                    $data = DB::table('c19_ptk')
                                ->select('sembuh', 'meninggal')
                                ->where('tgl', $tgl->tgl)
                                ->first();
                    $sembuh[] = $data->sembuh;
                    $meninggal[] = $data->meninggal;
                    $items = Carbon::parse($tgl->tgl);
                    $t = $items->format('M Y');
                    $tl[] = $t;
                }
                return response()->json([
                    'positif' => $positif, 
                    'sembuh' => $sembuh,
                    'meninggal'=>$meninggal,
                    'tgl' => $tl]
                );
            }
            if($filter == 'tahunan')
            {
                $tgls = DB::table('klh_cvd')
                    ->select(DB::raw('YEAR(tgl) as year'), DB::raw('max(tgl) as tgl'))
                    ->groupBy('year')
                    ->get();
                foreach($tgls  as $tgl)
                {
                    $positif[] = DB::table('klh_cvd')
                                    ->select('positif')
                                    ->where('tgl', $tgl->tgl)
                                    ->sum('positif');
                    $data = DB::table('c19_ptk')
                                ->select('sembuh', 'meninggal')
                                ->where('tgl', $tgl->tgl)
                                ->first();
                    $sembuh[] = $data->sembuh;
                    $meninggal[] = $data->meninggal;
                    $items = Carbon::parse($tgl->tgl);
                    $t = $items->format('Y');
                    $tl[] = $t;
                }
                return response()->json([
                    'positif' => $positif, 
                    'sembuh' => $sembuh,
                    'meninggal'=>$meninggal,
                    'tgl' => $tl]
                );
            }
        }
    }
}