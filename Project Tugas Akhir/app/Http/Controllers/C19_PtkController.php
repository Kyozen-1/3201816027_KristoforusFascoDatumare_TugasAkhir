<?php

namespace App\Http\Controllers;

use App\Models\C19_Ptk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use DB;
use Validator;
use DataTables;
use App\Imports\C19_PtkImport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\C19_PtkExport;
use Carbon\Carbon;


class C19_PtkController extends Controller
{
    public function __contruct()
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
            if(!empty($request->from_date))
            {
                $data = C19_Ptk::whereBetween('tgl', [$request->from_date, $request->to_date])
                        ->orderBy('created_at', 'desc')
                        ->get();
            } else {
                $data = C19_Ptk::select("*")->orderBy('created_at', 'desc')->get();
            }
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function($data){
                $button = '<button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-sm btn-clean btn-icon" title="Detail Data"><i class="la la-eye"></i></button>';
                $button .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" 
                class="edit btn btn-sm btn-clean btn-icon" title="Edit Data"><i class="la la-pen"></i></button>';
                $button .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-sm btn-clean btn-icon" title="Delete Data"><i class="la la-trash"></i></button>';
                return $button;
            })
            ->rawColumns(['actions'])
            ->make(true);
        }
        return view('backend.c19_ptk.index');
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        $file = $request->file('file');

        $nama_file = $file->hashName();

        $path = $file->storeAs('public/excel/', $nama_file);

        $import = Excel::import(new C19_PtkImport(), storage_path('app/public/excel/'.$nama_file));

        Storage::delete($path);
        if($import)
        {
            activity()->log('Melakukan Import Data Covid-19 Pontianak pada tanggal '.Carbon::now());
            return redirect()->route('c19_ptk.index')->with(['success' => 'Data berhasil Diimport']);
        } else {
            return redirect()->route('c19_ptk.index')->with(['error' => 'Data Gagal Diimport!']);
        }
    }

    public function export()
    {
        activity()->log('Melakukan Export Data Covid-19 Pontianak pada tanggal '.Carbon::now());
        return Excel::download(new C19_PtkExport(), 'Covid-19 Pontianak.xlsx');
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
        $tgl = C19_Ptk::where('tgl', $request->tgl)->first();
        if($tgl == null)
        {
            $errors = Validator::make($request->all(), [
                'di_rs' => 'required|integer|min:0',
                'probable' => 'required|integer|min:0',
                'discarded' => 'required|integer|min:0',
                'isolasi' => 'required|integer|min:0',
                'sembuh' => 'required|integer|min:0',
                'meninggal' => 'required|integer|min:0',
                'tgl' => 'required'
            ]);
    
            if($errors -> fails())
            {
                return response()->json(['errors' => $errors->errors()->all()]);
            }

            $data[] = array(
                'di_rs' => $request->di_rs,
                'probable' => $request->probable,
                'discarded' => $request->discarded,
                'isolasi' => $request->isolasi,
                'sembuh' => $request->sembuh,
                'meninggal' => $request->meninggal,
                'tgl' => $request->tgl
            );
            activity()->log('Menambah Data Covid-19 Pontianak untuk data pada tanggal '
            .Carbon::parse($request->tgl)->format('d M Y'));
            DB::table('c19_ptk')->insert($data);
            return response()->json(['success' => 'Data berhasil disimpan']);
        } else {
            return response()->json(['errors' => 'Data sudah ada pada tanggal ini']);
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
            $data = C19_Ptk::findOrFail($id);
            $array = [
                'di_rs' => $data->di_rs,
                'probable' => $data->probable,
                'discarded' => $data->discarded,
                'isolasi' => $data->isolasi,
                'sembuh' => $data->sembuh,
                'meninggal' => $data->meninggal,
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
            $data = C19_Ptk::findOrFail($id);

            $array = [
                'di_rs' => $data->di_rs,
                'probable' => $data->probable,
                'discarded' => $data->discarded,
                'isolasi' => $data->isolasi,
                'sembuh' => $data->sembuh,
                'meninggal' => $data->meninggal,
                'tgl'=> $data->tgl
            ];

            return response()->json(['result' => $array]);
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
            'di_rs' => 'required|integer|min:0',
            'probable' => 'required|integer|min:0',
            'discarded' => 'required|integer|min:0',
            'isolasi' => 'required|integer|min:0',
            'sembuh' => 'required|integer|min:0',
            'meninggal' => 'required|integer|min:0',
        ]);
        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        $c19_ptk_form = array(
            'di_rs' => $request->di_rs,
            'probable' => $request->probable,
            'discarded' => $request->discarded,
            'isolasi' => $request->isolasi,
            'sembuh' => $request->sembuh,
            'meninggal' => $request->meninggal,
        );
        $c19_ptk = C19_Ptk::where('id', $request->hidden_id)->first();
        activity()->log('Mengupdate Data Covid-19 Pontianak untuk data pada tanggal '.Carbon::parse($c19_ptk->tgl)->format('d M Y'));
        DB::table('c19_ptk')->where('id', $request->hidden_id)->update($c19_ptk_form);
        return response()->json(['success' => 'Berhasil di ubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = C19_Ptk::findOrFail($id);
        activity()->log('Menghapus data Covid-19 Pontianak yang bertanggal '.Carbon::parse($data->tgl)->format('d M Y'));
        $data->delete();
    }
}