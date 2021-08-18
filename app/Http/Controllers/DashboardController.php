<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\C19_Klh;
use App\Models\ActivityLog;
use App\User;
use DB;
use Validator;
use DataTables;
use Carbon\Carbon;

class DashboardController extends Controller
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
        $user = User::select()->count();
        $c19_klh = C19_Klh::select()->count();
        $activity_log = ActivityLog::with('user')->limit(10)->orderBy('id', 'desc')->get();
        return view('backend.dashboard.index', compact('user', 'c19_klh', 'activity_log'));
    }
}