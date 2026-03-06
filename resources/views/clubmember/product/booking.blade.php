@extends('clubmember.components.app')

@section('content')

<div class="mb-4">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/clubmember') }}">
                    <i class="bi bi-globe2 small me-2"></i> Dashboard
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('clubmember.viewproduct') }}">
                    <i class="bi bi-people-fill small me-2"></i> Products
                </a>
            </li>
            <li class="breadcrumb-item active">
                <i class="fas fa-credit-card small me-2"></i> Booking
            </li>
        </ol>
    </nav>
</div>

<div class="container mt-4"> 
    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-4">Booking</h4>

            <form action="{{ route('clubmember.placeorder') }}" method="POST">
                @csrf
                <div class="row">

                    {{-- Product Name --}}
                    <div class=" align-content-around col-md-8 mb-3">
                        <label>Product Name</label>
                        <input type="text" class="form-control" value="{{ $product->name }}" readonly>
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                    </div>



                    {{-- Description --}}
                    <div class="col-md-8 mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" readonly>{{ old('description', $product->description ?? '') }}</textarea>
                    </div>
                    
                    {{-- Product Image --}}
                    <div class="col-md-4 mb-3 text-center">
                        <img src="{{ asset('storage/' . $product->image) }}"
                             id="productImage"
                             width="150"
                             height="150"
                             class="rounded">
                    </div>

                    {{-- Quantity --}}
                    <div class="col-md-8 mb-3">
                        <label>Quantity</label>
                        <input type="number" name="quantity" id="quantityInput" class="form-control" value="{{ old('quantity', $quantity ?? 1) }}" min="1">
                    </div>

                    <div class="mb-3"><h4>Your Details</h4></div>

                    {{-- Club Member Name --}}
                    <div class="col-md-4 mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" value="{{ $clubmember->name }}" readonly>
                        <input type="hidden" name="clubmember_id" value="{{ $clubmember->id }}">
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-4 mb-3">
                        <label>Phone</label>
                        <input type="number" name="phone" class="form-control" value="{{ old('phone', $clubmember->contact ?? '') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-md-4 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $clubmember->email ?? '') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div class="col-md-4 mb-3">
                        <label>Address</label>
                        <select name="address" id="address" class="form-select">
                            <option value="">Select your address</option>
                            @foreach($address as $addr)
                                <option value="{{ $addr->id }}">{{ $addr->address1 }}</option>
                            @endforeach
                        </select>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-8 mb-3">
                        <label>Address to add as new</label>
                        <textarea name="new_address" class="form-control">{{ old('new_address') }}</textarea>
                        @error('new_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Country --}}
                            <div class="col-md-4 mb-3">
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

                    <input type="hidden" name="club_id" value="{{ $clubmember->club_id }}">

                    {{-- Variant --}}
                    <div class="col-md-4 mb-3">
                        <label>Variant</label>
                        <select name="varient_id" id="variantSelect" class="form-select" required>
                            <option value="">Select your variant</option>
                            @foreach($varients as $varient)
                                <option value="{{ $varient->id }}"
                                        data-stock="{{ $varient->stock }}"
                                        data-image="{{ $varient->image ? asset('storage/' . $varient->image) : '' }}">
                                    Colour: {{ $varient->color }} - Size: {{ $varient->size }} - Stock: {{ $varient->stock }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="text-sm-end mt-3">
                        <button class="btn btn-primary px-5">Submit</button>
                    </div>

                    <!-- @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif -->

                </div>
            </form>

        </div>
    </div>
</div>

@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const variantSelect = document.getElementById('variantSelect');
    const productImage  = document.getElementById('productImage');
    const quantityInput = document.getElementById('quantityInput');

    variantSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];

        // // Update stock
        // const stock = selectedOption.getAttribute('data-stock');
        // if (stock) {
        //     quantityInput.setAttribute('max', stock);
        //     quantityInput.value = 1; // reset quantity
        // }

        // Update product image
        const imageUrl = selectedOption.getAttribute('data-image');
        if (imageUrl) {
            productImage.src = imageUrl;
        } else {
            productImage.src = "{{ asset('storage/' . $product->image) }}";
        }
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
@endsection