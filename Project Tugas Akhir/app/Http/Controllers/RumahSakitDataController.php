<?php

namespace App\Http\Controllers;

use App\Models\RS_Data;
use App\Models\RS;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
use Validator;
use DataTables;
use Carbon\Carbon;
use App\Imports\RS_DataImport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RS_DataExport;

class RumahSakitDataController extends Controller
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
            if($request->filter_rs != null)
            {
                if(!empty($request->from_date))
                {
                    $data = RS_Data::whereBetween('tgl', [$request->from_date, $request->to_date])
                            ->where('id_rs', $request->filter_rs)
                            ->orderBy('created_at', 'desc')
                            ->get();
                } else {
                    $data = RS_Data::where('id_rs', $request->filter_rs)->orderBy('created_at', 'desc')->get();
                }
            } else {
                if(!empty($request->from_date))
                {
                    $data = RS_Data::whereBetween('tgl', [$request->from_date, $request->to_date])
                            ->orderBy('created_at', 'desc')
                            ->get();
                } else {
                    $data = RS_Data::select("*")->orderBy('created_at', 'desc')->get();
                }
            }

            $rs = RS::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function($data){
                    $button = '<button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-sm btn-clean btn-icon" title="Detail Data"><i class="la la-eye"></i></button>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" 
                    class="edit btn btn-sm btn-clean btn-icon" title="Edit Data"><i class="la la-pen"></i></button>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-sm btn-clean btn-icon" title="Delete Data"><i class="la la-trash"></i></button>';
                    return $button;
                })
                ->editColumn('bor_icu', function($data){
                    if ($data->jlh_tmpt_icu == "0")
                    {
                        $bor_icu = "0";
                    } else {
                        $k_icu = $data->k_icu;
                        $jlh_tmpt_icu = $data->jlh_tmpt_icu;
                        $bor_icu = ($jlh_tmpt_icu * 100) / $k_icu;
                    }
                    return number_format($bor_icu, 2);
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
                    return number_format($bor_isolasi, 2);
                })
                ->editColumn('rs', function($data){
                    return $data->rs->nama;
                })
                ->rawColumns(['actions', 'rs', 'bor_icu', 'bor_isolasi'])
                ->make(true);
        }
        $rss = RS::all();
        return view('backend.data_rs.index', compact('rss'));
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        $file = $request->file('file');

        $nama_file = $file->hashName();

        $path = $file->storeAs('public/excel/', $nama_file);

        $import = Excel::import(new RS_DataImport(), storage_path('app/public/excel/'.$nama_file));

        Storage::delete($path);
        if($import)
        {
            activity()->log('Melakukan Import Data Rumah Sakit pada tanggal '.Carbon::now());
            return redirect()->route('rs_data.index')->with(['success' => 'Data berhasil Diimport']);
        } else {
            return redirect()->route('rs_data.index')->with(['error' => 'Data Gagal Diimport!']);
        }
    }

    public function export()
    {
        activity()->log('Melakukan Export Data Rumah Sakit pada tanggal '.Carbon::now());
        return Excel::download(new RS_DataExport(), 'Data Rumah Sakit.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rss = RS::all();
        return view('backend.data_rs.create', compact('rss'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rss = RS::all();
        $rs_data = RS_Data::where('tgl', $request->tgl)->first();
        if($rs_data == null)
        {
            foreach($rss as $rs) {
                $errors = Validator::make($request->all(), [
                    'nama_rs'.$rs->id => 'required',
                    'k_icu'.$rs->id => 'required|integer|min:0',
                    'jlh_tmpt_icu'.$rs->id => 'required|integer|min:0',
                    'k_isolasi'.$rs->id => 'required|integer|min:0',
                    'jlh_tmpt_positif'.$rs->id => 'required|integer|min:0',
                    'jlh_tmpt_suspek'.$rs->id => 'required|integer|min:0',
                    'tgl' => 'required'
                ]);

                if($errors -> fails())
                {
                    return response()->json(['errors' => $errors->errors()->all()]);
                }

                $data[] = array(
                    'id_rs' => $request->input('nama_rs'.$rs->id),
                    'k_icu' => $request->input('k_icu'.$rs->id),
                    'jlh_tmpt_icu' => $request->input('jlh_tmpt_icu'.$rs->id),
                    'k_isolasi' => $request->input('k_isolasi'.$rs->id),
                    'jlh_tmpt_positif' => $request->input('jlh_tmpt_positif'.$rs->id),
                    'jlh_tmpt_suspek' => $request->input('jlh_tmpt_suspek'.$rs->id),
                    'tgl' => $request->tgl
                );
            }
            activity()->log('Menambah Data Rumah Sakit untuk data pada tanggal '
            .Carbon::parse($request->tgl)->format('d M Y').' dengan metode Semua');
            DB::table('data_rs')->insert($data);
            return redirect('admin/rumah-sakit/data')->with('success', 'Data Berhasil Disimpan');
        } else {
            return back()->with('errors', 'Data sudah ada pada tanggal ini');
        }
    }

    public function sps()
    {
        $rss = RS::all();
        return view('backend.data_rs.sps', compact('rss'));
    }

    public function coba_insert(Request $request)
    {
        if($request->ajax())
        {
            $errors = Validator::make($request->all(), [
                'coba_select.*' => 'required|min:1',
                'k_icu.*' => 'required|integer|min:0',
                'jlh_tmpt_icu.*' => 'required|integer|min:0',
                'k_isolasi.*' => 'required|integer|min:0',
                'jlh_tmpt_positif.*' => 'required|integer|min:0',
                'jlh_tmpt_suspek.*' => 'required|integer|min:0',
                'tgl.*' => 'required'
            ]);

            if ($errors -> fails())
            {
                return response()->json(['errors' => $errors->errors()->all()]);
            }

            $coba_select = $request->coba_select;
            $k_icu = $request->k_icu;
            $jlh_tmpt_icu = $request->jlh_tmpt_icu;
            $k_isolasi = $request->k_isolasi;
            $jlh_tmpt_positif = $request->jlh_tmpt_positif;
            $jlh_tmpt_suspek = $request->jlh_tmpt_suspek;
            $tgl = $request->tgl;

            for($count = 0; $count < count($coba_select); $count++)
            {
                $data = array(
                    'id_rs' => $coba_select[$count],
                    'k_icu' => $k_icu[$count],
                    'jlh_tmpt_icu' => $jlh_tmpt_icu[$count],
                    'k_isolasi' => $k_isolasi[$count],
                    'jlh_tmpt_positif' => $jlh_tmpt_positif[$count],
                    'jlh_tmpt_suspek' => $jlh_tmpt_suspek[$count],
                    'tgl'=> $tgl[$count]
                );
                $rs_data = RS::where('id', $coba_select[$count])->first();
                activity()->log('Menambah Data Rumah Sakit '.$rs_data->nama.' untuk data pada tanggal '.Carbon::parse($tgl[$count])->format('d M Y'));

                $insert_data[] = $data;
            }
            RS_Data::insert($insert_data);
            return response()->json(['success' => 'Data berhasil ditambahkan']);
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
            $data = RS_Data::findOrFail($id);
            $rs = RS::findOrFail($data->id_rs);

            $k_icu = $data->k_icu;
            $jlh_tmpt_icu = $data ->jlh_tmpt_icu;
            $tersisa_icu = $k_icu - $jlh_tmpt_icu; 

            $k_isolasi = $data->k_isolasi;
            $jlh_tmpt_positif = $data->jlh_tmpt_positif;
            $jlh_tmpt_suspek = $data->jlh_tmpt_suspek;
            $tersisa_isolasi = $k_isolasi - ($jlh_tmpt_positif + $jlh_tmpt_suspek);
            $array = [
                'rs' => $rs->nama,
                'k_icu' => $data->k_icu,
                'jlh_tmpt_icu' => $data->jlh_tmpt_icu,
                'tersisa_icu' => $tersisa_icu,
                'k_isolasi' => $data->k_isolasi,
                'jlh_tmpt_positif' => $data->jlh_tmpt_positif,
                'jlh_tmpt_suspek' => $data->jlh_tmpt_suspek,
                'tersisa_isolasi' => $tersisa_isolasi,
                'tgl' => $data->tgl
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
            $data = RS_Data::findOrFail($id);
            $rs = RS::findOrFail($data->id_rs);
            $array = [
                'id_rs' => $data->id_rs,
                'nama_rs' => $rs->nama,
                'k_icu' => $data->k_icu,
                'jlh_tmpt_icu' => $data->jlh_tmpt_icu,
                'bor_icu' => $data->bor_icu,
                'k_isolasi' => $data->k_isolasi,
                'jlh_tmpt_positif' => $data->jlh_tmpt_positif,
                'jlh_tmpt_suspek' => $data->jlh_tmpt_suspek,
                'bor_isolasi' => $data->bor_isolasi,
                'tgl' => $data->tgl
            ];

            return response()->json(['result'=>$array]);
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
            'edit_k_icu' => 'required|integer|min:0',
            'edit_jlh_tmpt_icu' => 'required|integer|min:0',
            'edit_k_isolasi' => 'required|integer|min:0',
            'edit_jlh_tmpt_positif' => 'required|integer|min:0',
            'edit_jlh_tmpt_suspek' => 'required|integer|min:0'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        $rs_data_form = array(
            'k_icu' => $request->edit_k_icu,
            'jlh_tmpt_icu' => $request->edit_jlh_tmpt_icu,
            'k_isolasi' => $request->edit_k_isolasi,
            'jlh_tmpt_positif' => $request->edit_jlh_tmpt_positif,
            'jlh_tmpt_suspek' => $request->edit_jlh_tmpt_suspek
        );
        $data = RS_Data::where('id', $request->edit_hidden_id)->first();
        $rs = RS::where('id', $data->id_rs)->first();
        activity()->log('Mengupdate Data Rumah Sakit '.$rs->nama.' untuk data pada tanggal '.Carbon::parse($data->tgl)->format('d M Y'));
        DB::table('data_rs')->where('id', $request->edit_hidden_id)->update($rs_data_form);
        return response()->json(['success' => 'Data berhasil diubah']);
    
    }

    public function tgl($id)
    {
        if(request()->ajax())
        {
            $data = RS_Data::findOrFail($id);
            $items = Carbon::parse($data->tgl);
            $t = $items->format('d M Y');
            $array = [
                'tgl' => $t
            ];

            return response()->json(['result' => $array]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = RS_Data::findOrFail($id);
        $rs_data = RS_Data::where('tgl', $data->tgl);
        activity()->log('Menghapus data Rumah Sakit yang bertanggal '.Carbon::parse($data->tgl)->format('d M Y'));
        $rs_data->delete();
    }
}