@extends('backend.layouts.app')
@section('title', 'Admin | Tambah Data Rumah Sakit')
@section('subheader', 'Metode Tambah Semua Data')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-delivery-package text-primary"></i>
                        </span>
                        <h3 class="card-label">Tambah Data</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form action="/admin/rumah-sakit/data" class="form-horizontal" role="form" method="POST" id="data_rs_form">
                        @csrf
                        <span id="span_result"></span>
                        <table class="table table-borderless" id="isi_data">
                            <thead>
                                <tr class="text-center">
                                    <th style="vertical-align:middle;">Nama Rumah Sakit</th>
                                    <th>Ketersediaan Tempat Tidur ICU</th>
                                    <th>Jumlah Tempat Tidur ICU</th>
                                    <th>Ketersediaan Tempat Tidur Isolasi</th>
                                    <th>Jumlah Tempat Tidur Terisi Positif</th>
                                    <th>Jumlah Kamar Tidur Terisi Suspek</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rss as $rs)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="nama_rs{{$rs->id}}" value="{{$rs->id}}">
                                            <label>{{$rs->nama}}</label>
                                        </td>
                                        <td>
                                            <input type="number" id="k_icu" name="k_icu{{$rs->id}}" class="form-control" autocomplete="off" value="0" required>
                                        </td>
                                        <td>
                                            <input type="number" id="jlh_tmpt_icu" name="jlh_tmpt_icu{{$rs->id}}" class="form-control" autocomplete="off" value="0" required>
                                        </td>
                                        <td>
                                            <input type="number" id="k_isolasi" name="k_isolasi{{$rs->id}}" class="form-control" autocomplete="off" value="0" required>
                                        </td>
                                        <td>
                                            <input type="number" id="jlh_tmpt_positif" name="jlh_tmpt_positif{{$rs->id}}" class="form-control" autocomplete="off" value="0" required>
                                        </td>
                                        <td>
                                            <input type="number" id="jlh_tmpt_suspek" name="jlh_tmpt_suspek{{$rs->id}}" class="form-control" autocomplete="off" value="0" required>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>
                                        <p>Tanggal</p>
                                    </td>
                                    <td colspan="5">
                                        <input type="date" id="tgl" name="tgl" class="form-control" autocomplete="off" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary font-weight-bold" type="submit" name="aksi_button" id="aksi_button">Simpan</button>
                    <a class="btn btn-danger font-weight-bold" href="{{ route('rs_data.index') }}">Batal</a>
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
    $('#data_rs_form').on('keyup keypress', function(e){
        var keyCode = e.keyCode || e.which;
        if(keyCode == 13)
        {
            e.preventDefault();
            return false;
        }
    });
</script>
@endsection