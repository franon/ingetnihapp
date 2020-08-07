<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
</head>
<body>  
    <div id="main">
        @yield('content')
    </div>

    <footer>
        @include('includes.footer')
    </footer>
    @yield('customjs')
</body>
</html>