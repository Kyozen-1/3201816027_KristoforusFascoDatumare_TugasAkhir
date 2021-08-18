@extends('backend.layouts.app');
@section('title', 'Admin | Covid-19 Pontianak')
@section('subheader', 'Covid-19 Kota Pontianak')

@section('css')
<style>
    .table td
    {
        text-align: center;
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
                    <a href="{{ route('c19_ptk.export') }}" class="btn btn-success font-weight-bolder" style="margin-right: 3px;" title="Export Data">Export Data</a>
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
                    <!--begin::Button-->
                    <button class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#modalC19_Ptk" title="Add Data" name="create" id="create">
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
                <form class="mb-15">
                    <div class="row mb-8">
                        <div class="col-lg-8 mb-lg-0 mb-6">
                            <label>Tanggal:</label>
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="form-control datatable-input" name="from_date" id="from_date"placeholder="From" data-col-index="5" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-ellipsis-h"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control datatable-input" name="to_date" id="to_date" placeholder="To" data-col-index="5" />
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
                <table class="table table-bordered table-hover table-checkable" id="c19_ptk_table">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Dirawat di RS</th>
                            <th>Probable</th>
                            <th>Discarded</th>
                            <th>Perawatan Isolasi</th>
                            <th>Sembuh</th>
                            <th>Meninggal</th>
                            <th>Tanggal</th>
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

<div class="modal fade" id="import_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">IMPORT DATA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('c19_ptk.import') }}" method="POST" enctype="multipart/form-data">
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

<div class="modal fade" id="modalC19_Ptk" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLabel">Add Data</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <i class="ki ki-close" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="c19_ptk_form" method="POST">
                    <span id="form_result"></span>
                    @csrf
                    <div class="form-group row">
                        <label for="di_rs" class="control-label col-md-4 align-self-center">Di Rawat di RS</label>
                        <div class="col-md-8">
                            <input type="number" class="form-control" id="di_rs" name="di_rs" autocomplete="off" value="0" autofocus required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="di_rs" class="control-label col-md-4 align-self-center">Probable</label>
                        <div class="col-md-8">
                            <input type="number" class="form-control" id="probable" name="probable" autocomplete="off" value="0" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="di_rs" class="control-label col-md-4 align-self-center">Discarded</label>
                        <div class="col-md-8">
                            <input type="number" class="form-control" id="discarded" name="discarded" autocomplete="off" value="0" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="di_rs" class="control-label col-md-4 align-self-center">Isolasi</label>
                        <div class="col-md-8">
                            <input type="number" class="form-control" id="isolasi" name="isolasi" autocomplete="off" value="0" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="di_rs" class="control-label col-md-4 align-self-center">Sembuh</label>
                        <div class="col-md-8">
                            <input type="number" class="form-control" id="sembuh" name="sembuh" autocomplete="off" value="0" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="di_rs" class="control-label col-md-4 align-self-center">Meninggal</label>
                        <div class="col-md-8">
                            <input type="number" class="form-control" id="meninggal" name="meninggal" autocomplete="off" value="0" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tgl" class="control-label col-md-4 align-self-center">Tanggal</label>
                        <div class="col-md-8">
                            <input type="date" class="form-control" name="tgl" id="tgl" required>
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
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailLabel">Detail Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="namaDiRs" class="control-label col-md-4">Jumlah di rawat di RS:</label>
                                <div class="col-md-6">
                                    <p id="show_di_rs"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="namaProbable" class="control-label col-md-4">Probable:</label>
                                <div class="col-md-6">
                                    <p id="show_probable"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="namaDiscarded" class="control-label col-md-4">Discarded:</label>
                                <div class="col-md-6">
                                    <p id="show_discarded"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="namaIsolasi" class="control-label col-md-4">Isolasi:</label>
                                <div class="col-md-6">
                                    <p id="show_isolasi"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="namaSembuh" class="control-label col-md-4">Sembuh:</label>
                                <div class="col-md-6">
                                    <p id="show_sembuh"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="namaMeninggal" class="control-label col-md-4">Meninggal:</label>
                                <div class="col-md-6">
                                    <p id="show_meninggal"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="namaTanggal" class="control-label col-md-4">Tanggal Menambahkan:</label>
                                <div class="col-md-6">
                                    <p id="show_tanggal"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 align-self-center">
                            <div class="container">
                                <div class="row">
                                    <div class="chart has-fixed-heigt" id="chart"></div>
                                </div>
                            </div>
                        </div>
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
<script src="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/bootstrap-select.js') }}"></script>
<script src="{{ asset('metronic/assets/js/pages/features/charts/apexcharts.js') }}"></script>
<script src="{{ asset('metronic/assets/js/pages/crud/datatables/search-options/advanced-search.js') }}"></script>

