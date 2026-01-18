<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Vetra | E-Commerce  </title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{url('assets/images/favicon.png')}}"/>

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="{{url('dist/icons/bootstrap-icons-1.4.0/bootstrap-icons.min.css')}}" type="text/css">
    <!-- Bootstrap Docs -->
    <link rel="stylesheet" href="{{url('dist/css/bootstrap-docs.css')}}" type="text/css">

        <!-- Slick -->
    <link rel="stylesheet" href="{{url('libs/slick/slick.css')}}" type="text/css">

    <!-- Main style file -->
    <link rel="stylesheet" href="{{ url('dist/css/app.min.css')}}" type="text/css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<!-- preloader -->
<div class="preloader">
    <img src="{{url('assets/images/logo.svg')}}" alt="logo">
    <div class="preloader-icon"></div>
</div>
<!-- ./ preloader -->

@include('admin.layouts.sidebar')
@include('admin.layouts.topbar')

<div class="content @yield('contentClassName')">
    @yield('content')
</div>

@include('admin.layouts.footer')
   
<!-- Bundle scripts -->
<script src="{{url('libs/bundle.js')}}"></script>

<!-- Apex chart -->
<script src="{{url('libs/charts/apex/apexcharts.min.js')}}"></script>

<!-- Slick -->
<script src="{{url('libs/slick/slick.min.js')}}"></script>

<!-- Examples -->
<script src="{{url('dist/js/examples/dashboard.js')}}"></script>

<!-- Main Javascript file -->
<script src="{{url('dist/js/app.min.js')}}"></script>

@yield('script')
</body>
</html>