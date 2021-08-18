@extends('backend.layouts.app')
@section('title', 'Admin | Tambah Data Covid-19_Kelurahan')
@section('subheader', 'Tambah Data')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-delivery-package text-primary"></i>
                        </span>
                        <h3 class="card-label">Metode Tambah Semua Data</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form action="/admin/kelurahan/covid19" class="form-horizontal" role="form" method="POST" id="c19_klh_form">
                        @csrf
                        <table class="table table-borderless" id="isi_data">
                            <thead>
                                <tr class="text-center">
                                    <th>Nama Kelurahan</th>
                                    <th>Kontak Erat</th>
                                    <th>Suspek</th>
                                    <th>Positif</th>
                                    <th>Positif (Isolasi)</th>
                                    <th>Meninggal</th>
                                    <th>Warna</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelurahans as $kelurahan)
                                <tr>
                                    <td><input type="hidden" name="id_kelurahan{{$kelurahan->id}}" value="{{$kelurahan->id}}"><label class="control-label">{{$kelurahan->nama}}</label></td>
                                    <td><input type="number" class="form-control" name="kontak_erat{{$kelurahan->id}}" id="kontak_erat" autocomplete="off" value="0" required></td>
                                    <td><input type="number" class="form-control" name="suspek{{$kelurahan->id}}" id="suspek" autocomplete="off" value="0" required></td>
                                    <td><input type="number" class="form-control" name="positif{{$kelurahan->id}}" id="positif" autocomplete="off" value="0" required></td>
                                    <td><input type="number" class="form-control" name="positif_isolasi{{$kelurahan->id}}" id="positif_isolasi" autocomplete="off" value="0" required></td>
                                    <td><input type="number" class="form-control" name="meninggal{{$kelurahan->id}}" id="meninggal" autocomplete="off" value="0" required></td>
                                    <td>
                                        <select name="color{{$kelurahan->id}}" id="color" class="form-control selectpicker" required>
                                            @foreach ($colors as $color)
                                                <option value="{{$color->color}}" style="color:{{$color->color}};">{{$color->nama}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td><label>Tanggal</label></td>
                                    <td colspan="6">
                                        <input type="date" class="form-control" name="tgl" id="tgl" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary font-weight-bold" type="submit" name="aksi_button" id="aksi_button">Simpan</button>
                    <a class="btn btn-danger font-weight-bold" href="{{ route('c19_klh.index') }}">Batal</a>
                </div>
            </form>
            </div>
        </div>
    </div>
{{-- <option value="#f71010" style="color: #f71010">Merah</option>
<option value="#f76b13" style="color: #f76b13">Orange Tua</option>
<option value="#f7910e" style="color: #f7910e">Orange</option>
<option value="#f5ce0f" style="color: #f5ce0f">Kuning</option>
<option value="#f7f164" style="color: #f7f164">Kuning Muda</option> --}}
@endsection

@section('js')
    <script>
        $('#c19_klh_form').on('keyup keypress', function(e){
            var keyCode = e.keyCode || e.which;
            if(keyCode == 13)
            {
                e.preventDefault();
                return false;
            }
        });
    </script>
@endsection