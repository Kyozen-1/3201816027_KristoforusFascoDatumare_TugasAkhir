<div class="topbar">
    <!--begin::User-->
    @if (Illuminate\Support\Facades\Auth::check())
    <div class="topbar-item">
        <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
            <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
            <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ucfirst(Auth::user()->username)}}</span>
            <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                <?php 
                    $kalimat = Auth::user()->username;
                    $huruf = preg_split('//', $kalimat, -1, PREG_SPLIT_NO_EMPTY);
                ?>
                <span class="symbol-label font-size-h5 font-weight-bold" style="text-transform: uppercase;"><?php print_r($huruf[0])?></span>
            </span>
        </div>
    </div>
    @endif
    <!--end::User-->
</div>