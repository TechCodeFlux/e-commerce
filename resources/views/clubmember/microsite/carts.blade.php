<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>

    <link rel="stylesheet" href="{{url('assets/micro/css/bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .cart-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
        }
    </style>
</head>

<body>

<div class="container mt-5">

    <h3 class="mb-4">Your Cart</h3>

    @if($cartItems->count() > 0)

    <div class="table-responsive">
        <table class="table table-bordered align-middle">

            <thead class="thead-dark">
                <tr>
                    <th>Product</th>
                    <th>Variant</th>
                    <th>Price</th>
                    <th width="120">Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
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
                        <div class="d-flex align-items-center">
                            <img src="{{ $item->image ? asset('storage/'.$item->image) : asset('img/product/p1.jpg') }}" class="cart-img mr-3">
                            <div>
                                <strong>{{ $item->product_name }}</strong>
                            </div>
                        </div>
                    </td>

                    <!-- VARIANT -->
                    <td>
                        {{ $item->size ?? '-' }} - {{ $item->color ?? '-' }}
                    </td>

                    <!-- PRICE -->
                    <td>₹{{ $item->price }}</td>

                    <!-- QUANTITY -->
                    <td>
                        <input type="number" value="{{ $item->quantity }}" min="1"
                            class="form-control quantityInput"
                            data-id="{{ $item->id }}">
                    </td>

                    <!-- TOTAL -->
                    <td>₹{{ $total }}</td>

                    <!-- REMOVE -->
                    <td>
                        <button class="btn btn-danger btn-sm removeItem" data-id="{{ $item->id }}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>

                @endforeach

            </tbody>

        </table>
    </div>

    <!-- GRAND TOTAL -->
    <div class="text-right">
        <h4>Grand Total: ₹{{ $grandTotal }}</h4>
    </div>

    @else

        <div class="text-center">
            <h5>Your cart is empty</h5>
        </div>

    @endif

</div>

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
        quantity: qty
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

</script>

</body>
</html>