<script>
    $(document).ready(function(){
        $('.input-daterange').datepicker({
            todayBtn: 'linked',
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        fill_datatable();
        
        function fill_datatable(from_date='', to_date='')
        {
            var dataTable = $('#c19_ptk_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('c19_ptk.index') }}",
                    data: {from_date:from_date, to_date:to_date}
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                    },
                    {
                        data: 'di_rs',
                        name: 'di_rs'
                    },
                    {
                        data: 'probable',
                        name: 'probable'
                    },
                    {
                        data: 'discarded',
                        name: 'discarded'
                    },
                    {
                        data: 'isolasi',
                        name: 'isolasi'
                    },
                    {
                        data: 'sembuh',
                        name: 'sembuh'
                    },
                    {
                        data: 'meninggal',
                        name: 'meninggal'
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
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();

            if(from_date != '' && to_date != '')
            {
                $('#c19_ptk_table').DataTable().destroy();
                fill_datatable(from_date, to_date);
            }
        });

        $('#reset').click(function(){
            $('#from_date').val('');
            $('#to_date').val('');
            $('#c19_ptk_table').DataTable().destroy();
            fill_datatable();
        });
    });

    $(document).on('click', '.detail', function(){
        var id = $(this).attr('id');
        $.ajax({
            url: "/admin/pontianak/covid19/"+id+"/detail",
            dataType: "json",
            success: function(data)
            {
                $('#show_di_rs').text(data.result.di_rs);
                $('#show_probable').text(data.result.probable);
                $('#show_discarded').text(data.result.discarded);
                $('#show_isolasi').text(data.result.isolasi);
                $('#show_sembuh').text(data.result.sembuh);
                $('#show_meninggal').text(data.result.meninggal);
                $('#show_tanggal').text(data.result.tgl);
                var options = {
                    series: [{
                    data: [data.result.di_rs, data.result.probable, data.result.discarded, data.result.isolasi, data.result.sembuh, data.result.meninggal]
                    }],
                    chart: {
                        height: 400,
                        type: 'bar',
                        toolbar: {
                            show: true,
                            tools: {
                                download: false
                            }
                        }
                    },
                    plotOptions: {
                    bar: {
                        columnWidth: '45%',
                        distributed: true,
                    }
                    },
                    dataLabels: {
                    enabled: false
                    },
                    legend: {
                    show: false
                    },
                    xaxis: {
                        categories: ['Di RS', 'Probable', 'Discarded', 'Isolasi', 'Sembuh', 'Meninggal'],
                    labels: {
                        style: {
                        fontSize: '12px'
                        }
                    }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
                $('#detail').modal('show');
            }
        });
    });

    $('#create').click(function(){
        $('#c19_ptk_form')[0].reset();
        $('#tgl').attr('disabled', false);
        $('.modal-title').text('Add Data');
        $('#aksi_button').val('Save');
        $('#aksi_button').text('Save');
        $('#aksi').val('Save');
        $('#form_result').html('');
    });

    $('#c19_ptk_form').on('submit', function(e){
        e.preventDefault();
        if($('#aksi').val() == 'Save')
        {
            $.ajax({
                url: "{{ route('c19_ptk.store') }}",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function(){
                    $('#aksi_button').text('Menyimpan...');
                },
                success: function(data)
                {
                    var html = '';
                    if(data.errors)
                    {
                        html = '<div class="alert alert-danger">'+data.errors+'</div>';
                        $('#c19_ptk_form')[0].reset();
                        $('#aksi_button').text('Save');
                        $('#c19_ptk_table').DataTable().ajax.reload();
                    }
                    if(data.success)
                    {
                        html = '<div class="alert alert-success">'+data.success+'</div>';
                        $('#c19_ptk_form')[0].reset();
                        $('#aksi_button').text('Save');
                        $('#c19_ptk_table').DataTable().ajax.reload();
                    }
                    $('#form_result').html(html);
                }
            });
        }
        if($('#aksi').val() == 'Edit')
        {
            $.ajax({
                url: "{{ route('c19_ptk.update') }}",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function(){
                    $('#aksi_button').text("Mengubah...");
                },
                success: function(data)
                {
                    var html = '';
                    if (data.errors)
                    {
                        html = '<div class="alert alert-danger">'+data.errors+'</div>';
                        $('#aksi_button').text('Save');
                    }
                    if (data.success)
                    {
                        $('#c19_ptk_form')[0].reset();
                        $('#aksi_button').text('Save');
                        $('#c19_ptk_table').DataTable().ajax.reload();
                        $('#modalC19_Ptk').modal('hide');
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
        $.ajax({
            url: "/admin/pontianak/covid19/"+id+"/edit",
            dataType: "json",
            success: function(data)
            {
                $('#di_rs').val(data.result.di_rs);
                $('#probable').val(data.result.probable);
                $('#discarded').val(data.result.discarded);
                $('#isolasi').val(data.result.isolasi);
                $('#sembuh').val(data.result.sembuh);
                $('#meninggal').val(data.result.meninggal);
                $('#tgl').attr('disabled', true);
                $('#tgl').val(data.result.tgl);
                $('#hidden_id').val(id);
                $('.modal-title').text('Edit Data');
                $('#aksi_button').val('Edit');
                $('#aksi').val('Edit');
                $('#modalC19_Ptk').modal('show');
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
            url: "{{ url('admin/pontianak/covid19/destroy/') }}"+'/'+user_id,
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
                $('#c19_ptk_table').DataTable().ajax.reload();
            }
        });
    });
</script>
@endsection