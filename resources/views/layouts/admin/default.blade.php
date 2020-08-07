{{-- <!DOCTYPE html> --}}
<html lang="en">
<head>
    <title>@yield('title')</title>
    @include('includes.admin.head')
    @yield('customcss')
</head>
<body>
    @include('includes.admin.loading')
    
    <div id="main-wrapper" data-theme="light" data-layout=vertical data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full" >
    
    @include('includes.admin.navbar')

    @include('includes.admin.sidebar')

    @yield('content')

    </div>


    
    @include('includes.admin.footer')
    
    @yield('customjs')
</body>
</html>