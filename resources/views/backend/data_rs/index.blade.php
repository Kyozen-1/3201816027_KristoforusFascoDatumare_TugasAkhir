@extends('backend.layouts.app')
@section('title', 'Admin | Data Rumah Sakit')
@section('subheader', 'Data Rumah Sakit')

@section('css')
    <style>
        #table_rs_data td
        {
            text-align: center;
        }
        /* #table_rs_data th, td{
            white-space: nowrap;
        }

        #table_create td{
            vertical-align: middle;
        } */
        #selectBox option{
            color: black;
            background: white;
        }
    </style>
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
                    <a href="{{ route('rs_data.export') }}" class="btn btn-success font-weight-bolder" style="margin-right: 3px;" title="Export Data">Export Data</a>
                    <button type="button" class="btn btn-warning font-weight-bolder" title="Import Data" data-toggle="modal" data-target="#import_modal">Import Data</button>
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
                    <select class="btn btn-primary font-weight-border form-control" id="selectBox" name="selectBox" onchange="javascript:location.href = this.value;">
                        <option value="#">Masukan Data</option>
                        <option value="{{route('rs_data.sps')}}">Satu Per Satu</option>
                        <option value="{{route('rs_data.create')}}">Semua</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <!--begin: Search Form-->
                <form class="mb-15">
                    <div class="row mb-8">
                        <div class="col-lg-4 mb-lg-0 mb-6">
                            <label>Nama Rumah Sakit:</label>
                            <select name="filter_rs" id="filter_rs" class="form-control datatable-input" data-col-index="2">
                                <option value="">Pilih Rumah Sakit</option>
                                @forelse ($rss as $rs)
                                <option value="{{$rs->id}}">{{$rs->nama}}</option>
                                @empty
                                    <option value="" disabled>Belum ada kelurahan</option>
                                @endforelse
                            </select>
                        </div>

                        <div class="col-lg-4 mb-lg-0 mb-6">
                            <label>Tanggal:</label>
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="form-control datatable-input" name="from_date" id="from_date" placeholder="From" data-col-index="5" autocomplete="off" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-ellipsis-h"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control datatable-input" name="to_date" id="to_date" placeholder="To" data-col-index="5" autocomplete="off"/>
                            </div>
                        </div>

                        <div class="col-lg-4 align-self-center text-center">
                            <button type="button" class="btn btn-primary btn-primary--icon" id="search">
                                <span>
                                    <i class="la la-search"></i>
                                    <span>Search</span>
                                </span>
                            </button>&#160;&#160;
                            <button type="button" class="btn btn-secondary btn-secondary--icon" id="reset">
                                <span>
                                    <i class="la la-close"></i>
                                    <span>Reset</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
                <!--begin: Datatable-->
                <!--begin: Datatable-->
                <table class="table table-bordered table-hover table-checkable" id="table_rs_data">
                    <thead>
                        <tr class="justify-content-center text-center">
                            <th>No</th>
                            <th>Nama Rumah Sakit</th>
                            <th>Kapasitas ICU</th>
                            <th>Jumlah Tempat ICU Terisi</th>
                            <th>BOR ICU (%)</th>
                            <th>Kapasitas Isolasi</th>
                            <th>Jumlah Terisi Positif Covid-19</th>
                            <th>Jumlah Terisi Suspek</th>
                            <th>BOR Isolasi (%)</th>
                            <th>Tanggal</th>
                            <th>Actions</th>
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

