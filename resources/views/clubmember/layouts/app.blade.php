<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <title>Club Member Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('clubmember_assets/img/fav.png') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('clubmember_assets/css/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('clubmember_assets/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('clubmember_assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('clubmember_assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('clubmember_assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('clubmember_assets/css/nouislider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('clubmember_assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('clubmember_assets/css/main.css') }}">

    @stack('styles')
</head>

<body>

    {{-- PAGE CONTENT --}}
    @yield('content')



    <!-- JS -->
    <script src="{{ asset('clubmember_assets/js/vendor/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('clubmember_assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('clubmember_assets/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('clubmember_assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('clubmember_assets/js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('clubmember_assets/js/nouislider.min.js') }}"></script>
    <script src="{{ asset('clubmember_assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('clubmember_assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('clubmember_assets/js/gmaps.min.js') }}"></script>
    <script src="{{ asset('clubmember_assets/js/main.js') }}"></script>

    @stack('scripts')

</body>
</html>
