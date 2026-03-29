<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Account</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f5f5;
        }

        .navbar {
            background: #212529;
        }

        .profile-card {
            border-radius: 10px;
        }

        .order-card {
            border-radius: 10px;
            transition: 0.3s;
        }

        .order-card:hover {
            transform: translateY(-5px);
        }

        .status {
            padding: 5px 12px;
            border-radius: 20px;
            color: white;
            font-size: 12px;
        }

        .pending { background: orange; }
        .delivered { background: green; }
        .cancelled { background: red; }

        footer {
            background: #212529;
            color: white;
            padding: 15px;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>

<body>

<!-- 🔹 NAVBAR -->
<nav class="navbar navbar-dark">
    <div class="container-fluid">
        <span class="navbar-brand"><i class="fa fa-store"></i> My Store</span>

        <form method="POST" action="{{ route('clubmember.logout') }}">
            @csrf
            <button class="btn btn-danger btn-sm">Logout</button>
        </form>
    </div>
</nav>

<div class="container mt-4">

    <!-- 🔹 PROFILE -->
    <div class="card profile-card shadow-sm mb-4">
        <div class="card-body">
            <h5><i class="fa fa-user"></i> My Profile</h5>
            <p><strong>Name:</strong> {{ $member->name }}</p>
            <p><strong>Email:</strong> {{ $member->email }}</p>
        </div>
    </div>

    <!-- 🔹 ORDERS -->
    <h5 class="mb-3"><i class="fa fa-box"></i> My Orders</h5>

    <div class="row">
        @foreach($orders as $order)
        <div class="col-md-4 mb-4">
            <div class="card order-card shadow-sm">
                <div class="card-body">

                    <h6>Order #{{ $order->id }}</h6>

                    <p><strong>Product ID:</strong> {{ $order->product_id }}</p>
                    <p><strong>Quantity:</strong> {{ $order->quantity }}</p>

                    <p>
                        <strong>Status:</strong>
                        @if($order->order_status_id == 1)
                            <span class="status pending">Pending</span>
                        @elseif($order->order_status_id == 2)
                            <span class="status delivered">Delivered</span>
                        @else
                            <span class="status cancelled">Cancelled</span>
                        @endif
                    </p>

                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>

<!-- 🔹 FOOTER -->
<footer>
    <p>© 2026 Microsite System | All Rights Reserved</p>
</footer>

</body>
</html>