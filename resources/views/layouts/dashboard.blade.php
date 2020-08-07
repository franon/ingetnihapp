<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.dashboard.head')
    @yield('customcss')
</head>
<body>
    @if (!empty(session()->get('data')))
        @include('includes.dashboard.navbarLogged')
    @else
        @include("includes.dashboard.navbarGuest")
    @endif
    {{-- <div id="main"> --}}
        @yield('content')
    {{-- </div> --}}

<footer>
@include('includes.dashboard.footer')
@yield('customjs')
{{-- @include('includes.calendar') --}}
</footer>
</body>
</html>