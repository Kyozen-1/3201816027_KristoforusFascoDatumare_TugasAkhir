@extends('backend.layouts.app')
@section('title', 'Admin | Covid-19_Kelurahan')
@section('subheader', 'Covid-19 Kelurahan')

@section('css')
<style>
    #selectbox option{
        background: white;
        color: black;
    }
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
                    <a href="{{ route('c19_klh.export') }}" class="btn btn-success font-weight-bolder" style="margin-right: 3px;" title="Export Data">Export Data</a>
                    <button type="button" class="btn btn-warning font-weight-bolder" title="Import Data" data-toggle="modal" data-target="#import_modal">Import Data</button>
                </div>
                <div class="card-toolbar">
                    <select class="btn btn-primary font-weight-bolder form-control" id="selectbox" name="selectbox" onchange="javascript:location.href = this.value;">
                        <option value="#">Masukan Data</option>
                        <option value="{{route('c19_klh.sps')}}">Satu Per Satu</option>
                        <option value="{{route('c19_klh.create')}}">Semua</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <!--begin: Search Form-->
                <form class="mb-15">
                    <div class="row mb-8">
                        <div class="col-lg-4 mb-lg-0 mb-6">
                            <label>Nama Kelurahan:</label>
                            <select name="filter_klh" id="filter_klh" class="form-control datatable-input" data-col-index="2">
                                <option value="">Pilih Kelurahan</option>
                                @forelse ($kelurahans as $kelurahan)
                                <option value="{{$kelurahan->id}}">{{$kelurahan->nama}}</option>
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
                <table class="table table-bordered table-hover table-checkable" id="c19_klh_table">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Kelurahan</th>
                            <th>Positif</th>
                            <th>Positif Isolasi (Dirawat)</th>
                            <th>Meninggal</th>
                            <th>Suspek</th>
                            <th>Kontak Erat</th>
                            <th>Warna</th>
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
            <form action="{{ route('c19_klh.import') }}" method="POST" enctype="multipart/form-data">
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
                <form class="form-horizontal" id="edit_c19_klh_form" method="POST">
                    @csrf
                <div class="form-group row">
                    <label for="edit_kelurahan" class="control-label col-md-4">Nama Kelurahan:</label>
                    <div class="col-md-8">
                        <input type="hidden" name="edit_id_kelurahan" id="edit_id_kelurahan">
                        <input type="text" class="form-control" id="edit_kelurahan" name="edit_kelurahan" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_positif" class="control-label col-md-4">Positif:</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="edit_positif" name="edit_positif" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_positif_isolasi" class="control-label col-md-4">Positif (Isolasi):</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="edit_positif_isolasi" name="edit_positif_isolasi" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_meninggal" class="control-label col-md-4">Meninggal:</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="edit_meninggal" name="edit_meninggal" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_suspek" class="control-label col-md-4">Suspek:</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="edit_suspek" name="edit_suspek" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_kontak_erat" class="control-label col-md-4">Kontak Erat:</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="edit_kontak_erat" name="edit_kontak_erat" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_color" class="control-label col-md-4">Warna:</label>
                    <div class="col-md-8">
                        <select name="edit_color" id="edit_color" class="form-control selectpicker" title="Pilih warna..." required>                                 
                            @foreach ($colors as $color)
                                <option value="{{$color->color}}" style="color:{{$color->color}};">{{$color->nama}}</option>
                            @endforeach
                        </select>
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
                                <label for="namaKelurahan" class="control-label col-md-4">Nama Kelurahan:</label>
                                <div class="col-md-6">
                                    <p id="show_kelurahan"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="namaPositif" class="control-label col-md-4">Positif:</label>
                                <div class="col-md-6">
                                    <p id="show_positif"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="namaPositifIsolasi" class="control-label col-md-4">Positif Isolasi:</label>
                                <div class="col-md-6">
                                    <p id="show_positif_isolasi"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="namaMeninggal" class="control-label col-md-4">Meninggal:</label>
                                <div class="col-md-6">
                                    <p id="show_meninggal"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="namaSuspek" class="control-label col-md-4">Suspek:</label>
                                <div class="col-md-6">
                                    <p id="show_suspek"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="namaKontakErat" class="control-label col-md-4">Kontak Erat:</label>
                                <div class="col-md-6">
                                    <p id="show_kontak_erat"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="namaTanggal" class="control-label col-md-4">Tanggal Menambahkan:</label>
                                <div class="col-md-6">
                                    <p id="show_tanggal"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="showColor" class="control-label col-md-4">Warna</label>
                                <div class="col-md-6">
                                    <input type="color" class="form-control" id="showColor" disabled>
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
                <p class="text-danger text-center">(Jika anda menghapus, maka semua data pada tanggal <span class="text-danger" id="destroy_tgl"></span> akan terhapus)</p>
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
<script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/select2.js') }}"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/bootstrap-select.js') }}"></script>
<script src="{{ asset('metronic/assets/js/pages/features/charts/apexcharts.js') }}"></script>
<script src="{{ asset('metronic/assets/js/pages/crud/datatables/search-options/advanced-search.js') }}"></script>
<script>
    var myOptions = '@foreach($kelurahans as $kelurahan) <option value="{{$kelurahan->id}}">{{$kelurahan->nama}}</option> @endforeach';
    $(document).ready(function(){
        $('.input-daterange').datepicker({
            todayBtn:'linked',
            format:'yyyy-mm-dd',
            autoclose:true
        });
        fill_datatable();
        function fill_datatable(filter_klh ='', from_date='', to_date='')
        {
            var dataTable = $('#c19_klh_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('c19_klh.index') }}",
                    //, start:start, end:end
                    data: {filter_klh:filter_klh, from_date:from_date, to_date:to_date}
                },
                columns: [
                    {
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'kelurahan',
                        name: 'kelurahan'
                    },
                    {
                        data: 'positif',
                        name: 'positif'
                    },
                    {
                        data: 'positif_isolasi',
                        name: 'positif_isolasi'
                    },
                    {
                        data: 'meninggal',
                        name: 'meninggal'
                    },
                    {
                        data: 'suspek',
                        name: 'suspek'
                    },
                    {
                        data: 'kontak_erat',
                        name: 'kontak_erat'
                    },
                    {
                        data: 'color',
                        name: 'color'
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
            var filter_klh = $('#filter_klh').val();
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();

            if(filter_klh != '')
            {
                if(from_date != '' && to_date != '')
                {
                    $('#c19_klh_table').DataTable().destroy();
                    fill_datatable(filter_klh, from_date, to_date);
                } else {
                    $('#c19_klh_table').DataTable().destroy();
                    fill_datatable(filter_klh);
                }
            } else
            {
                $('#c19_klh_table').DataTable().destroy();
                fill_datatable("",from_date, to_date);
            }
        });

        $('#reset').click(function(){
            $("[name='filter_klh']").val('');
            $("[name='filter_klh']").trigger('change');
            $('#from_date').val('');
            $('#to_date').val('');
            $('#c19_klh_table').DataTable().destroy();
            fill_datatable();
        });
    });

    $('#selectbox').change(function(){
        if($(this).val() == "{{route('c19_klh.sps')}}")
        {
            window.onload = function(){
                location.href=document.getElementById("selectbox").value;
            } 
        }
        if($(this).val() == "{{route('c19_klh.create')}}")
        {
            window.onload = function(){
                location.href=document.getElementById("selectbox").value;
            }    
        }
    });

    $(document).on('click', '.detail', function(){
        var id = $(this).attr('id');
        $.ajax({
            url: "/admin/kelurahan/covid19/"+id+"/detail",
            dataType: "json",
            success: function(data)
            {
                $('#show_kelurahan').text(data.result.kelurahan);
                $('#show_positif').text(data.result.positif);
                $('#show_positif_isolasi').text(data.result.positif_isolasi);
                $('#show_meninggal').text(data.result.meninggal);
                $('#show_suspek').text(data.result.suspek);
                $('#show_kontak_erat').text(data.result.kontak_erat);
                $('#showColor').val(data.result.color);
                $('#show_tanggal').text(data.result.tgl);
                var options = {
                    series: [{
                    data: [data.result.positif, data.result.positif_isolasi, data.result.meninggal, data.result.suspek, data.result.kontak_erat]
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
                        categories: ['Positif', 'Positif (Isolasi)', 'Meninggal', 'Suspek', 'Kontak Erat'],
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

    $(document).on('click', '.edit', function(){
        var id = $(this).attr('id');
        $('edit_form_result').html('');
        $.ajax({
            url: "covid19/"+id+"/edit",
            dataType: "json",
            success: function(data)
            {
                $('#edit_id_kelurahan').val(data.result.id_kelurahan);
                $('#edit_kelurahan').val(data.result.nama_kelurahan);
                $('#edit_positif').val(data.result.positif);
                $('#edit_positif_isolasi').val(data.result.positif_isolasi);
                $('#edit_meninggal').val(data.result.meninggal);
                $('#edit_suspek').val(data.result.suspek);
                $('#edit_kontak_erat').val(data.result.kontak_erat);
                $("[name='edit_color']").val(data.result.color);
                $("[name='edit_color']").trigger('change')
                $('#edit_tgl').val(data.result.tgl);
                $('#edit_hidden_id').val(id);
                $('#edit_aksi').val('Edit');
                $('#edit_aksi_button').val('Edit');
                $('#edit').modal('show');
            }
        });
    });

    $('#edit_c19_klh_form').on('submit', function(e){
        e.preventDefault();
        if($('#edit_aksi').val() == 'Edit')
        {
            $.ajax({
                url: "{{ route('c19_klh.update') }}",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function(){
                    $('#edit_aksi_button').text('Mengubah...');
                },
                success: function(data)
                {
                    var html = '';
                    if (data.errors)
                    {
                        html = '<div class="alert alert-danger">'+data.errors+'</div>';
                        $('#edit_aksi_button').text('Save');
                    }
                    if(data.success)
                    {
                        $('#edit_c19_klh_form')[0].reset();
                        $('#edit_aksi_button').text('Save');
                        $('#c19_klh_table').DataTable().ajax.reload();
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
            url: "covid19/destroy/tgl/" + user_id,
            dataType: "json",
            success: function(data)
            {
                $('model-title').text('Konfirmasi');
                $('#destroy_tgl').text(data.result.tgl);
                $('#confirmModal').modal('show');
                $('#ok_button').text('Ok');
            }
        });
    });

    $('#ok_button').click(function(){
        $.ajax({
            url:"{{ url('/admin/kelurahan/covid19/destroy') }}"+'/'+user_id,
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
                $('#c19_klh_table').DataTable().ajax.reload();
            }
        });
    });
</script>
@endsection