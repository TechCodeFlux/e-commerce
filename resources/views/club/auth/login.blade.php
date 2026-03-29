<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Club Login</title>

    <link rel="stylesheet" href="{{ url('dist/css/app.min.css') }}">
</head>
<body class="auth">

<div class="form-wrapper">
    <div class="container">
        <div class="card p-4">

            <h2 class="mb-3">Club Login</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('club.login.submit') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <input type="email" name="email" class="form-control"
                           placeholder="Email" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <input type="password" name="password" class="form-control"
                           placeholder="Password" required>
                </div>

                <button class="btn btn-primary w-100">Login</button>
            </form>

        </div>
    </div>
</div>

</body>
</html>