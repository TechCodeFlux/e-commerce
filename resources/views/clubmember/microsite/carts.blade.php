<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">

    <title>Cart</title>
    <link rel="icon" href="{{ Storage::url($club->image) }}">

    <link rel="stylesheet" href="{{url('assets/micro/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('assets/micro/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/micro/css/main.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .cart-img {
            width: 80px;
            height: 80px;
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

                <a class="navbar-brand logo_h" href="index.html">
						<img src="img/logo.png" alt="">
						<span class="ms-2 fw-bold">
							<!-- After -->
							<img src="{{ Storage::url($club->image) }}" alt="{{ $club->name }}" class="ms-2" 
							style="height:40px; width:auto; border-radius:50%;">
							{{ $microsite->name }}
						</span>
					</a>

                <div class="collapse navbar-collapse offset">
                    <ul class="nav navbar-nav menu_nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('microsite.home', $microsite->slug) }}">Home</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link active" href="#">Cart</a>     
                        </li>
                        <form action="{{ route('microsite.logout', $microsite->slug) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link" >
                                Logout
                            </button>
                        </form>
                    </ul>
                </div>

            </div>
        </nav>
    </div>
</header>

<!-- BREADCRUMB -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <h1>Shopping Cart</h1>
    </div>
</section>

<!-- CART -->
<section class="cart_area">
<div class="container">

@if($cartItems->count() > 0)

<div class="table-responsive">
<table class="table">

<thead>
<tr>
    <th>Product</th>
    <th>Variant</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Total</th>
    <th></th>
</tr>
</thead>

<tbody>

@php $grandTotal = 0; @endphp

@foreach($cartItems as $item)

@php
    $total = $item->price * $item->quantity;
    $grandTotal += $total;
@endphp

<tr>

<!-- PRODUCT -->
<td>
    <div class="media">
        <div class="d-flex align-items-center">
    <img src="{{ $item->image ? asset('storage/'.$item->image) : asset('img/product/p1.jpg') }}" 
         class="cart-img mr-3">

    <div class="media-body">
        <p class="mb-0">{{ $item->product_name }}</p>
    </div>
</div>
    </div>
</td>

<!-- VARIANT -->
<td>
    {{ $item->size ?? '-' }} -
    {{ $item->color ?? '' }}
</td>

<!-- PRICE -->
<td>₹{{ $item->price }}</td>

<!-- QUANTITY -->
<td>
    <div class="d-flex align-items-center">

        <!-- MINUS -->
        <button class="btn btn-outline-dark btn-sm qty-btn minus" data-id="{{ $item->id }}">
            <i class="fa fa-minus"></i>
        </button>

        <!-- INPUT -->
        <input type="number"
            value="{{ $item->quantity }}"
            class="form-control text-center mx-2 quantityInput"
            data-id="{{ $item->id }}"
            style="width:60px;">

        <!-- PLUS -->
        <button class="btn btn-outline-dark btn-sm qty-btn plus" data-id="{{ $item->id }}">
            <i class="fa fa-plus"></i>
        </button>

    </div>
</td>
<!-- TOTAL -->
<td>₹{{ $total }}</td>

<!-- REMOVE -->
<td>
    <button class="btn btn-danger btn-sm removeItem" data-id="{{ $item->id }}">
        <i class="fas fa-trash"></i>
    </button>
</td>

</tr>

@endforeach

<!-- GRAND TOTAL -->
<tr>
    <td colspan="3"></td>
    <td><strong>Total</strong></td>
    <td><strong>₹{{ $grandTotal }}</strong></td>
    <td></td>
</tr>

</tbody>

</table>
</div>

<!-- ACTION BUTTONS -->
<div class="checkout_btn_inner d-flex justify-content-between">
    <a class="gray_btn" href="{{ route('microsite.home', $microsite->slug) }}">Continue Shopping</a>
    <form action="{{ route('clubmember.microsite.preview', $microsite->slug) }}" method="POST">
    @csrf
    <button type="submit" class="primary-btn">
        Proceed to Checkout
    </button>
</form>
</div>

@else

<div class="text-center py-5">
    <i class="fa fa-shopping-cart fa-3x mb-3 text-muted"></i>
    <h4>Your cart is empty</h4>
    <a href="{{ route('microsite.home', $microsite->slug) }}" class="primary-btn mt-3">
        Continue Shopping
    </a>
</div>

@endif

</div>
</section>

<!-- SCRIPTS -->
<script src="{{url('assets/micro/js/vendor/jquery-2.2.4.min.js')}}"></script>
<script src="{{url('assets/micro/js/vendor/bootstrap.min.js')}}"></script>

<script>

// UPDATE QUANTITY
$('.quantityInput').change(function () {

    let id = $(this).data('id');
    let qty = $(this).val();

    $.post("{{ url('cart-update') }}", {
        _token: "{{ csrf_token() }}",
        id: id,
        quantity: qty,
        microsite_id: "{{ session('microsite_id') }}"
    }, function () {
        location.reload();
    });

});

// REMOVE ITEM
$('.removeItem').click(function () {

    let id = $(this).data('id');

    if (!confirm('Remove this item?')) return;

    $.post("{{ url('cart-remove') }}", {
        _token: "{{ csrf_token() }}",
        id: id
    }, function () {
        location.reload();
    });

});
$(document).ready(function () {

    $('.plus').click(function () {
        let input = $(this).closest('div').find('.quantityInput');
        let qty = parseInt(input.val()) || 1;

        qty++;
        input.val(qty).trigger('change');
    });

    $('.minus').click(function () {
        let input = $(this).closest('div').find('.quantityInput');
        let qty = parseInt(input.val()) || 1;

        qty = qty > 1 ? qty - 1 : 1;
        input.val(qty).trigger('change');
    });

});
</script>

</body>
</html>