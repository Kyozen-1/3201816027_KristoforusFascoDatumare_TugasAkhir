@extends('backend.layouts.app')
@section('title', 'Admin | Kelurahan')
@section('subheader', 'Kelurahan')
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
                    <button class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#modalKelurahan" title="Add Data" name="create" id="create">
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
                <table class="table table-bordered table-hover table-checkable" id="table_kelurahan">
                    <thead>
                        <tr class="text-center">
                            <th width="10%">No</th>
                            <th width="35%%">Nama Kecamatan</th>
                            <th width="35%%">Nama Kelurahan</th>
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

<div class="modal fade" id="modalKelurahan" tabindex="-1" role="dialog" aria-labelledby="addData" aria-hidden="true">
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
                <form class="form-horizontal" id="kelurahan_form" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="kecamatan" class="control-label col-md-4">Pilih Kecamatan</label>
                        <div class="col-md-12">
                            <select name="kecamatan" id="select_kecamatan" class="form-control selectpicker" title="Pilih Kecamatan..." required>
                                @forelse ($kecamatan as $kct)
                                    <option value="{{$kct->id}}">{{$kct->nama}}</option>
                                @empty
                                    <option value="" disabled>Belum ada kecamatan</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama" class="control-label col-md-4">Nama Kelurahan</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="nama" id="nama" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="koordinat" class="control-label col-md-8">Koordinat Boundaries Kelurahan</label>
                        <div class="col-md-12">
                            <textarea name="koordinat" id="koordinat" rows="5" class="form-control"></textarea>
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
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailLabel">Detail Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="nama_kecamatan" class="control-label col-md-4">Nama Kecamatan:</label>
                    <p class="col-md-8" id="nama_kecamatan"></p>
                </div>
                <div class="form-group row">
                    <label for="nama_kelurahan" class="control-label col-md-4">Nama Kelurahan:</label>
                    <p class="col-md-8" id="nama_kelurahan"></p>
                </div>
                <div class="form-group row">
                    <label for="detail_kord" class="control-label col-md-4">Boudaries Kelurahan:</label>
                    <p class="col-md-8" id="detail_kord"></p>
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
                <p class="text-danger text-center">(Jika anda menghapus kelurahan ini, maka semua data akan terhapus!!!)</p>
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
<script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/bootstrap-select.js') }}"></script>
<script src="{{ asset('metronic/assets/js/pages/crud/datatables/search-options/advanced-search.js') }}"></script>
<script>
    $(document).ready(function(){
        var dataTable = $('#table_kelurahan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('kelurahan.index') }}",
            },
            columns: [
                {
                    data: 'DT_RowIndex'
                },
                {
                    data: 'kecamatan',
                    name: 'kecamatan'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'actions',
                    name: 'actions'
                }
            ]
        });
    });
    $(document).on('click', '.detail', function(){
        var id = $(this).attr('id');
        $.ajax({
            url:"/admin/kelurahan/"+id+"/detail",
            dataType: "json",
            success: function(data)
            {
                console.log(data.result);
                $('#nama_kecamatan').text(data.result.kecamatan);
                $('#nama_kelurahan').text(data.result.nama);
                $('#detail_kord').text(data.result.kord);
                $('#detail').modal('show');
            }
        });
    });
    $('#create').click(function(){
        $('#kelurahan_form')[0].reset();
        $("[name='kecamatan']").val('');
        $("[name='kecamatan']").trigger('change');
        $('.modal-title').text('Add Data');
        $('#aksi_button').val('Save');
        $('#aksi').val('Save');
        $('#form_result').html('');
    });
    $('#kelurahan_form').on('submit', function(e){
        e.preventDefault();
        if($('#aksi').val() == 'Save')
        {
            $.ajax({
                url: "{{ route('kelurahan.store') }}",
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
                        $('#kelurahan_form')[0].reset();
                        $("[name='kecamatan']").val('');
                        $("[name='kecamatan']").trigger('change');
                        $('#aksi_button').text('Save');
                        $('#table_kelurahan').DataTable().ajax.reload();
                    }
                    if(data.success)
                    {
                        html = '<div class="alert alert-success">'+data.success+'</div>';
                        $('#kelurahan_form')[0].reset();
                        $("[name='kecamatan']").val('');
                        $("[name='kecamatan']").trigger('change');
                        $('#aksi_button').text('Save');
                        $('#table_kelurahan').DataTable().ajax.reload();
                    }
                    $('#form_result').html(html);
                }
            });
        }
        if($('#aksi').val() == 'Edit')
        {
            $.ajax({
                url: "{{ route('kelurahan.update') }}",
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
                        $('#kelurahan_form')[0].reset();
                        $('#aksi_button').text('Save');
                        $('#table_kelurahan').DataTable().ajax.reload();
                        $('#modalKelurahan').modal('hide');
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
            url: "kelurahan/"+id+"/edit",
            dataType: "json",
            success: function(data)
            {
                $("[name='kecamatan'").val(data.result.id_kecamatan);
                $("[name='kecamatan']").trigger('change');
                $('#nama').val(data.result.nama);
                $('#koordinat').text(data.result.kord);
                $('#hidden_id').val(id);
                $('.modal-title').text('Edit Data');
                $('#aksi_button').val('Edit');
                $('#aksi').val('Edit');
                $('#modalKelurahan').modal('show');
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
            url:"{{ url('admin/kelurahan/destroy') }}"+'/'+user_id,
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
                $('#table_kelurahan').DataTable().ajax.reload();
            }
        });
    });
</script>
@endsection