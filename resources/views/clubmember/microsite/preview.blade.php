<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">

    <title>Checkout - {{ $microsite->name }}</title>

    <link rel="icon" href="{{ Storage::url($club->image) }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{url('assets/micro/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('assets/micro/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/micro/css/main.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .cart-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }
    </style>
</head>

<body>

<!-- HEADER -->
<header class="header_area sticky-header">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light main_box">
            <div class="container">

                <a class="navbar-brand logo_h" href="{{ route('microsite.home', $microsite->slug) }}">
                    <img src="{{ Storage::url($club->image) }}" style="height:40px; border-radius:50%;">
                    {{ $microsite->name }}
                </a>

                <div class="collapse navbar-collapse offset">
                    <ul class="nav navbar-nav menu_nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('microsite.home', $microsite->slug) }}">Home</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link active">Checkout</a>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>
    </div>
</header>

<!-- BREADCRUMB -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <h1>Checkout</h1>
    </div>
</section>

<!-- CHECKOUT -->
<section class="checkout_area section_gap">
<div class="container">

@php
    // $user = auth()->user();
    // $addresses = $user->addresses ?? [];
    $grandTotal = 0;
@endphp

<form action="{{ route('cart.checkout', $microsite->slug) }}" method="POST">
@csrf

<div class="row">

<!-- LEFT SIDE -->
<div class="col-lg-8">

    <h3>BILLINGS DETAILS</h3>

    <!-- USER INFO -->
    <div class="mb-3">
        <label>Full Name</label>
        <input type="text" class="form-control" value="{{ $user->name }}" readonly>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" class="form-control" value="{{ $user->email }}" readonly>
    </div>

    <div class="mb-3">
        <label>Phone</label>
        <input type="text" class="form-control" name="phone" value="{{ $user->contact ?? '' }}" readonly>
    </div>

    <!-- ADDRESSES -->
    <h5 class="mt-4">Select Address</h5>

@forelse($addresses as $address)
    <div class="form-check mb-2">
        <input class="form-check-input"
            type="radio"
            name="address_id"
            value="{{ $address->id }}"
            {{ $loop->first ? 'checked' : '' }}
            required>

        <label class="form-check-label">
            {{ $address->address1 }},
            {{ $address->address2 ?? '' }},
            {{ $address->city }},
            {{ $address->zip_code }}
        </label>
    </div>
@empty
    <p>No saved address found</p>
@endforelse

    <!-- ADD ADDRESS -->
    <button type="button"
        class="btn btn-outline-dark mt-2"
        data-bs-toggle="modal"
        data-bs-target="#addressModal">
        + Add New Address
    </button>

</div>

<!-- RIGHT SIDE -->
<div class="col-lg-4">

<div class="order_box">

<h2>Your Order</h2>

<ul class="list">
    <li><a>Product <span>Total</span></a></li>

    @foreach($cartItems as $item)
        @php
            $total = $item->price * $item->quantity;
            $grandTotal += $total;
        @endphp

        <li>
            <a>
                {{ $item->product_name }} x {{ $item->quantity }}
                <span>₹{{ $total }}</span>
            </a>
        </li>
    @endforeach
</ul>

<ul class="list list_2">
    <li><a>Subtotal <span>₹{{ $grandTotal }}</span></a></li>
    <li><a>Shipping <span>₹0</span></a></li>
    <li><a>Total <span>₹{{ $grandTotal }}</span></a></li>
</ul>

<button type="submit" class="primary-btn w-100">
    Place Order
</button>

</div>

</div>

</div>
</form>

</div>
</section>

<!-- ADDRESS MODAL -->
<div class="modal fade" id="addressModal">
  <div class="modal-dialog">
    <form action="{{ route('address.add', $microsite->slug) }}" method="POST">
        @csrf

        <div class="modal-content">

            <div class="modal-header">
                <h5>Add New Address</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal"></button> --}}
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="text" name="address_line1" class="form-control mb-2" placeholder="Address Line 1" required>

                <input type="text" name="address_line2" class="form-control mb-2" placeholder="Address Line 2">

                <!-- COUNTRY DROPDOWN -->
                <select name="country_id" class="form-control mb-2" required>
                    <option value="">Select Country</option>
                    @foreach($country as $c)
                        <option value="{{ $c->id }}">
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>

                <!-- STATE DROPDOWN -->
               <select name="state_id" class="form-control mb-2" required>
                    <option value="">Select State</option>
                    @foreach($state as $s)
                        <option value="{{ $s->id }}">
                            {{ $s->name }}
                        </option>
                    @endforeach
                </select>       

                <input type="text" name="city" class="form-control mb-2" placeholder="City" required>

                <input type="text" name="zip_code" class="form-control mb-2" placeholder="ZIP Code" required>

            </div>

            <div class="modal-footer">
                <button class="btn btn-dark w-100">Save Address</button>
            </div>

        </div>

    </form>
  </div>
</div>

<!-- JS -->
<script src="{{ url('assets/micro/js/vendor/jquery-2.2.4.min.js') }}"></script>
<script src="{{ url('assets/micro/js/vendor/bootstrap.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
<script>
document.getElementById('countryDropdown').addEventListener('change', function () {

    let countryId = this.value;
    let states = document.querySelectorAll('#stateDropdown option');

    document.getElementById('stateDropdown').value = "";

    states.forEach(function (state) {

        if (!state.value) return; // skip "Select State"

        if (state.getAttribute('data-country') == countryId) {
            state.style.display = "block";
        } else {
            state.style.display = "none";
        }

    });

});
</script>
</html>