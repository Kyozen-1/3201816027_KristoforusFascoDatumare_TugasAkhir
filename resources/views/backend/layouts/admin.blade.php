@if (request()->routeIs('dashboard'))
<li class="menu-item menu-item-active" aria-haspopup="true">
@else
<li class="menu-item" aria-haspopup="true">
@endif
    <a href="{{route('dashboard')}}" class="menu-link">
        <span class="svg-icon menu-icon"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Home\Home.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect x="0" y="0" width="24" height="24"/>
                <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z" fill="#000000"/>
            </g>
        </svg><!--end::Svg Icon--></span>
        <span class="menu-text">Dashboard</span>
    </a>
</li>

@if (request()->routeIs('c19_kct.index'))
<li class="menu-item menu-item-active" aria-haspopup="true">
@else
<li class="menu-item" aria-haspopup="true">
@endif
    <a href="{{route('c19_kct.index')}}" class="menu-link">
        <span class="svg-icon menu-icon"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Files\File.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <polygon points="0 0 24 0 24 24 0 24"/>
                <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                <rect fill="#000000" x="6" y="11" width="9" height="2" rx="1"/>
                <rect fill="#000000" x="6" y="15" width="5" height="2" rx="1"/>
            </g>
        </svg><!--end::Svg Icon--></span>
        <span class="menu-text">Data Covid-19 Kecamatan</span>
    </a>
</li>

@if (request()->routeIs('color.index'))
<li class="menu-item menu-item-active" aria-haspopup="true">
@else
<li class="menu-item" aria-haspopup="true">
@endif
    <a href="{{route('color.index')}}" class="menu-link">
        <span class="svg-icon menu-icon"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Design\Color-profile.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect x="0" y="0" width="24" height="24"/>
                <path d="M12,10.9996338 C12.8356605,10.3719448 13.8743941,10 15,10 C17.7614237,10 20,12.2385763 20,15 C20,17.7614237 17.7614237,20 15,20 C13.8743941,20 12.8356605,19.6280552 12,19.0003662 C11.1643395,19.6280552 10.1256059,20 9,20 C6.23857625,20 4,17.7614237 4,15 C4,12.2385763 6.23857625,10 9,10 C10.1256059,10 11.1643395,10.3719448 12,10.9996338 Z M13.3336047,12.504354 C13.757474,13.2388026 14,14.0910788 14,15 C14,15.9088933 13.7574889,16.761145 13.3336438,17.4955783 C13.8188886,17.8206693 14.3938466,18 15,18 C16.6568542,18 18,16.6568542 18,15 C18,13.3431458 16.6568542,12 15,12 C14.3930587,12 13.8175971,12.18044 13.3336047,12.504354 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                <circle fill="#000000" cx="12" cy="9" r="5"/>
            </g>
        </svg><!--end::Svg Icon--></span>
        <span class="menu-text">Warna Zona</span>
    </a>
</li>

@if (request()->routeIs('c19_klh.index'))
<li class="menu-item menu-item-active" aria-haspopup="true">
@elseif (request()->routeIs('c19_klh.create'))
<li class="menu-item menu-item-active" aria-haspopup="true">
@elseif (request()->routeIs('c19_klh.sps'))
<li class="menu-item menu-item-active" aria-haspopup="true">
@else
<li class="menu-item" aria-haspopup="true">
@endif
    <a href="{{route('c19_klh.index')}}" class="menu-link">
        <span class="svg-icon menu-icon"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Files\File.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <polygon points="0 0 24 0 24 24 0 24"/>
                <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                <rect fill="#000000" x="6" y="11" width="9" height="2" rx="1"/>
                <rect fill="#000000" x="6" y="15" width="5" height="2" rx="1"/>
            </g>
        </svg><!--end::Svg Icon--></span>
        <span class="menu-text">Data Covid-19 Kelurahan</span>
    </a>
</li>

@if (request()->routeIs('c19_ptk.index'))
<li class="menu-item menu-item-active" aria-haspopup="true">
@else
<li class="menu-item" aria-haspopup="true">
@endif
    <a href="{{route('c19_ptk.index')}}" class="menu-link">
        <span class="svg-icon menu-icon"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Files\File.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <polygon points="0 0 24 0 24 24 0 24"/>
                <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                <rect fill="#000000" x="6" y="11" width="9" height="2" rx="1"/>
                <rect fill="#000000" x="6" y="15" width="5" height="2" rx="1"/>
            </g>
        </svg><!--end::Svg Icon--></span>
        <span class="menu-text">Data Covid-19 Pontianak</span>
    </a>
</li>

@if (request()->routeIs('rs_data.index'))
<li class="menu-item menu-item-active" aria-haspopup="true">
@elseif (request()->routeIs('rs_data.create'))
<li class="menu-item menu-item-active" aria-haspopup="true">
@elseif (request()->routeIs('rs_data.sps'))
<li class="menu-item menu-item-active" aria-haspopup="true">
@else
<li class="menu-item" aria-haspopup="true">
@endif
    <a href="{{route('rs_data.index')}}" class="menu-link">
        <span class="svg-icon menu-icon"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Files\File.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <polygon points="0 0 24 0 24 24 0 24"/>
                <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                <rect fill="#000000" x="6" y="11" width="9" height="2" rx="1"/>
                <rect fill="#000000" x="6" y="15" width="5" height="2" rx="1"/>
            </g>
        </svg><!--end::Svg Icon--></span>
        <span class="menu-text">Data Covid-19 Rumah Sakit</span>
    </a>
</li>