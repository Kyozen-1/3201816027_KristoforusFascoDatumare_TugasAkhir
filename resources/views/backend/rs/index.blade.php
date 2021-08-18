@extends('backend.layouts.app')
@section('title', 'Admin | Rumah Sakit')
@section('subheader', 'Rumah Sakit')

@section('css')
    <style>
        .table td
        {
            text-align: center;
        }
    </style>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.css" type="text/css">
@endsection

@section('content')
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-delivery-package text-primary"></i>
                    </span>
                    <h3 class="card-label">Table Data</h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Dropdown-->
                    {{-- <div class="dropdown dropdown-inline mr-2">
                        <button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="svg-icon svg-icon-md">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3" />
                                    <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>Export</button>
                        <!--begin::Dropdown Menu-->
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <!--begin::Navigation-->
                            <ul class="navi flex-column navi-hover py-2">
                                <li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">Choose an option:</li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="la la-print"></i>
                                        </span>
                                        <span class="navi-text">Print</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="la la-copy"></i>
                                        </span>
                                        <span class="navi-text">Copy</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="la la-file-excel-o"></i>
                                        </span>
                                        <span class="navi-text">Excel</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="la la-file-text-o"></i>
                                        </span>
                                        <span class="navi-text">CSV</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="la la-file-pdf-o"></i>
                                        </span>
                                        <span class="navi-text">PDF</span>
                                    </a>
                                </li>
                            </ul>
                            <!--end::Navigation-->
                        </div>
                        <!--end::Dropdown Menu-->
                    </div> --}}
                    <!--end::Dropdown-->
                    <!--begin::Button-->
                    <button class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#modalRS" title="Add Data" name="create" id="create">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <circle fill="#000000" cx="9" cy="15" r="6" />
                                <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>Add Data</button>
                    <!--end::Button-->
                </div>
            </div>
            <div class="card-body">
                <!--begin: Search Form-->
                {{-- <form class="mb-15">
                    <div class="row mb-6">
                        <div class="col-lg-3 mb-lg-0 mb-6">
                            <label>RecordID:</label>
                            <input type="text" class="form-control datatable-input" placeholder="E.g: 4590" data-col-index="0" />
                        </div>
                        <div class="col-lg-3 mb-lg-0 mb-6">
                            <label>OrderID:</label>
                            <input type="text" class="form-control datatable-input" placeholder="E.g: 37000-300" data-col-index="1" />
                        </div>
                        <div class="col-lg-3 mb-lg-0 mb-6">
                            <label>Country:</label>
                            <select class="form-control datatable-input" data-col-index="2">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="col-lg-3 mb-lg-0 mb-6">
                            <label>Agent:</label>
                            <input type="text" class="form-control datatable-input" placeholder="Agent ID or name" data-col-index="4" />
                        </div>
                    </div>
                    <div class="row mb-8">
                        <div class="col-lg-3 mb-lg-0 mb-6">
                            <label>Ship Date:</label>
                            <div class="input-daterange input-group" id="kt_datepicker">
                                <input type="text" class="form-control datatable-input" name="start" placeholder="From" data-col-index="5" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-ellipsis-h"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control datatable-input" name="end" placeholder="To" data-col-index="5" />
                            </div>
                        </div>
                        <div class="col-lg-3 mb-lg-0 mb-6">
                            <label>Status:</label>
                            <select class="form-control datatable-input" data-col-index="6">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="col-lg-3 mb-lg-0 mb-6">
                            <label>Type:</label>
                            <select class="form-control datatable-input" data-col-index="7">
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-8">
                        <div class="col-lg-12">
                        <button class="btn btn-primary btn-primary--icon" id="kt_search">
                            <span>
                                <i class="la la-search"></i>
                                <span>Search</span>
                            </span>
                        </button>&#160;&#160;
                        <button class="btn btn-secondary btn-secondary--icon" id="kt_reset">
                            <span>
                                <i class="la la-close"></i>
                                <span>Reset</span>
                            </span>
                        </button></div>
                    </div>
                </form> --}}
                <!--begin: Datatable-->
                <!--begin: Datatable-->
                <table class="table table-bordered table-hover table-checkable" id="table_rs">
                    <thead>
                        <tr class="text-center">
                            <th width="10%">No</th>
                            <th width="30%">Rumah Sakit</th>
                            <th width="20%">Longtitude</th>
                            <th width="20%">Lattitude</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                </table>
                <!--end: Datatable-->
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>

