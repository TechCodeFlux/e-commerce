<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Secure Checkout | {{ $microsite->name }}</title>
    
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

        .page-header {
            padding: 50px 0;
            background: #fff;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            margin-bottom: 40px;
        }

        /* --- Checkout Cards --- */
        .checkout-card {
            background: #fff;
            border-radius: 20px;
            border: none;
            box-shadow: var(--card-shadow);
            padding: 30px;
            margin-bottom: 25px;
        }

        .section-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--primary-color);
            margin-bottom: 20px;
            display: block;
        }

        /* --- Address Radio Styling --- */
        .address-option {
            border: 2px solid #f1f1f1;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            display: block;
        }

        .address-option:hover { border-color: #ddd; }

        .address-option.active {
            border-color: var(--primary-color);
            background-color: rgba(13, 110, 253, 0.02);
        }

        .address-option.active::after {
            content: "\f058";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            top: 20px;
            right: 20px;
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        /* --- Input Styling --- */
        .form-control-premium {
            background-color: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 12px 15px;
            font-weight: 500;
        }

        .form-control-premium:focus {
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
            border-color: var(--primary-color);
        }

        /* --- Order Summary --- */
        .summary-card {
            background: #fff;
            border-radius: 24px;
            padding: 30px;
            box-shadow: var(--card-shadow);
            position: sticky;
            top: 100px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .btn-place-order {
            border-radius: 15px;
            padding: 18px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.2);
        }

        /* --- Animations & Success Modal --- */
        @keyframes scaleUp {
            0% { transform: scale(0.5); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .success-icon-wrapper {
            display: inline-block;
            background: rgba(13, 110, 253, 0.05);
            padding: 25px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .modal-content { border-radius: 28px; border: none; }
    </style>
</head>

<body>

    <header class="header_area sticky-top">
        <nav class="navbar navbar-expand-lg py-3">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('microsite.home', $microsite->slug) }}">
                    <img src="{{ Storage::url($club->image) }}" alt="{{ $club->name }}" style="height:35px; border-radius:50%;" class="me-2">
                    <span class="fw-bold small text-uppercase tracking-wider">{{ $club->name }}</span>
                </a>
                <div class="ms-auto">
                    <a href="{{ route('clubmember.microsite.carts', $microsite->slug) }}" class="text-dark text-decoration-none small fw-bold">
                        <i class="fas fa-shopping-bag me-1"></i> Return to Bag
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <section class="page-header text-center">
        <div class="container">
            <h1 class="fw-bold h2 mb-2">Checkout</h1>
            <p class="text-muted small">Finalize your selection and secure your order</p>
        </div>
    </section>

    <section class="checkout-area pb-5">
        <div class="container">
            <form id="checkoutForm" action="{{ route('cart.checkout', $microsite->slug) }}" method="POST">
                @csrf
                <div class="row g-4">
                    
                    <div class="col-lg-8">
                        
                        <div class="checkout-card">
                            <span class="section-label">1. Billing Details</span>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="small fw-bold mb-2 text-muted">Full Name</label>
                                    <input type="text" class="form-control form-control-premium" value="{{ $user->name }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="small fw-bold mb-2 text-muted">Email Address</label>
                                    <input type="email" class="form-control form-control-premium" value="{{ $user->email }}" readonly>
                                </div>
                                <div class="col-12">
                                    <label class="small fw-bold mb-2 text-muted">Phone Number</label>
                                    <input type="text" class="form-control form-control-premium" value="{{ $user->contact ?? '' }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="checkout-card">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="section-label mb-0">2. Shipping Address</span>
                                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold" 
                                        data-bs-toggle="modal" data-bs-target="#addressModal">
                                    <i class="fas fa-plus me-1"></i> Add New
                                </button>
                            </div>

                            <div id="addressContainer">
                                @forelse($addresses as $address)
                                    <label class="address-option {{ $loop->first ? 'active' : '' }}">
                                        <input type="radio" name="address_id" value="{{ $address->id }}" 
                                               class="d-none" {{ $loop->first ? 'checked' : '' }} required>
                                        <div class="address-content">
                                            <p class="fw-bold mb-1 text-dark">Deliver to this Address</p>
                                            <p class="text-muted small mb-0">
                                                {{ $address->address1 }}, {{ $address->address2 ?? '' }}<br>
                                                {{ $address->city }}, {{ $address->zip_code }}
                                            </p>
                                        </div>
                                    </label>
                                @empty
                                    <div class="text-center py-5 bg-light rounded-4 border border-dashed">
                                        <i class="fas fa-map-marker-alt text-muted mb-2"></i>
                                        <p class="text-muted small mb-0">No shipping addresses saved yet.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="summary-card">
                            <h5 class="fw-bold mb-4">Order Summary</h5>
                            
                            <div class="order-items-list mb-4">
                                @php $grandTotal = 0; @endphp
                                @foreach($cartItems as $item)
                                    @php 
                                        $total = $item->price * $item->quantity;
                                        $grandTotal += $total;
                                    @endphp
                                    <div class="order-item">
                                        <span class="text-muted">{{ $item->product_name }} <small class="fw-bold text-dark">x{{ $item->quantity }}</small></span>
                                        <span class="fw-bold">₹{{ number_format($total) }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <hr class="opacity-10 mb-4">

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Subtotal</span>
                                <span class="fw-bold small">₹{{ number_format($grandTotal) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <span class="text-muted small">Shipping</span>
                                <span class="text-success fw-bold small">FREE</span>
                            </div>

                            <div class="d-flex justify-content-between mb-4 pt-2 border-top">
                                <span class="h5 fw-bold">Total Amount</span>
                                <span class="h5 fw-bold text-primary">₹{{ number_format($grandTotal) }}</span>
                            </div>

                            <button type="submit" class="btn btn-primary btn-place-order w-100 shadow" id="submitOrderBtn">
                                Confirm & Place Order
                            </button>

                            {{-- <div class="text-center mt-4">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" height="20" class="opacity-50 me-2">
                                <i class="fas fa-shield-alt text-muted me-1"></i> <span class="small text-muted">Secure Payment</span>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <div class="modal fade" id="addressModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('address.add', $microsite->slug) }}" method="POST">
                    @csrf
                    <div class="modal-header border-0 pb-0">
                        <h5 class="fw-bold">New Shipping Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="text" name="address_line1" class="form-control form-control-premium" placeholder="Street Address" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="address_line2" class="form-control form-control-premium" placeholder="Apartment, suite, etc. (optional)">
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <select name="country_id" id="countryDropdown" class="form-select form-control-premium" required>
                                    <option value="">Country</option>
                                    @foreach($country as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <select name="state_id" id="stateDropdown" class="form-select form-control-premium" required>
                                    <option value="">State</option>
                                    @foreach($state as $s)
                                        <option value="{{ $s->id }}" data-country="{{ $s->country_id }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-8">
                                <input type="text" name="city" class="form-control form-control-premium" placeholder="City" required>
                            </div>
                            <div class="col-4">
                                <input type="text" name="zip_code" class="form-control form-control-premium" placeholder="ZIP" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow-sm">Save Address</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="orderSuccessModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-5 shadow-lg">
                <div class="modal-body p-0">
                    <div class="success-icon-wrapper">
                        <i class="fas fa-check-circle text-primary" style="font-size: 70px; animation: scaleUp 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);"></i>
                    </div>
                    <h2 class="fw-bold mb-3">Order Placed!</h2>
                    <p class="text-muted px-3 mb-4">Your exclusive items are being prepared. We’ve sent a confirmation email to your inbox.</p>
                    {{-- <div class="bg-light p-3 rounded-4 mb-4 border">
                        <p class="small text-uppercase tracking-wider fw-bold text-muted mb-1">Estimated Delivery</p>
                        <p class="fw-bold text-dark mb-0">3 - 5 Business Days</p>
                    </div> --}}
                    <a href="{{ route('microsite.home', $microsite->slug) }}" class="btn btn-primary btn-lg w-100 rounded-pill py-3 fw-bold shadow">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Address Selection Highlight
            $(document).on('click', '.address-option', function() {
                $('.address-option').removeClass('active').find('input').prop('checked', false);
                $(this).addClass('active').find('input').prop('checked', true);
            });

            // AJAX Form Submission
            $('#checkoutForm').on('submit', function(e) {
                e.preventDefault();
                
                let $btn = $('#submitOrderBtn');
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> Finalizing...');

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        const successModal = new bootstrap.Modal(document.getElementById('orderSuccessModal'));
                        successModal.show();
                    },
                    error: function(xhr) {
                        $btn.prop('disabled', false).text('Confirm & Place Order');
                        alert('Something went wrong. Please check your address selection and try again.');
                        console.error(xhr.responseText);
                    }
                });
            });

            // Country -> State Filter logic
            $('#countryDropdown').on('change', function() {
                let countryId = $(this).val();
                $('#stateDropdown').val("").find('option').each(function() {
                    if (!$(this).val()) return;
                    $(this).data('country') == countryId ? $(this).show() : $(this).hide();
                });
            });
        });
    </script>
</body>
</html>