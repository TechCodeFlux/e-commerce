<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Vetra | E-Commerce HTML Admin Dashboard Template</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url('assets/images/favicon.png') }}"/>

    <!-- Themify icons -->
    <link rel="stylesheet" href="{{ url('assets/images/favicon.png') }}" type="text/css">

    <!-- Main style file -->
    <link rel="stylesheet" href="{{ url('dist/css/app.min.css') }}" type="text/css">
</head>

<body class="auth">

<div class="preloader">
    <div class="preloader-icon"></div>
</div>

<div class="form-wrapper">
    <div class="container">
        <div class="card">
            <div class="row g-0">
                <div class="col">
                    <div class="row">
                        <div class="col-md-10 offset-md-1">

                            <div class="my-5 text-center text-lg-start">
                                <h1 class="display-8">Club Sign In</h1>
                                <p class="text-muted">Sign in to continue</p>
                            </div>

                            
                            <form action="{{ route('club.login.submit') }}" method="POST" class="mb-5">
                                @csrf

                                <div class="mb-3">
                                    <input type="email"
                                           name="email"
                                           class="form-control"
                                           placeholder="Enter email"
                                           required
                                           autofocus>
                                </div>

                                <div class="mb-3">
                                    <input type="password"
                                           name="password"
                                           class="form-control"
                                           placeholder="Enter password"
                                           required>
                                </div>

                                <div class="text-center text-lg-start">
                                    <button type="submit" class="btn btn-primary">
                                        Sign In
                                    </button>
                                </div>
                            </form>
                            

                        </div>
                    </div>
                </div>

                <div class="col d-none d-lg-flex border-start align-items-center justify-content-between flex-column text-center">
                    <div class="logo">
                        <img width="120" src="{{ url('assets/images/logo.svg') }}" alt="logo">
                    </div>
                    <div>
                        <h3 class="fw-bold">Welcome to Vetra!</h3>
                        <p class="lead my-5">Please sign in with your club account</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="{{ url('libs/bundle.js') }}"></script>
<script src="{{ url('dist/js/app.min.js') }}"></script>

</body>
</html>
