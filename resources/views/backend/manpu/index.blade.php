@extends('backend.layouts.app')
@section('title', 'Admin | Manajemen Pengguna')
@section('subheader', 'Manajemen Pengguna')

@section('css')
    <link rel="stylesheet" href="{{asset('css/croppie.min.css')}}">
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
                    <button class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#manpu_modal" title="Add Data" name="create" id="create" onclick="insertManpu()">
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
                <table class="table table-bordered table-hover table-checkable" id="manpu_table">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Role</th>
                            <th>Nama</th>
                            <th>Username(Login)</th>
                            <th>Email</th>
                            <th>Avatar</th>
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

<div class="modal fade" id="manpu_modal" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLabel">Add Data</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <i class="ki ki-close" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="manpu_form" method="POST" enctype="multipart/form-data">
                    <span id="form_result"></span>
                    @csrf
                    <input type="hidden" name="id">
                    <div class="form-group row">
                        <label for="role" class="control-label col-md-4 align-self-center">Role</label>
                        <div class="col-md-8">
                            <select name="role" id="role" class="form-control selectpicker" title="--- Pilih Role ---" required>
                                <option value="superadmin">Superadmin</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="control-label col-md-4 align-self-center">Masukan Nama Lengkap</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="name" name="name" autocomplete="off" placeholder="Masukan nama disini..." required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="username" class="control-label col-md-4 align-self-center">Username</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="username" name="username" autocomplete="off" placeholder="Masukan username disini..." required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="control-label col-md-4 align-self-center">Email Address</label>
                        <div class="col-md-8">
                            <input type="email" class="form-control" id="email" name="email" autocomplete="off" placeholder="Masukan email disini..." required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="control-label col-md-4 align-self-center">Password</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" id="password" name="password" autocomplete="off" placeholder="Masukan password disini..." required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_confirm" class="control-label col-md-4 align-self-center">Confirm Password</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" autocomplete="off" placeholder="Password harus sama..." required>
                        </div>
                    </div>
                    <div class="form-group row" id="previewGambar">
                        <label for="preview_gambar" class="control-label col-md-4 align-self-center">Preview Gambar</label>
                        <div class="col-md-8">
                            <img src="" alt="gambar" id="preview_gambar" width="300">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="avatar" class="control-label col-md-4 align-self-center">Avatar</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control" id="avatar" name="avatar">
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
<div class="modal" tabindex="-1" role="dialog" id="uploadimageModal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document" style="min-width: 700px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div id="image_demo"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary crop_image">Crop and Save</button>
            </div>
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
                    <label for="detail_role" class="control-label col-md-4 align-self-center">Role</label>
                    <div class="col-md-8">
                        <span id="detail_role"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="detail_name" class="control-label col-md-4 align-self-center">Nama</label>
                    <div class="col-md-8">
                        <span id="detail_name"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="detail_username" class="control-label col-md-4 align-self-center">Username</label>
                    <div class="col-md-8">
                        <span id="detail_username"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="detail_email" class="control-label col-md-4 align-self-center">Email</label>
                    <div class="col-md-8">
                        <span id="detail_email"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="detail_avatar" class="control-label col-md-4 align-self-center">Avatar</label>
                    <div class="col-md-8">
                        <img src="" id="detail_avatar" width="100px">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="manpu_edit" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLabel">Edit Password</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <i class="ki ki-close" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="edit_manpu_form" method="POST">
                    @csrf
                    <span id="edit_form_result"></span>
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-custom alert-light-danger fade show mb-10" role="alert">
                        <div class="alert-icon">
                            <span class="svg-icon svg-icon-3x svg-icon-danger">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Info-circle.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
                                        <rect fill="#000000" x="11" y="10" width="2" height="7" rx="1" />
                                        <rect fill="#000000" x="11" y="7" width="2" height="2" rx="1" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <div class="alert-text font-weight-bold">{{$error}}</div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">
                                    <i class="ki ki-close"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                    @endforeach                   
                    <div class="form-group row">
                        <label for="current_password" class="control-label col-md-4 align-self-center">Current Password</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Current password" autocomplete="current-password" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="new_password" class="control-label col-md-4 align-self-center">New Password</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" id="new_password" name="new_password" autocomplete="current-password" placeholder="New Password" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="new_confirm_password" class="control-label col-md-4 align-self-center">New Confirm Password</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" id="new_confirm_password" name="new_confirm_password" autocomplete="current-password" placeholder="New Confirm Password" required>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="edit_aksi" id="edit_aksi" value="Edit">
                <input type="hidden" name="edit_hidden_id" id="edit_hidden_id">
                <button type="submit" class="btn btn-primary font-weight-bold">Save Changes</button>
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
<script src="{{ asset('js/croppie.js') }}"></script>
<script>
    $(document).ready(function(){
        var dataTables = $('#manpu_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('manpu.index') }}",
            },
            columns: [
                {
                    data: 'DT_RowIndex'
                },
                {
                    data: 'role'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'avatar',
                    name: 'avatar'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false
                }
            ]
        });
    });

    function insertManpu(){
        $('#manpu_form')[0].reset();
        $('.modal-title').text('Add Data');
        $('#aksi_button').val('Save');
        $('#aksi').val('Save');
        $("#previewGambar").hide();
        $('#form_result').html('');
    }

    var image_crop = $('#image_demo').croppie({
        viewport: {
            width: 300,
            height: 300,
            type:'circle'
            //circle dan square
        },
        boundary:{
            width: 650,
            height: 300
        }
    });
    $('#avatar').on('change', function(){
        var reader = new FileReader();
        reader.onload = function (event) {
            image_crop.croppie('bind', {
                url: event.target.result,
            });
        }
        reader.readAsDataURL(this.files[0]);
        $('#uploadimageModal').modal('show');
    });

    $('.close').click(function(){
        $('#avatar').val('');
    });

    $('.crop_image').on('click', function (ev) {
        image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (img) {
            $.ajax({
            url:"{{ route('manpu.sesi') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "avatar":img
            },
            success: function(){
                $('#uploadimageModal').modal('hide');
            }
            });
        });
    });

    $('#manpu_form').on('submit', function(e){
        e.preventDefault();
        if($('#aksi').val() == 'Save')
        {
            $.ajax({
                url: "{{route('manpu.store')}}",
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
                        $('#manpu_form')[0].reset();
                        $('#aksi_button').text('Save');
                        $('#manpu_table').DataTable().ajax.reload();
                    }
                    if(data.success)
                    {
                        html = '<div class="alert alert-success">'+data.success+'</div>';
                        $('#manpu_form')[0].reset();
                        $('#aksi_button').text('Save');
                        $('#manpu_table').DataTable().ajax.reload();
                    }
                    $('#form_result').html(html);
                }
            });
        }
    });

    $(document).on('click', '.detail', function(){
        var id = $(this).attr('id');
        $.ajax({
            url: "/admin/manajemen_pengguna/"+id+"/detail",
            dataType: "json",
            success: function(data)
            {
                $('#detail_role').text(data.result.role);
                $('#detail_name').text(data.result.name);
                $('#detail_email').text(data.result.email);
                $('#detail_username').text(data.result.username);
                $('#detail_avatar').attr('src', window.location.origin+"/images/avatars/"+data.result.avatar);
                $('#detail').modal('show');
            }
        });
    });

    $(document).on('click', '.edit', function(){
        var id = $(this).attr('id');
        $('#edit_form_result').text('');
        $('#edit_hidden_id').val(id);
        $('#edit_aksi').val('Edit');
        $('#edit_aksi_button').val('Edit');
        $('#manpu_edit').modal('show');
    });

    $('#edit_manpu_form').on('submit', function(e){
        e.preventDefault();
        if($('#edit_aksi').val() == 'Edit')
        {
            $.ajax({
                url: "{{ route('manpu.update') }}",
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
                        $('#edit_aksi_button').text('Save');
                    }
                    if(data.success)
                    {
                        $('#table_rs').DataTable().ajax.reload();
                        $('#manpu_edit').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Password berhasil di ubah',
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
        $('modal-title').text('Konfirmasi');
        $('#confirmModal').modal('show');
        $('#ok_button').text('Ok');
    });

    $('#ok_button').click(function(){
        $.ajax({
            url: "{{ url('/admin/manajemen_pengguna') }}"+'/'+user_id,
            beforeSend: function(){
                $('#ok_button').text('Deleting....');
            },
            success: function(data)
            {
                if(data.errors)
                {
                    $('#confirmModal').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        title: ''+data.errors+'',
                        showConfirmButton: true
                    });
                }
                if(data.success)
                {
                    $('#manpu_table').DataTable().ajax.reload();
                    $('#confirmModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: ''+data.success+'',
                        showConfirmButton: true
                    });
                }
            }
        });
    });
</script>
@endsection