<div class="modal fade" id="import_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">IMPORT DATA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('rs_data.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>PILIH FILE</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-success">IMPORT</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="detailModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailLabel">Detail Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="show_nama_rs" class="control-label col-md-4">Nama Rumah Sakit</label>
                    <div class="col-md-8">
                        <p id="show_nama_rs"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="show_k_icu" class="control-label col-md-4">Ketersediaan tempat tidur ICU</label>
                            <div class="col-md-8">
                                <p id="show_k_icu"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="show_jlh_tmpt_icu" class="control-label col-md-4">Jumlah tempat tidur ICU</label>
                            <div class="col-md-8">
                                <p id="show_jlh_tmpt_icu"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="show_bor_icu" class="control-label col-md-4">BOR ICU (%)</label>
                        </div>
                        <div id="bor_icu" class="d-flex justify-content-center"></div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="show_k_isolasi" class="control-label col-md-4">Ketersediaan tempat tidur Isolasi</label>
                            <div class="col-md-8">
                                <p id="show_k_isolasi"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="show_jlh_tmpt_positif" class="control-label col-md-4">Jumlah tempat tidur terisi positif</label>
                            <div class="col-md-8">
                                <p id="show_jlh_tmpt_positif"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="show_jlh_tmpt_suspek" class="control-label col-md-4">Jumlah kamar tidur terisi suspek</label>
                            <div class="col-md-8">
                                <p id="show_jlh_tmpt_suspek"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="show_bor_isolasi" class="control-label col-md-4">BOR Isolasi (%)</label>                            
                        </div>
                        <div id="bor_isolasi" class="d-flex justify-content-center"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="show_tgl" class="control-label col-md-4">Tanggal Menambahkan:</label>
                    <div class="col-md-8">
                        <p id="show_tgl"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLabel">Edit Data</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <i class="ki ki-close" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <span id="edit_form_result"></span>
                <form class="form-horizontal" id="edit_rs_data_form" method="POST">
                    @csrf
                <div class="form-group row">
                    <label for="edit_rs" class="control-label col-md-4">Nama Rumah Sakit:</label>
                    <div class="col-md-8">
                        <input type="hidden" name="edit_id_rs" id="edit_id_rs">
                        <input type="text" class="form-control" id="edit_rs" name="edit_rs" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_k_icu" class="control-label col-md-4">Ketersediaan tempat tidur ICU :</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="edit_k_icu" name="edit_k_icu" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_jlh_tmpt_icu" class="control-label col-md-4">Jumlah tempat tidur ICU Terisi Pasien:</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="edit_jlh_tmpt_icu" name="edit_jlh_tmpt_icu" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_k_isolasi" class="control-label col-md-4">Ketersediaan tempat tidur Isolasi:</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="edit_k_isolasi" name="edit_k_isolasi" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_jlh_tmpt_positif" class="control-label col-md-4">Jumlah tempat tidur terisi positif:</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="edit_jlh_tmpt_positif" name="edit_jlh_tmpt_positif" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_jlh_tmpt_suspek" class="control-label col-md-4">Jumlah kamar tidur terisi suspek:</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="edit_jlh_tmpt_suspek" name="edit_jlh_tmpt_suspek" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_tgl" class="control-label col-md-4">Tanggal:</label>
                    <div class="col-md-8">
                        <input type="date" class="form-control" id="edit_tgl" name="edit_tgl" autocomplete="off" disabled>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="edit_aksi" id="edit_aksi" value="Edit">
                <input type="hidden" name="edit_hidden_id" id="edit_hidden_id">
                <button type="submit" name="edit_aksi_button" id="edit_aksi_button" class="btn btn-primary font-weight-bold">Save</button>
            </div>
        </form>
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
                <p class="text-danger text-center">(Jika anda menghapus, maka semua data pada tanggal <span class="text-danger" id="destroy_tgl"></span> tersebut akan terhapus)</p>
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
    <!--begin::Page Vendors(used by this page)-->
    <script src="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('metronic/assets/js/pages/crud/datatables/search-options/advanced-search.js') }}"></script>
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/bootstrap-select.js') }}"></script>
    <script src="{{ asset('metronic/assets/js/pages/features/charts/apexcharts.js') }}"></script>

    <script>
        $(document).ready(function(){
            $('.input-daterange').datepicker({
                todayBtn: 'linked',
                format: 'yyyy-mm-dd',
                autoclose: true
            });
            fill_datatable();
            function fill_datatable(filter_rs = '', from_date = '', to_date = '')
            {
                var dataTables = $('#table_rs_data').DataTable({
                // scrollX: true,
                // scrollCollapse: true,
                // paging: false,
                // columnDefs: [
                //     { width: '20%', targets: 0 }
                // ],
                // fixedColumns: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('rs_data.index') }}",
                    data: {filter_rs:filter_rs, from_date:from_date, to_date:to_date}
                },
                columns: [
                        {
                            data: 'DT_RowIndex'
                        },
                        {
                            data: 'rs',
                            name: 'rs'
                        },
                        {
                            data: 'k_icu',
                            name: 'k_icu'
                        },
                        {
                            data: 'jlh_tmpt_icu',
                            name: 'jlh_tmpt_icu'
                        },
                        {
                            data: 'bor_icu',
                            name: 'bor_icu'
                        },
                        {
                            data: 'k_isolasi',
                            name: 'k_isolasi'
                        },
                        {
                            data: 'jlh_tmpt_positif',
                            name: 'jlh_tmpt_positif'
                        },
                        {
                            data: 'jlh_tmpt_suspek',
                            name: 'jlh_tmpt_suspek'
                        },
                        {
                            data: 'bor_isolasi',
                            name: 'bor_isolasi'
                        },
                        {
                            data: 'tgl',
                            name: 'tgl'
                        },
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false
                        }
                    ]
                });
            }

            $('#search').click(function(){
                var filter_rs = $('#filter_rs').val();
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();

                if(filter_rs != '')
                {
                    if(from_date != '' && to_date != '')
                    {
                        $('#table_rs_data').DataTable().destroy();
                        fill_datatable(filter_rs, from_date, to_date);
                    } else {
                        $('#table_rs_data').DataTable().destroy();
                        fill_datatable(filter_rs);
                    }
                } else {
                    $('#table_rs_data').DataTable().destroy();
                    fill_datatable("", from_date, to_date);
                }
            });

            $('#reset').click(function(){
                $("[name='filter_rs']").val('');
                $("[name='filter_rs']").trigger('change');
                $('#from_date').val('');
                $('#to_date').val('');
                $('#table_rs_data').DataTable().destroy();
                fill_datatable();
            });
        });

        $('#selectBox').change(function(){
            if($(this).val() == "{{route('rs_data.create')}}")
            {
                window.onload = function(){
                    location.href=document.getElementById("selectbox").value;
                } 
            }
            if ($(this).val()  == "{{route('rs_data.sps')}}")
            {
                window.onload = function(){
                    location.href=document.getElementById("selectbox").value;
                }
            }
        });

        $(document).on('click', '.detail', function(){
            var id = $(this).attr('id');
            $.ajax({
                url: "/admin/rumah-sakit/data/"+id+"/detail",
                dataType: "json",
                success: function(data)
                {
                    $('#show_nama_rs').text(data.result.rs);
                    $('#show_k_icu').text(data.result.k_icu);
                    $('#show_jlh_tmpt_icu').text(data.result.jlh_tmpt_icu);
                    var option_bor_icu = {
                        series: [data.result.jlh_tmpt_icu, data.result.tersisa_icu],
                        chart: {
                            width: 380,
                            type: 'pie',
                        },
                        labels: ['Terisi', 'Tersisa'],
                        responsive: [{
                        breakpoint: 480,
                            options: {
                                chart: {
                                width: 200
                                },
                                legend: {
                                position: 'bottom'
                                }
                            }
                        }]
                    };

                    var chart = new ApexCharts(document.querySelector("#bor_icu"), option_bor_icu);
                    chart.render();
                    $('#show_k_isolasi').text(data.result.k_isolasi);
                    $('#show_jlh_tmpt_positif').text(data.result.jlh_tmpt_positif);
                    $('#show_jlh_tmpt_suspek').text(data.result.jlh_tmpt_suspek);
                    var option_bor_isolasi = {
                        series: [data.result.jlh_tmpt_positif, data.result.jlh_tmpt_suspek, data.result.tersisa_isolasi],
                        chart: {
                            width: 380,
                            type: 'pie',
                        },
                        labels: ['Tempat Positif', 'Tempat Suspek', 'Tersisa'],
                        responsive: [{
                        breakpoint: 480,
                            options: {
                                chart: {
                                width: 200
                                },
                                legend: {
                                position: 'bottom'
                                }
                            }
                        }]
                    };

                    var chart = new ApexCharts(document.querySelector("#bor_isolasi"), option_bor_isolasi);
                    chart.render();
                    $('#show_tgl').text(data.result.tgl);
                    $('#detail').modal('show');
                }
            });
        });

        $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            $('#form_result').html('');
            $.ajax({
                url: "/admin/rumah-sakit/data/"+id+"/edit",
                dataType: "json",
                success: function(data)
                {
                    $("#edit_id_rs").val(data.result.id_rs);
                    $('#edit_rs').val(data.result.nama_rs);
                    $('#edit_k_icu').val(data.result.k_icu);
                    $('#edit_jlh_tmpt_icu').val(data.result.jlh_tmpt_icu);
                    $('#edit_k_isolasi').val(data.result.k_isolasi);
                    $('#edit_jlh_tmpt_positif').val(data.result.jlh_tmpt_positif);
                    $('#edit_jlh_tmpt_suspek').val(data.result.jlh_tmpt_suspek);
                    $('#edit_tgl').val(data.result.tgl);
                    $('#edit_hidden_id').val(id);
                    $('#edit_aksi_button').val('Edit');
                    $('#edit_aksi').val('Edit');
                    $('#edit').modal('show');
                }
            });
        });

        $('#edit_rs_data_form').on('submit', function(e){
            e.preventDefault();
            if($('#edit_aksi').val() == 'Edit')
            {
                $.ajax({
                    url: "{{ route('rs_data.update') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function(){
                        $('#edit_button_aksi').text('Mengubah...');
                    },
                    success: function(data)
                    {
                        var html = '';
                        if (data.errors)
                        {
                            html = '<div class="alert alert-danger">'+data.errors+'</div>';
                            $('#edit_aksi_button').text('Save');
                        }
                        if (data.success)
                        {
                            $('#edit_rs_data_form')[0].reset();
                            $('#edit_aksi_button').text('Save');
                            $('#table_rs_data').DataTable().ajax.reload();
                            $('#edit').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil di ubah',
                                showConfirmButton: true
                            });
                        }
                        $('#edit_form_result').html(html);
                    }
                });
            }
        });

        var user_id;
        $(document).on('click', '.delete', function(){
            user_id = $(this).attr('id');
            $.ajax({
                url: "/admin/rumah-sakit/data/destroy/tgl/" + user_id,
                dataType: "json",
                success: function(data)
                {
                    $('modal-title').text('Konfirmasi');
                    $('#destroy_tgl').text(data.result.tgl);
                    $('#confirmModal').modal('show');
                    $('#ok_button').text('Ok');
                }
            });
        });

        $('#ok_button').click(function(){
            $.ajax({
                url: "{{ url('/admin/rumah-sakit/data/destroy/') }}"+'/'+user_id,
                beforeSend: function(){
                    $('#ok_button').text('Deleting...');
                },
                success: function(data)
                {
                    $('#confirmModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil di hapus',
                        showConfirmButton: true
                    });
                    $('#table_rs_data').DataTable().ajax.reload();
                }
            });
        });
    </script>
@endsection