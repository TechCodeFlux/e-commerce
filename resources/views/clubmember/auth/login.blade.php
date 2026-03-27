<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login Portal</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            margin: 0;
            background: linear-gradient(#424242, #212121);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
        }

        .container-content {
            background-color: rgba(58, 58, 58, 0.8);
            padding: 25px;
            border-top: 2px solid #FFEB3B;
            border-radius: 8px;
        }

        .form-control {
            background-color: #5f5f5f;
            border: 1px solid #424242;
            color: #fff;
        }

        .form-control:focus {
            border-color: #FFEB3B;
            background-color: #616161;
            color: #fff;
            box-shadow: none;
        }

        .form-control::placeholder {
            color: #BDBDBD;
        }

        .form-button {
            background-color: rgba(255, 235, 59, 0.3);
            border: none;
            color: #fff;
        }

        .form-button:hover {
            background-color: rgba(255, 235, 59, 0.6);
        }

        .logo-badge {
            font-size: 70px;
            color: #fff;
        }

        .text-darkyellow {
            color: rgba(255, 235, 59, 0.7);
            text-decoration: none;
        }

        .text-darkyellow:hover {
            color: #FFEB3B;
        }
    </style>
</head>

<body>

<div class="login-container text-center">
    
    <div class="mb-3">
        <i class="fa fa-user-circle logo-badge"></i>
    </div>

    <h3 class="text-white">Sign In Template</h3>
    <p class="text-white">Sign In</p>

    <div class="container-content">
        <form>
            <div class="mb-3">
                <input type="text" class="form-control" placeholder="Username" required>
            </div>

            <div class="mb-3">
                <input type="password" class="form-control" placeholder="Password" required>
            </div>

            <button type="submit" class="btn form-button w-100 mb-3">
                Sign In
            </button>

            <a href="#" class="text-darkyellow d-block mb-2">
                <small>Forgot your password?</small>
            </a>

            <p class="text-white mb-1">
                <small>Do not have an account?</small>
            </p>

            <a href="#" class="text-darkyellow">
                <small>Sign Up</small>
            </a>
        </form>

        <!-- <p class="mt-3 text-white">
            <small>Your Name &copy; 2026</small>
        </p> -->
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>