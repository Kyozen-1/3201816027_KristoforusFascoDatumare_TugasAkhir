@extends('backend.layouts.app')
@section('title', 'Change Password')
@section('subheader', 'Change Password')

@section('content')
<div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="d-flex flex-row">
            <!--begin::Content-->
            <div class="flex-row-fluid ml-lg-8">
                <!--begin::Card-->
                <div class="card card-custom">
                    <!--begin::Header-->
                    <div class="card-header py-3">
                        <div class="card-title align-items-start flex-column">
                            <h3 class="card-label font-weight-bolder text-dark">Change Password</h3>
                            <span class="text-muted font-weight-bold font-size-sm mt-1">Change your account password</span>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Form-->
                    <form class="form" method="POST" action="{{ route('change-password') }}">
                        @csrf
                        <div class="card-body">
                            <!--begin::Alert-->
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
                                <div class="alert-text font-weight-bold">Change your password regularly. this allows for better data security!</div>
                                <div class="alert-close">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">
                                            <i class="ki ki-close"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>
        
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
                            <!--end::Alert-->
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label text-alert">Current Password</label>
                                <div class="col-lg-9 col-xl-6">
                                    <input type="password" name="current_password" class="form-control form-control-lg form-control-solid" value="" placeholder="Current password" autocomplete="current-password"/>
                                    {{-- <a href="#" class="text-sm font-weight-bold">Forgot password ?</a> --}}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label text-alert">New Password</label>
                                <div class="col-lg-9 col-xl-6">
                                    <input type="password" class="form-control form-control-lg form-control-solid" value="" placeholder="New password" name="new_password" autocomplete="current-password"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label text-alert">New Confirm Password</label>
                                <div class="col-lg-9 col-xl-6">
                                    <input type="password" class="form-control form-control-lg form-control-solid" value="" placeholder="New Confirm password" name="new_confirm_password" autocomplete="current-password"/>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer py-3">
                            <div class="card-toolbar text-right">
                                <button type="submit" class="btn btn-success mr-2">Save Changes</button>
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
            </div>
            <!--end::Content-->
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('metronic/assets/js/pages/custom/profile/profile.js') }}"></script>
@endsection