@extends('clubmember.components.app')

@section('content')

<div class="container mt-4"> 
    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-4">Checkout</h4>

            <form action="{{ route('clubmember.placeorder') }}" method="POST">
                @csrf

                <div class="row">

                @foreach($cart as $index => $carts)
                <div class="product-block border rounded p-3 mb-4">

                    {{-- Product Info --}}
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="fw-bold">{{ $carts->name }}</h5>
                            <p class="text-muted">{{ $carts->varient->product->description }}</p>

                            <input type="hidden" name="product_id[]" value="{{ $carts->id }}">
                            <input type="hidden" name="varient_id[]" value="{{ $carts->varient_id }}">
                            <input type="hidden" name="cart_id[]" value="{{ $carts->id }}">
                        </div>

                        <div class="col-md-4 text-center">
                            <img src="{{ asset('storage/' . $carts->varient->image) }}"
                                 id="productImage{{ $index }}"
                                 width="120" height="120">
                        </div>
                    </div>

                    {{-- Variant Info --}}
                    @php
                        $varient = $varients[$carts->varient_id] ?? null;
                    @endphp

                    <div class="mt-2">
                        @if($varient)
                            <div>Color: {{ $varient->color }}</div>
                            <div>Size: {{ $varient->size }}</div>
                            <div>Stock: {{ $varient->stock }}</div>
                        @else
                            <div class="text-danger">Variant not available</div>
                        @endif
                    </div>

                    {{-- Hidden Base Price + Stock --}}
                    <input type="hidden" id="basePrice{{ $index }}" 
                        value="{{ $carts->price ?  $carts->price : $carts->varient->price }}">

                     <input type="hidden" id="stock{{ $index }}" 
                        value="{{ $varient->stock }}">

                    {{-- Price --}}
                    <div class="mt-3">
                        <label>Price:</label>
                        <h5 id="priceDisplay{{ $index }}">
                            ₹{{ ($carts->varient ? $carts->varient->price : $carts->price) * ($carts->quantity ?? 1) }}
                        </h5>

                        <input type="hidden" name="price[]" 
                            id="priceInput{{ $index }}" 
                            value="{{ ($carts->varient ? $carts->varient->price : $carts->price) * ($carts->quantity ?? 1) }}">
                    </div>

                    {{-- Quantity --}}
                    <div class="mt-2">
                        <label>Quantity:</label>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-danger minusBtn" data-index="{{ $index }}">-</button>

                            <span id="quantityDisplay{{ $index }}">
                                {{ $carts->quantity ?? 1 }}
                            </span>

                            <button type="button" class="btn btn-success plusBtn" data-index="{{ $index }}">+</button>
                        </div>

                        <input type="hidden" name="quantity[]" 
                            id="quantityInput{{ $index }}" 
                            value="{{ $carts->quantity ?? 1 }}">
                    </div>

                </div>
                @endforeach

                {{-- USER DETAILS --}}
                <h4 class="mt-4">Your Details</h4>

                <div><strong>Name:</strong> {{ $clubmember->name }}</div>
                <div><strong>Phone:</strong> {{ $clubmember->contact }}</div>
                <div><strong>Email:</strong> {{ $clubmember->email }}</div>

                <input type="hidden" name="clubmember_id" value="{{ $clubmember->id }}">
                <input type="hidden" name="club_id" value="{{ $clubmember->club_id }}">

                {{-- ADDRESS --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="fw-bold h4">Delivery Address</h3>
                
                 <button type='button' class="btn btn-link text-decoration-none fw-bold p-0 d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#addressModal">
                            <i data-lucide="plus" style="width: 16px;"></i> Add New
                 </button>
                </div>

                @foreach($address as $addr)
                    <div>
                        <input type="radio" name="address_id" value="{{ $addr->id }}">
                        {{ $addr->address1 }},
                        {{ $addr->country->name }},
                        {{ $addr->state->name }},
                        {{ $addr->city }},
                        {{ $addr->zip_code }}
                    </div>
                @endforeach

                {{-- SUBMIT --}}
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary px-5">
                        Place Order
                    </button>
                </div>

                </div>
            </form>

                        {{--modal address--}}
                        <div class="modal fade" id="addressModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 rounded-4">
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title fw-bold">Add Address</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form method="POST" action="{{route('clubmember.addaddress')}}"> 
                                        @csrf
                                    <div class="modal-body p-4">
                                        <div id="addressForm">
                                            <div class="mb-3">
                                                <label> new address</label>
                                                 <textarea name="new_address" class="form-control">{{ old('new_address') }}</textarea>
                                            </div>
                                            @error('new_address')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                            @enderror
                                            <div class="mb-3">
                                                <label>Country</label>
                                                    <select name="country" id="country" class="form-select">
                                                        <option value="">Select Country</option>
                                                        @foreach($countries as $country)
                                                            <option value="{{ $country->id }}"
                                                            {{ old( 'country' ) }}>
                                                                {{ $country->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('country')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            {{-- State --}}
                                            <div class="col-md-4 mb-3">
                                                <label>State</label>
                                                <select name="state" id="state" class="form-select">
                                                    <option value="">Select State</option>
                                                        @isset($states)
                                                        @foreach($states as $state)
                                                            <option value="{{ $state->id }}"
                                                        {{ old( 'state' ) }}>
                                                            {{ $state->name }}
                                                            </option>
                                                        @endforeach
                                                    @endisset
                                                    </select>
                                                    @error('state')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                            </div>

                                                <div class="row g-2 mb-4">
                                                
                                                    {{-- City --}}
                                                    <div class="col-md-4 mb-3">
                                                        <label>City</label>
                                                        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                                                            value="{{ old('city') }}">
                                                            @error('city')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    {{-- zip code--}}
                                                    <div class="col-md-4 mb-3">
                                                        <label>Zip code</label>
                                                        <input type="text" name="zip_code" class="form-control @error('zip_code') is-invalid @enderror"
                                                            value="{{ old('zip_code') }}">
                                                            @error('zip_code')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                     <input type="hidden" name="clubmember_id" value="{{ $clubmember->id }}">{{ $clubmember->name }}
                                            </div>
                                            <input type="submit" value="Save Address" class="btn btn-primary w-100 py-2 fw-bold rounded-3">
                                                
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>

        </div>
    </div>
</div>

@endsection

@section('script')

<script>
document.addEventListener('DOMContentLoaded', function () {

    // PLUS
    document.querySelectorAll('.plusBtn').forEach(btn => {
        btn.addEventListener('click', function () {

            let i = this.dataset.index;

            let qty = document.getElementById('quantityInput' + i);
            let displayQty = document.getElementById('quantityDisplay' + i);
            let priceDisplay = document.getElementById('priceDisplay' + i);
            let priceInput = document.getElementById('priceInput' + i);

            let basePrice = parseFloat(document.getElementById('basePrice' + i).value);
            let stock = parseInt(document.getElementById('stock' + i).value);

            let quantity = parseInt(qty.value);

            if (quantity < stock) {
                quantity++;

                let total = basePrice * quantity;

                qty.value = quantity;
                displayQty.innerText = quantity;

                priceDisplay.innerText = "₹" + total.toFixed(2);
                priceInput.value = total;
            } else {
                // alert("Stock limit reached");
                
                Swal.fire({
                    icon: 'warning',
                    title: 'Stop!',
                    text: "Quantity reached stock limit",
                    confirmButtonText: 'OK'
                });
            }
            
        });
    });

    // MINUS
    document.querySelectorAll('.minusBtn').forEach(btn => {
        btn.addEventListener('click', function () {

            let i = this.dataset.index;

            let qty = document.getElementById('quantityInput' + i);
            let displayQty = document.getElementById('quantityDisplay' + i);
            let priceDisplay = document.getElementById('priceDisplay' + i);
            let priceInput = document.getElementById('priceInput' + i);

            let basePrice = parseFloat(document.getElementById('basePrice' + i).value);

            let quantity = parseInt(qty.value);

            if (quantity > 1) {
                quantity--;

                let total = basePrice * quantity;

                qty.value = quantity;
                displayQty.innerText = quantity;

                priceDisplay.innerText = "₹" + total.toFixed(2);
                priceInput.value = total;
            }
        });
    });

});


document.addEventListener('DOMContentLoaded', function () {

    const countrySelect = document.getElementById('country');
    const stateSelect   = document.getElementById('state');

    // EDIT MODE VALUES
    const selectedCountry = "{{ old('country', $clubmember->country_id ?? '') }}";
    const selectedState   = "{{ old('state', $clubmember->state_id ?? '') }}";

    function loadStates(countryId, selectedStateId = null) {
        stateSelect.innerHTML = '<option value="">Loading...</option>';

        fetch(`/admin/get-states/${countryId}`)
            .then(response => response.json())
            .then(states => {
                stateSelect.innerHTML = '<option value="">Select State</option>';

                states.forEach(state => {
                    const selected = selectedStateId == state.id ? 'selected' : '';
                    stateSelect.innerHTML +=
                        `<option value="${state.id}" ${selected}>${state.name}</option>`;
                });
            })
            .catch(() => {
                stateSelect.innerHTML = '<option value="">Failed to load states</option>';
            });
    }

    // ON COUNTRY CHANGE
    countrySelect.addEventListener('change', function () {
        if (this.value) {
            loadStates(this.value);
        } else {
            stateSelect.innerHTML = '<option value="">Select State</option>';
        }
    });

    // ✅ AUTO LOAD ON EDIT
    if (selectedCountry) {
        countrySelect.value = selectedCountry;
        loadStates(selectedCountry, selectedState);
    }
});
</script>
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: "{{ session('success') }}",
        confirmButtonText: 'OK'
    });
});
@endif

</script>


@endsection