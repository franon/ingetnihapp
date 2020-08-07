<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/sb/style.css')}}">

    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/fontawesome.css')}}">
    
    {{-- Bootstrap --}}
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/dist/css/bootstrap.min.css')}}">

    {{-- Jquery, JS, Bootsrap J --}}
    <script src="{{ asset('vendor/jquery/jquery-3.5.1.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <script src="{{ asset('vendor/bootstrap/js/dist/popper.js')}} "></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="{{asset('vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/7.17.1/firebase-app.js"></script>
    
    <link rel="manifest" href="manifest.json">
    
    <!-- TODO: Add SDKs for Firebase products that you want to use
        https://firebase.google.com/docs/web/setup#available-libraries -->
        
    <script src="https://www.gstatic.com/firebasejs/7.17.1/firebase-analytics.js"></script>
    
    <script src="https://www.gstatic.com/firebasejs/7.17.1/firebase-messaging.js"></script>

    <!-- Add Firebase products that you want to use -->
    <script src="https://www.gstatic.com/firebasejs/7.17.1/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.17.1/firebase-firestore.js"></script>