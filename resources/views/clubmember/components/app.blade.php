<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <title>Login Portal</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('clubmember_assets/img/fav.png') }}">

    <!-- CSS -->


    @stack('styles')
</head>

<body>

    {{-- PAGE CONTENT --}}
    @yield('content')
    <!-- JS -->


    @stack('scripts')

</body>
</html>