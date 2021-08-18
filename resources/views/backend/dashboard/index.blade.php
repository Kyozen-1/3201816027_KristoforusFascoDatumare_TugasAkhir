@extends('backend.layouts.app')
@section('title', 'Admin | Dashboard')
@section('subheader', 'Dashboard')
@section('css')
    <style>
        td {
            text-align: center;
        }
    </style>
@endsection
@section('content')
<?php 
    use App\Models\C19_Klh;
    use App\Models\RS_Data;
    use App\Models\C19_Ptk;
?>
<div class="d-flex flex-column-fluid mb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-custom justify-content-center" style="height: 10rem; text-align: center;">
                    <div class="card-body">
                        <?php 
                            $tgl = C19_Klh::select('tgl')->orderBy('tgl', 'desc')->first();
                            $positif = C19_Klh::where('tgl', $tgl->tgl)->sum('positif');
                        ?>
                        @if ($positif == null)
                            <h1 class="text-danger font-weight-bold mb-1">0</h1>
                        @else
                            <h1 class="text-danger fonte-weight-bold mb-1">{{$positif}}</h1>
                        @endif
                        <span class="text-danger font-weight-bold font-size-h6">Positif</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom justify-content-center" style="height: 10rem; text-align: center;">
                    <div class="card-body">
                        <?php 
                            $sembuh = C19_Ptk::select('sembuh')->where('tgl', $tgl->tgl)->first();
                        ?>
                        @if ($sembuh->sembuh == null)
                            <h1 class="text-success font-weight-bold mb-1">0</h1>
                        @else
                            <h1 class="text-success fonte-weight-bold mb-1">{{$sembuh->sembuh}}</h1>
                        @endif
                        <span class="text-success font-weight-bold font-size-h6">Sembuh</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom justify-content-center" style="height: 10rem; text-align: center;">
                    <div class="card-body">
                        <?php 
                            $meninggal = C19_Klh::where('tgl', $tgl->tgl)->sum('meninggal');
                        ?>
                        @if ($meninggal == null)
                            <h1 class="text-warning font-weight-bold mb-1">0</h1>
                        @else
                            <h1 class="text-warning fonte-weight-bold mb-1">{{$meninggal}}</h1>
                        @endif
                        <span class="text-warning font-weight-bold font-size-h6">Meninggal</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex flex-column-fluid mb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <div class="card card-custom justify-content-center" style="height: 10rem; text-align: center;">
                    <div class="card-body">
                        <?php 
                            $data = RS_Data::where('tgl', $tgl->tgl)->first();
                            if($data == null)
                            {
                                $bor_icu = 0;
                            } else {
                                $k_icu = $data->k_icu;
                                $jlh_tmpt_icu = $data->jlh_tmpt_icu;
                                $bor_icu = $k_icu - $jlh_tmpt_icu;
                            }
                            
                        ?>
                        @if ($bor_icu == null)
                            <h1 class="text-primary font-weight-bold mb-1">0</h1>
                        @else
                            <h1 class="text-primary fonte-weight-bold mb-1">{{$bor_icu}}</h1>
                        @endif
                        <span class="text-primary font-weight-bold font-size-h6">Kapasitas ICU</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom justify-content-center" style="height: 10rem; text-align: center;">
                    <div class="card-body">
                        <?php 
                            $data = RS_Data::where('tgl', $tgl->tgl)->first();
                            if($data == null)
                            {
                                $bor_isolasi = 0;
                            } else {
                                $k_isolasi = $data->k_isolasi;
                                $jlh_tmpt_positif = $data->jlh_tmpt_positif;
                                $jlh_tmpt_suspek = $data->jlh_tmpt_suspek;
                                $bor_isolasi = $k_isolasi - ($jlh_tmpt_positif - $jlh_tmpt_suspek);
                            }
                        ?>
                        @if ($bor_isolasi == null)
                            <h1 class="text-primary font-weight-bold mb-1">0</h1>
                        @else
                            <h1 class="text-primary fonte-weight-bold mb-1">{{$bor_isolasi}}</h1>
                        @endif
                        <span class="text-primary font-weight-bold font-size-h6">Kapasitas Isolasi</span>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>
<div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-delivery-package text-primary"></i>
                    </span>
                    <h3 class="card-label">Logs Activity Data Covid-19</h3>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover table-checkable" id="table_rs">
                    <thead>
                        <tr class="text-center">
                            <th>Nama Admin</th>
                            <th>Proses yang Dilakukan</th>
                            <th>Kapan Proses Dilakukan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($activity_log as $item)
                            <tr>
                                <td><span class="badge badge-primary">{{$item->user->username}}</span></td>
                                <td><span class="badge badge-warning">{{$item->description}}</span></td>
                                <td>
                                    <span class="badge badge-success">{{Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('metronic/assets/js/pages/crud/datatables/search-options/advanced-search.js') }}"></script>
<script src="{{ asset('metronic/assets/js/pages/features/charts/apexcharts.js') }}"></script>
<script src="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endsection