<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
    <!--begin::Menu Container-->
    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
        <!--begin::Menu Nav-->
        <?php
            $roles = DB::table('roles')
                        ->select('roles')
                        ->where('user_id', Auth::user()->id)
                        ->first();
        ?>
        <ul class="menu-nav">
            @if ($roles->roles == "superadmin")
                @include('backend.layouts.superadmin')
            @endif
            @if ($roles->roles == 'admin')
                @include('backend.layouts.admin')
            @endif
        </ul>
        <!--end::Menu Nav-->
    </div>
    <!--end::Menu Container-->
</div>