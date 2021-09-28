@extends('backend.layouts.app')
@section('title', 'Admin | Zona')
@section('subheader', 'Zona')
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
                </div>
                <div class="card-toolbar">
                    <!--begin::Button-->
                    <button class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#modalZona" title="Add Data" name="create" id="create">
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
                <table class="table table-bordered table-hover table-checkable" id="zona_table">
                    <thead>
                        <tr class="text-center">
                            <th width="10%">No</th>
                            <th>Nama Zona</th>
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
<div class="modal fade" id="modalZona" tabindex="-1" role="dialog" aria-labelledby="addData" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addData">Add Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form class="form-horizontal" id="zona_form" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama" class="control-label col-md-4">Nama Zona</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="nama" id="nama" autocomplete="off" required>
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
                    <label for="detail_nama" class="control-label col-md-4 align-self-center">Nama Zona</label>
                    <div class="col-md-8">
                        <span id="detail_nama"></span>
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
<script src="{{ asset('metronic/assets/js/pages/crud/datatables/search-options/advanced-search.js') }}"></script>
<script>
    $(document).ready(function(){
        var dataTables = $('#zona_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('zona.index') }}",
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
            url:"/admin/zona/"+id+"/detail",
            dataType: "json",
            success: function(data)
            {
                $('#detail_nama').text(data.result.nama);
                $('#detail').modal('show');
            }
        });
    });
    $('#create').click(function(){
        $('#zona_form')[0].reset();
        $('.modal-title').text('Add Data');
        $('#aksi_button').val('Save');
        $('#aksi').val('Save');
        $('#form_result').html('');
    });
    $('#zona_form').on('submit', function(e){
        e.preventDefault();
        if($('#aksi').val() == 'Save')
        {
            $.ajax({
                url: "{{ route('zona.store') }}",
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
                        $('#aksi_button').text('Save');
                    }
                    if(data.success)
                    {
                        html = '<div class="alert alert-success">'+data.success+'</div>';
                        $('#zona_form')[0].reset();
                        $('#aksi_button').text('Save');
                        $('#zona_table').DataTable().ajax.reload();
                    }
                    $('#form_result').html(html);
                }
            });
        }
        if($('#aksi').val() == 'Edit')
        {
            $.ajax({
                url: "{{ route('zona.update') }}",
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
                        $('#zona_form')[0].reset();
                        $('#aksi_button').text('Save');
                        $('#zona_table').DataTable().ajax.reload();
                        $('#modalZona').modal('hide');
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
            url: "zona/"+id+"/edit",
            dataType: "json",
            success: function(data)
            {
                $('#nama').val(data.result.nama);
                $('.modal-title').text('Edit Data');
                $('#hidden_id').val(id);
                $('#aksi_button').val('Edit');
                $('#aksi').val('Edit');
                $('#modalZona').modal('show');
            }
        });
    });

    var user_id;
    $(document).on('click', '.delete', function(){
        user_id = $(this).attr('id');
        $('model-title').text('Konfirmasi');
        $('#confirmModal').modal('show');
        $('#ok_button').text('Ok');
    });

    $('#ok_button').click(function(){
        $.ajax({
            url:"{{ url('admin/zona/destroy') }}"+'/'+user_id,
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
                $('#zona_table').DataTable().ajax.reload();
            }
        });
    });
</script>
@endsection