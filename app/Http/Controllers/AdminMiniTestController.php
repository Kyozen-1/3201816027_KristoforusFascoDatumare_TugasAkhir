<?php

namespace App\Http\Controllers;

use App\Models\MiniTest;
use Illuminate\Http\Request;
use DB;
use Validator;
use DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;

class AdminMiniTestController extends Controller
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
            $data = MiniTest::all();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function($data){
                    $button = '<button type="button" name="detail" id="'.$data->id.'" class="detail btn btn-sm btn-clean btn-icon" title="Detail Data"><i class="la la-eye"></i></button>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" 
                    class="edit btn btn-sm btn-clean btn-icon" title="Edit Data"><i class="la la-pen"></i></button>';
                    $button .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-sm btn-clean btn-icon" title="Delete Data"><i class="la la-trash"></i></button>';
                    return $button;
                })
                ->editColumn('pertanyaan', function($data){
                    return Str::limit($data->pertanyaan,20);
                })
                ->editColumn('a', function($data){
                    return Str::limit($data->a,20);
                })
                ->editColumn('b', function($data){
                    return Str::limit($data->b,20);
                })
                ->editColumn('c', function($data){
                    return Str::limit($data->c,20);
                })
                ->editColumn('d', function($data){
                    return Str::limit($data->d,20);
                })
                ->rawColumns(['actions', 'pertanyaan', 'a', 'b', 'c', 'd'])
                ->make(true);
        }
        return view('backend.mini_test.index');
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
        $errors = Validator::make($request->all(), [
            'pertanyaan' => 'required',
            'a' => 'required',
            'b' => 'required',
            'c' => 'required',
            'd' => 'required',
            'jawaban' => 'required | integer'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        $data[] = array(
            'pertanyaan' => $request->pertanyaan,
            'a' => $request->a,
            'b' => $request->b,
            'c' => $request->c,
            'd' => $request->d,
            'jawaban' => $request->jawaban
        );

        DB::table('mini_test')->insert($data);
        return response()->json(['success' => 'Data berhasil disimpan']);
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
            $data = MiniTest::findOrFail($id);
            $array = [
                'pertanyaan' => $data->pertanyaan,
                'a' => $data->a,
                'b' => $data->b,
                'c' => $data->c,
                'd' => $data->d,
                'jawaban' => $data->jawaban
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
            $data = MiniTest::findOrFail($id);
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
        $errors = Validator::make($request->all(), [
            'pertanyaan' => 'required',
            'a' => 'required',
            'b' => 'required',
            'c' => 'required',
            'd' => 'required',
            'jawaban' => 'required | integer'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        $minitest_form = array(
            'pertanyaan' => $request->pertanyaan,
            'a' => $request->a,
            'b' => $request->b,
            'c' => $request->c,
            'd' => $request->d,
            'jawaban' => $request->jawaban
        );

        DB::table('mini_test')->where('id', $request->hidden_id)->update($minitest_form);
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
        $data = MiniTest::findOrFail($id);
        $data->delete();
    }
}