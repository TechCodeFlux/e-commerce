<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Your Bag | {{ $microsite->name }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #0d6efd;
            --glass-bg: rgba(255, 255, 255, 0.95);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            --bg-light: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: #2d3436;
        }

        /* --- Header --- */
        .header_area {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        /* --- Breadcrumb/Title --- */
        .page-header {
            padding: 60px 0;
            background: #fff;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            margin-bottom: 40px;
        }

        /* --- Cart Styling --- */
        .cart-card {
            background: #fff;
            border-radius: 20px;
            border: none;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .cart-item {
            padding: 25px;
            border-bottom: 1px solid #f1f1f1;
            transition: background 0.3s ease;
        }

        .cart-item:last-child { border-bottom: none; }

        .cart-item:hover { background-color: #fafafa; }

        .product-img {
            width: 100px;
            height: 120px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        /* --- Quantity Controls --- */
        .qty-container {
            background: #f1f3f5;
            padding: 5px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
        }

        .qty-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px !important;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: all 0.2s;
        }

        .qty-btn:hover { background: var(--primary-color); color: #fff; }

        .qty-input {
            width: 45px;
            border: none;
            background: transparent;
            text-align: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Remove Arrows from Number Input */
        .qty-input::-webkit-inner-spin-button, 
        .qty-input::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }

        /* --- Summary Box --- */
        .summary-card {
            background: #fff;
            border-radius: 20px;
            border: none;
            box-shadow: var(--card-shadow);
            position: sticky;
            top: 100px;
        }

        .btn-checkout {
            border-radius: 15px;
            padding: 15px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .remove-link {
            color: #ff4757;
            font-size: 0.8rem;
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.2s;
        }

        .remove-link:hover { opacity: 0.7; color: #ff4757; }
    </style>
</head>

<body>

    <header class="header_area sticky-top">
        <nav class="navbar navbar-expand-lg py-3">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('microsite.home', $microsite->slug) }}">
                    <img src="{{ Storage::url($club->image) }}" alt="{{ $club->name }}" 
                         style="height:40px; width:40px; border-radius:50%;" class="me-2">
                    <span class="fw-bold tracking-tight text-uppercase small">{{ $club->name }}</span>
                </a>
                <div class="ms-auto d-flex align-items-center">
                    <a href="{{ route('microsite.home', $microsite->slug) }}" class="nav-link fw-bold small text-muted me-3">Back to Store</a>
                    <form action="{{ route('microsite.logout', $microsite->slug) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-dark btn-sm px-3 rounded-pill fw-bold">Logout</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <section class="page-header">
        <div class="container text-center">
            <h1 class="fw-bold mb-0">Your Shopping Bag</h1>
            <p class="text-muted mt-2">Review your items before checking out</p>
        </div>
    </section>

    <section class="cart-area pb-5">
        <div class="container">
            @if($cartItems->count() > 0)
                <div class="row g-4">
                    
                    <div class="col-lg-8">
                        <div class="cart-card">
                            @php $grandTotal = 0; @endphp
                            @foreach($cartItems as $item)
                                @php
                                    $total = $item->price * $item->quantity;
                                    $grandTotal += $total;
                                @endphp
                                <div class="cart-item">
                                    <div class="row align-items-center">
                                        <div class="col-3 col-md-2">
                                            <img src="{{ $item->image ? asset('storage/'.$item->image) : asset('img/product/p1.jpg') }}" 
                                                 class="product-img shadow-sm" alt="Product">
                                        </div>
                                        
                                        <div class="col-9 col-md-4">
                                            <h6 class="fw-bold mb-1">{{ $item->product_name }}</h6>
                                            <p class="text-muted small mb-0">
                                                <span class="badge bg-light text-dark border fw-normal">{{ $item->size ?? 'Standard' }}</span>
                                                @if($item->color)
                                                    <span class="ms-1 small">{{ $item->color }}</span>
                                                @endif
                                            </p>
                                            <button class="remove-link btn btn-link p-0 mt-2 removeItem" data-id="{{ $item->id }}">
                                                <i class="fas fa-trash-alt me-1"></i> Remove
                                            </button>
                                        </div>

                                        <div class="col-6 col-md-3 mt-3 mt-md-0">
                                            <div class="qty-container">
                                                <button class="qty-btn minus" data-id="{{ $item->id }}"><i class="fa fa-minus"></i></button>
                                                <input type="number" value="{{ $item->quantity }}" class="qty-input quantityInput" data-id="{{ $item->id }}">
                                                <button class="qty-btn plus" data-id="{{ $item->id }}"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>

                                        <div class="col-6 col-md-3 mt-3 mt-md-0 text-end">
                                            <p class="fw-bold mb-0 text-dark" style="font-size: 1.1rem;">₹{{ number_format($total) }}</p>
                                            <small class="text-muted">₹{{ number_format($item->price) }} each</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="summary-card p-4">
                            <h5 class="fw-bold mb-4">Order Summary</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span class="fw-600">₹{{ number_format($grandTotal) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <span class="text-muted">Shipping</span>
                                <span class="text-success fw-600">Calculated at Checkout</span>
                            </div>
                            <hr class="opacity-10">
                            <div class="d-flex justify-content-between mb-4 mt-2">
                                <span class="h5 fw-bold">Total</span>
                                <span class="h5 fw-bold text-primary">₹{{ number_format($grandTotal) }}</span>
                            </div>

                            <form action="{{ route('clubmember.microsite.preview', $microsite->slug) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-checkout w-100 shadow">
                                    Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </form>
                            
                            <a href="{{ route('microsite.home', $microsite->slug) }}" class="btn btn-link w-100 text-muted small mt-2 fw-bold text-decoration-none">
                                <i class="fas fa-chevron-left me-1"></i> Continue Shopping
                            </a>
                        </div>
                    </div>

                </div>
            @else
                <div class="text-center py-5 cart-card p-5">
                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle" style="width:100px; height:100px;">
                            <i class="fa fa-shopping-bag fa-3x text-muted opacity-50"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold">Your bag is empty</h3>
                    <p class="text-muted">Looks like you haven't added anything yet.</p>
                    <a href="{{ route('microsite.home', $microsite->slug) }}" class="btn btn-primary btn-checkout px-5 mt-3 shadow">
                        Explore Store
                    </a>
                </div>
            @endif
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            
            // Reusable update function
            function updateCart(id, qty) {
                if(qty < 1) return;
                
                $.post("{{ url('cart-update') }}", {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    quantity: qty,
                    microsite_id: "{{ session('microsite_id') }}"
                }, function () {
                    location.reload();
                });
            }

            // Plus / Minus logic
            $('.plus').click(function () {
                let input = $(this).siblings('.quantityInput');
                let qty = parseInt(input.val()) + 1;
                updateCart($(this).data('id'), qty);
            });

            $('.minus').click(function () {
                let input = $(this).siblings('.quantityInput');
                let qty = parseInt(input.val()) - 1;
                if(qty >= 1) updateCart($(this).data('id'), qty);
            });

            // Manual Input Change
            $('.quantityInput').on('change', function () {
                updateCart($(this).data('id'), $(this).val());
            });

            // Remove Item
            $('.removeItem').click(function () {
                let id = $(this).data('id');
                if (!confirm('Are you sure you want to remove this item?')) return;

                $.post("{{ url('cart-remove') }}", {
                    _token: "{{ csrf_token() }}",
                    id: id
                }, function () {
                    location.reload();
                });
            });
        });
    </script>
</body>
</html>