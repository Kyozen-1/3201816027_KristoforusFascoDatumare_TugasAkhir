<?php

namespace App\Http\Controllers;

use App\Models\C19_Klh;
use App\Models\Kelurahan;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
use Validator;
use DataTables;
use Carbon\Carbon;
use App\Imports\C19_KlhImport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\C19_KlhExport;

class C19KelurahanController extends Controller
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
            if($request->filter_klh != null)
            {
                if(!empty($request->from_date))
                {
                    $data = C19_Klh::whereBetween('tgl', [$request->from_date, $request->to_date])
                            ->where('id_kelurahan', $request->filter_klh)
                            ->orderBy('created_at', 'desc')
                            ->get();
                } else {
                    $data = C19_Klh::where('id_kelurahan', $request->filter_klh)->orderBy('created_at', 'desc')->get();
                }
            } else {
                if(!empty($request->from_date))
                {
                    $data = C19_Klh::whereBetween('tgl', [$request->from_date, $request->to_date])
                            ->orderBy('created_at', 'desc')
                            ->get();
                } else {
                    $data = C19_Klh::select("*")->orderBy('tgl', 'desc')->get();
                }
            }
            $kelurahan = Kelurahan::all();

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function($data){
                $button = '<button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-sm btn-clean btn-icon" title="Detail Data"><i class="la la-eye"></i></button>';
                $button .= '<button type="button" name="edit" id="'.$data->id.'" 
                class="edit btn btn-sm btn-clean btn-icon" title="Edit Data"><i class="la la-pen"></i></button>';
                $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-sm btn-clean btn-icon" title="Delete Data"><i class="la la-trash"></i></button>';
                return $button;
            })
            ->addColumn('color', function($data){
                $warna = '<input type="color" class="form-control" value="'.$data->color.'" disabled>';
                return $warna;
            })
            ->editColumn('kelurahan', function($data){
                return $data->kelurahan->nama;
            })
            ->rawColumns(['actions','color','kelurahan'])
            ->make(true);
        }
        // $kelurahans = Kelurahan::all();
        // return view('backend.c19_klh.index', compact('kelurahans'));
        $kelurahans = Kelurahan::all();
        $colors = Color::all();
        return view('backend.c19_klh.index',compact('kelurahans', 'colors'));
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        $file = $request->file('file');

        $nama_file = $file->hashName();

        $path = $file->storeAs('public/excel/', $nama_file);

        $import = Excel::import(new C19_KlhImport(), storage_path('app/public/excel/'.$nama_file));

        Storage::delete($path);
        if($import)
        {
            activity()->log('Melakukan Import Data Covid-19 Kelurahan pada tanggal '.Carbon::now());
            return redirect()->route('c19_klh.index')->with(['success' => 'Data berhasil Diimport']);
        } else {
            return redirect()->route('c19_klh.index')->with(['error' => 'Data Gagal Diimport!']);
        }
    }

    public function export()
    {
        activity()->log('Melakukan Export Data Covid-19 Kelurahan pada tanggal '.Carbon::now());
        return Excel::download(new C19_KlhExport(), 'Covid-19 Kelurahan.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelurahans = Kelurahan::all();
        $colors = Color::all();
        return view('backend.c19_klh.create', compact('kelurahans', 'colors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kelurahans = Kelurahan::all();
        $c19_klh = C19_Klh::where('tgl', $request->tgl)->first();
        if($c19_klh == null)
        {
            foreach ($kelurahans as $kelurahan) {
                $errors = Validator::make($request->all(), [
                    'id_kelurahan'.$kelurahan->id => 'required',
                    'kontak_erat'.$kelurahan->id => 'required|integer|min:0',
                    'suspek'.$kelurahan->id => 'required|integer|min:0',
                    'positif'.$kelurahan->id => 'required|integer|min:0',
                    'positif_isolasi'.$kelurahan->id => 'required|integer|min:0',
                    'meninggal'.$kelurahan->id => 'required|integer|min:0',
                    'color'.$kelurahan->id => 'required',
                    'tgl' =>'required'
                ]);
                if($errors -> fails())
                {
                    return back()->with('errors', $errors->messages()->all()[0])->withInput();
                }
                $data[] = array(
                    'id_kelurahan' => $request->input('id_kelurahan'.$kelurahan->id),
                    'kontak_erat' => $request->input('kontak_erat'.$kelurahan->id),
                    'suspek' => $request->input('suspek'.$kelurahan->id),
                    'positif' => $request->input('positif'.$kelurahan->id),
                    'positif_isolasi' => $request->input('positif_isolasi'.$kelurahan->id),
                    'meninggal' => $request->input('meninggal'.$kelurahan->id),
                    'color' => $request->input('color'.$kelurahan->id),
                    'tgl' => $request->tgl
                );
            }
            activity()->log('Menambah Data Covid-19 Kelurahan untuk data pada tanggal '
            .Carbon::parse($request->tgl)->format('d M Y').' dengan metode Semua');
            DB::table('klh_cvd')->insert($data);
            return redirect('admin/kelurahan/covid19')->with('success', 'Data Berhasil Disimpan');
        } else {
            return back()->with('errors', 'Data sudah ada pada tanggal ini');
        }
    }

    public function sps()
    {
        $kelurahans = Kelurahan::all();
        $colors = Color::all();
        return view('backend.c19_klh.sps', compact('kelurahans', 'colors'));
    }

    public function coba_insert(Request $request)
    {
        if($request->ajax())
        {
            $errors = Validator::make($request->all(), [
                'coba_select.*' => 'required | min:1',
                'kontak_erat.*' => 'required|integer|min:0',
                'suspek.*' => 'required|integer|min:0',
                'positif.*' => 'required|integer|min:0',
                'positif_isolasi.*' => 'required|integer|min:0',
                'meninggal.*' => 'required|integer|min:0',
                'warna_select.*' => 'required',
                'tanggal.*' => 'required'
            ]);

            if ($errors -> fails())
            {
                return response()->json(['errors' => $errors->errors()->all()]);
            }

            $coba_select = $request->coba_select;
            $kontak_erat = $request->kontak_erat;
            $suspek = $request->suspek;
            $positif = $request->positif;
            $positif_isolasi = $request->positif_isolasi;
            $meninggal = $request->meninggal;
            $warna_select = $request->warna_select;
            $tanggal = $request->tanggal;

            for($count = 0; $count < count($coba_select); $count++)
            {
                $data = array(
                    'id_kelurahan' => $coba_select[$count],
                    'kontak_erat' => $kontak_erat[$count],
                    'suspek' => $suspek[$count],
                    'positif' => $positif[$count],
                    'positif_isolasi' => $positif_isolasi[$count],
                    'meninggal' => $meninggal[$count],
                    'color' => $warna_select[$count],
                    'tgl'=> $tanggal[$count]
                );
                $klh = Kelurahan::where('id', $coba_select[$count])->first();
                activity()->log('Menambah Data Covid-19 pada Kelurahan '.$klh->nama.' untuk data pada tanggal '.Carbon::parse($tanggal[$count])->format('d M Y'));
                $insert_data[] = $data;
            }
            C19_Klh::insert($insert_data);
            return response()->json(['success' => 'Data berhasil disimpan']);
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
            $data = C19_Klh::findOrFail($id);
            $kelurahan = Kelurahan::findOrFail($data->id_kelurahan);
            $array = [
                'kelurahan' => $kelurahan->nama,
                'positif' => $data->positif,
                'positif_isolasi' => $data->positif_isolasi,
                'meninggal' => $data->meninggal,
                'suspek' => $data->suspek,
                'kontak_erat' => $data->kontak_erat,
                'color' => $data->color,
                'tgl' => $data->tgl
            ];
            return response()->json(['result'=>$array]);
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
            $data = C19_Klh::findOrFail($id);
            $kelurahan = Kelurahan::findOrFail($data->id_kelurahan);

            $array = [
                'id_kelurahan' => $data->id_kelurahan,
                'nama_kelurahan' => $kelurahan->nama,
                'positif' => $data->positif,
                'positif_isolasi' => $data->positif_isolasi,
                'meninggal' => $data->meninggal,
                'suspek' => $data->suspek,
                'kontak_erat' => $data->kontak_erat,
                'color' => $data->color,
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
            'edit_positif' => 'required|integer|min:0',
            'edit_positif_isolasi' => 'required|integer|min:0',
            'edit_meninggal' => 'required|integer|min:0',
            'edit_suspek' => 'required|integer|min:0',
            'edit_kontak_erat' => 'required|integer|min:0',
            'edit_color' => 'required'
        ]);
        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        $c19_klh_form = array(
            'positif' => $request->edit_positif,
            'positif_isolasi' => $request->edit_positif_isolasi,
            'meninggal' => $request->edit_meninggal,
            'suspek' => $request->edit_suspek,
            'kontak_erat' => $request->edit_kontak_erat,
            'color' => $request->edit_color
        );
        $data = C19_Klh::where('id', $request->edit_hidden_id)->first();
        $klh = Kelurahan::where('id', $data->id_kelurahan)->first();
        activity()->log('Mengupdate Data Covid-19 Kelurahan '.$klh->nama.' untuk data pada tanggal '.Carbon::parse($data->tgl)->format('d M Y'));
        DB::table('klh_cvd')->where('id', $request->edit_hidden_id)->update($c19_klh_form);
        return response()->json(['success' => 'Berhasil di ubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function tgl($id)
    {
        if(request()->ajax())
        {
            $data = C19_Klh::findOrFail($id);
            $items = Carbon::parse($data->tgl);
            $t = $items->format('d M Y');
            $array = [
                'tgl' => $t
            ];

            return response()->json(['result' => $array]);
        }
    }
    public function destroy($id)
    {
        $data = C19_Klh::findOrFail($id);
        $c19_klh =  C19_Klh::where('tgl', $data->tgl);
        activity()->log('Menghapus data Covid-19 Kelurahan yang bertanggal '.Carbon::parse($data->tgl)->format('d M Y'));
        $c19_klh->delete();
    }
}