<div class="modal fade" id="modalRS" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLabel">Add Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <div class="row">
                    <div class="col-md-8">
                        <div id="map" style="width: 100%; height: 65vh;"></div>
                    </div>
                    <div class="col-md-4">
                        <form class="form-horizontal" id="rs_form" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="long" class="control-label col-md-4 align-self-center">Longtitude</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="long" id="long" autocomplete="off" required>
                                </div>                        
                            </div>
                            <div class="form-group row">
                                <label for="lat" class="control-label col-md-4 align-self-center">Lattitude</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="lat" id="lat" autocomplete="off" required>
                                </div>                        
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="control-label col-md-4 align-self-center">Nama Rumah Sakit</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="nama" id="nama" autocomplete="off" placeholder="Masukan nama rumah sakit..." required>
                                </div>                        
                            </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="aksi" id="aksi" value="Save">
                <input type="hidden" name="hidden_id" id="hidden_id">
                <button type="submit" name="aksi_button" id="aksi_button" class="btn btn-primary font-weight-bold">Save</button>
            </div>
        </form>
        </div>
    </div>
</div>

<div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="detailModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailLabel">Detail Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="detail_nama" class="control-label col-md-4 align-self-center">Nama Rumah Sakit</label>
                    <div class="col-md-8">
                        <span id="detail_nama"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="detail_long" class="control-label col-md-4 align-self-center">Longtitude</label>
                    <div class="col-md-8">
                        <span id="detail_long"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="detail_lat" class="control-label col-md-4 align-self-center">Lattitude</label>
                    <div class="col-md-8">
                        <span id="detail_lat"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirm">Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <h4 class="text-center" style="margin: 0;">Apakah anda yakin menghapus?</h4>
                <p class="text-danger text-center">(Jika anda menghapus Rumah Sakit ini, maka semua data yang terkait dengan Rumah Sakit ini akan terhapus!!!)</p>
            </div>
            <div class="modal-footer">
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">Ok</button>
                <button class="btn btn-primary" type="button" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
        <script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
        <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>
        <!--begin::Page Vendors(used by this page)-->
        <script src="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <!--end::Page Vendors-->
        <!--begin::Page Scripts(used by this page)-->
        <script src="{{ asset('metronic/assets/js/pages/crud/datatables/search-options/advanced-search.js') }}"></script>

        <script>
            $(document).ready(function(){
                var dataTables = $('#table_rs').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('rs.index') }}",
                    },
                    columns: [
                        {
                            data: 'DT_RowIndex'
                        },
                        {
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: 'lng',
                            name: 'lng'
                        },
                        {
                            data: 'lat',
                            name: 'lat'
                        },
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false
                        }
                    ]
                });
            });

            $(document).on('click', '.detail', function(){
                var id = $(this).attr('id');
                $.ajax({
                    url: "/admin/rumah-sakit/"+id+"/detail",
                    dataType: "json",
                    success: function(data)
                    {
                        $('#detail_nama').text(data.result.nama);
                        $('#detail_long').text(data.result.long);
                        $('#detail_lat').text(data.result.lat);
                        $('#detail').modal('show');
                    }
                });
            });

            $('#create').click(function(){
                $('#rs_form')[0].reset();
                $('.modal-title').text('Add Data');
                $('#aksi_button').val('Save');
                $('#aksi').val('Save');
                $('#form_result').html('');
                mapboxgl.accessToken = 'pk.eyJ1Ijoia3Jpc3RvZm9ydXMiLCJhIjoiY2twZzNhZ3MwMDBlbzJucDRwNmhuYmZiZCJ9.7PP-LErWIjLon-ZiT9q_xA';
                var map = new mapboxgl.Map({
                    container: 'map', // container id
                    style: 'mapbox://styles/mapbox/streets-v11', // style URL
                    center: [109.34468508260471, -0.023170800986903828], // starting position [lng, lat]
                    zoom: 12 // starting zoom
                });
                map.addControl(new MapboxGeocoder({
                    accessToken: mapboxgl.accessToken,
                    mapboxgl: mapboxgl
                }));
                map.addControl(new mapboxgl.NavigationControl());

                map.on('click', (e) => {
                    const longtitude = e.lngLat.lng;
                    const lattitude = e.lngLat.lat;

                    $('#long').val(longtitude);
                    $('#lat').val(lattitude);
                });
            });  

            $('#rs_form').on('submit', function(e){
                e.preventDefault();
                if($('#aksi').val() == 'Save')
                {
                    $.ajax({
                        url: "{{ route('rs.store') }}",
                        method: "POST",
                        data: $(this).serialize(),
                        dataType: "json",
                        beforeSend: function()
                        {
                            $('#aksi_button').text('Menyimpan...');
                        },
                        success: function(data)
                        {
                            var html = '';
                            if(data.errors)
                            {
                                html = '<div class="alert alert-danger">'+data.errors+'</div>';
                                $('#rs_form')[0].reset();
                                $('#aksi_button').text('Save');
                                $('#table_rs').DataTable().ajax.reload();
                            }
                            if(data.success)
                            {
                                html = '<div class="alert alert-success">'+data.success+'</div>';
                                $('#rs_form')[0].reset();
                                $('#aksi_button').text('Save');
                                $('#table_rs').DataTable().ajax.reload();
                            }

                            $('#form_result').html(html);
                        }
                    });
                }
                if($('#aksi').val() == 'Edit')
                {
                    $.ajax({
                        url: "{{ route('rs.update') }}",
                        method: "POST",
                        data: $(this).serialize(),
                        dataType: "json",
                        beforeSend: function(){
                            $('#aksi_button').text('Mengubah...');
                        },
                        success: function(data)
                        {
                            var html = '';
                            if(data.errors)
                            {
                                html = '<div class="alert alert-danger">'+data.errors+'</div>';
                                $('#aksi_button').text('Save');
                            }
                            if(data.success)
                            {
                                // html = '<div class="alert alert-success">'+ data.success +'</div>';
                                $('#rs_form')[0].reset();
                                $('#aksi_button').text('Save');
                                $('#table_rs').DataTable().ajax.reload();
                                $('#modalRS').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil di ubah',
                                    showConfirmButton: true
                                });
                            }

                            $('#form_result').html(html);
                        }
                    });
                }
            });

            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                $('#form_result').html('');
                mapboxgl.accessToken = 'pk.eyJ1Ijoia3Jpc3RvZm9ydXMiLCJhIjoiY2twZzNhZ3MwMDBlbzJucDRwNmhuYmZiZCJ9.7PP-LErWIjLon-ZiT9q_xA';
                var map = new mapboxgl.Map({
                    container: 'map', // container id
                    style: 'mapbox://styles/mapbox/streets-v11', // style URL
                    center: [109.34468508260471, -0.023170800986903828], // starting position [lng, lat]
                    zoom: 12 // starting zoom
                });
                map.addControl(new MapboxGeocoder({
                    accessToken: mapboxgl.accessToken,
                    mapboxgl: mapboxgl
                }));
                map.addControl(new mapboxgl.NavigationControl());

                map.on('click', (e) => {
                    const longtitude = e.lngLat.lng;
                    const lattitude = e.lngLat.lat;

                    $('#long').val(longtitude);
                    $('#lat').val(lattitude);
                });
                $.ajax({
                    url: "/admin/rumah-sakit/"+id+"/edit",
                    dataType: "json",
                    success: function(data)
                    {
                        $('#nama').val(data.result.nama);
                        $('#long').val(data.result.lng);
                        $('#lat').val(data.result.lat);
                        $('#hidden_id').val(id);
                        $('.modal-title').text('Edit Data');
                        $('#aksi_button').val('Edit');
                        $('#aksi').val('Edit');
                        $('#modalRS').modal('show');
                    }
                });
            });

            var user_id;
            $(document).on('click', '.delete', function(){
                user_id = $(this).attr('id');
                $('modal-title').text('Konfirmasi');
                $('#confirmModal').modal('show');
                $('#ok_button').text('Ok');
            });

            $('#ok_button').click(function(){
                $.ajax({
                    url: "{{ url('/admin/rumah-sakit/destroy') }}"+'/'+user_id,
                    beforeSend: function(){
                        $('#ok_button').text('Deleting....');
                    },
                    success: function(data)
                    {
                        $('#confirmModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil di hapus',
                            showConfirmButton: true
                        });
                        $('#table_rs').DataTable().ajax.reload();
                    }
                });
            });
        </script>
@endsection