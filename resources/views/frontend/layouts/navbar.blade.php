<nav class="navbar navbar-light navbar-expand-md">
    <div class="container-fluid"><a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('images/icons/Logo Home.png') }}" width="250px" height="50px"></a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    @if (request()->routeIs('home'))
                    <a class="nav-link active" href="{{route('home')}}">Home</a>
                    @else
                    <a class="nav-link" href="{{route('home')}}">Home</a>
                    @endif
                </li>
                <li class="nav-item dropdown" id="dropDown" onclick="makeShow()">
                    @if (request()->routeIs('statistik'))
                    <a class="dropdown-toggle nav-link active" aria-expanded="false" data-toggle="dropdown" id="dropdownNavbar" aria-haspopup="true" href="#">Data Covid-19</a>
                    @elseif (request()->routeIs('table_data.index'))
                    <a class="dropdown-toggle nav-link active" aria-expanded="false" data-toggle="dropdown" id="dropdownNavbar" aria-haspopup="true" href="#">Data Covid-19</a>
                    @else
                    <a class="dropdown-toggle nav-link" aria-expanded="false" data-toggle="dropdown" id="dropdownNavbar" aria-haspopup="true" href="#">Data Covid-19</a>
                    @endif
                    <div class="dropdown-menu" id="dropMenu" aria-labelledby="dropdownNavbar">
                        <a class="dropdown-item" href="{{route('statistik')}}">Statistik</a>
                        <a class="dropdown-item" href="{{route('table_data.index')}}">Tabel Data Covid-19</a>
                    </div>
                </li>
                <li class="nav-item">
                    @if (request()->routeIs('rumah_sakit'))
                    <a class="nav-link active" href="{{route('rumah_sakit')}}">Rumah Sakit Rujukan</a>
                    @else
                    <a class="nav-link" href="{{route('rumah_sakit')}}">Rumah Sakit Rujukan</a>
                    @endif
                </li>
            </ul>
            {{-- @if (Route::has('login'))
                @auth
                    <a class="btn btn-primary" role="button" href="{{route('dashboard')}}">Admin Panel</a>
                @else
                    <a class="btn btn-primary" role="button" href="{{route('login')}}">Login</a>
                @endauth
            @endif --}}
        </div>
    </div>
</nav>