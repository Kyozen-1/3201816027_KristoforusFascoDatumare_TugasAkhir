<footer class="footer-basic">
    <div class="social">
        <h2>Pontianak Covid-19</h2>
    </div>
    <ul class="list-inline">
        <li class="list-inline-item"><a href="{{route('home')}}">Home</a></li>
        <li class="list-inline-item"><a href="{{route('statistik')}}">Statistik</a></li>
        <li class="list-inline-item"><a href="{{route('table_data.index')}}">Tabel Data Covid-19</a></li>
        <li class="list-inline-item"><a href="{{route('rumah_sakit')}}">Rumah Sakit Rujukan</a></li>
        {{-- <li class="list-inline-item">
        @if (Route::has('login'))
            @auth
                <a class="btn btn-primary" role="button" href="{{route('dashboard')}}" style="color:white;">Admin Panel</a>
            @else
                <a class="btn btn-primary" role="button" href="{{route('login')}}" style="color:white;">Login</a>
            @endauth
        @endif
        </li> --}}
    </ul>
    <p class="copyright">Kyozen © 2021</p>
</footer>