<!DOCTYPE html>
<html lang="en">

<head>
    @include('frontend.layouts.head')
</head>

<body>
    @include('frontend.layouts.navbar')

    @yield('content')

    @include('frontend.layouts.footer')
    
    @include('frontend.layouts.js')
</body>

</html>