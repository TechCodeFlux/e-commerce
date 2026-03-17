@extends('clubmember.components.app')

@section('content')

<div class="container mt-4"> 
    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-4">Booking</h4>

            <form action="{{ route('clubmember.placeorder') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- Product Name --}}
                    <div class="col-md-8 mb-3">
                        <label>Product Name :</label><br>
                        <h4>{{ $product->name }}</h4>
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                    </div>

                    {{-- Description --}}
                    <div class="col-md-8 mb-3">
                        <label>Description:</label><br>
                       <h5> {{ $product->description }}</h5>
                       
                    </div>

                    {{-- Product Image --}}
                    <div class="col-md-4 mb-3 text-center">
                        <img src="{{ asset('storage/' . $product->image) }}"
                             id="productImage"
                             width="150"
                             height="150"
                             class="rounded">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="mb-2">Variant</label>

                        <div class="row">

                            @foreach($varients as $varient)

                                <div class="col-md-3 mb-3">

                                    <label class="card p-3" style="cursor:pointer">

                                    <input type="radio"
                                        name="varient_id"
                                        class="variantRadio"
                                        value="{{ $varient->id }}"
                                        data-stock="{{ $varient->stock }}"
                                        data-price="{{ $varient->price }}"
                                        data-image="{{ $varient->image ? asset('storage/' . $varient->image) : '' }}">

                                    Colour : {{ $varient->color }} <br>
                                    Size : {{ $varient->size }} <br>
                                    Stock : {{ $varient->stock }}

                                    </label>

                                </div>

                            @endforeach

                         </div>
                    </div>

                    {{-- Price --}}
                    <div class="col-md-4 mb-3">
                        <label>Price:</label>
                        <h3 id="priceDisplay">₹0</h3>
                        <input type="hidden" name="price" id="priceInput" >
                        
                    </div>

                    {{-- Quantity --}}
                    <div class="col-md-4 mb-3">
                        <label>Quantity:</label>

                        <div class="d-flex align-items-center gap-2">

                            <button type="button" class="btn fs-3" id="minusBtn">-</button>

                            <span id="quantityDisplay" class="fw-bold fs-2">1</span>

                            <button type="button" class="btn fs-3" id="plusBtn">+</button>

                        </div>
                       <input type="hidden" name="quantity" id="quantityInput" >
                    </div>
                    
                    @error('quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror


                    <h3>Your Details</h3>
                    {{-- Club Member Name --}}
                    <div class="col-md-4 mb-1">
                        <label >Name:</label><br>
                        <p class=" fs-5 fw-semibold ">{{ $clubmember->name }}</p>
                        <input type="hidden" name="clubmember_id" value="{{ $clubmember->id }}">
                    </div>
                    @error('clubmember_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    {{-- Phone --}}
                    <div class="col-md-4 mb-3">
                        <label>Phone:</label><br>
                        {{ $clubmember->contact }}
                        <input type="hidden" name="phone" >
                    </div>

                    {{-- Email --}}
                    <div class="col-md-4 mb-3">
                        <label>Email:</label><br>
                        {{ $clubmember->email }}
                        <input type="hidden" name="email" >
                    </div>

                    {{-- Address --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="fw-bold h4">Delivery Address</h3>
                        <button type='button' class="btn btn-link text-decoration-none fw-bold p-0 d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#addressModal">
                            <i data-lucide="plus" style="width: 16px;"></i> Add New
                        </button>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Address:</label><br>
                       @if(!empty($address) && count($address) > 0)
                                @foreach($address as $addr)
                                    <input type="radio" name="address_id" value="{{ $addr->id }}">
                                    <label>
                                        {{ $addr->address1 }},
                                        {{ $addr->country->name }},
                                        {{ $addr->state->name }},
                                        {{ $addr->city }},
                                        Pin no:- {{ $addr->zip_code }}
                                    </label><br>
                                @endforeach
                            @else
                                <p>No address found</p>
                            @endif
                        @error('address_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <input type="hidden" name="club_id" value="{{$product->club_id}}">

                    <div class="text-sm-end mt-3">
                        <button type="submit" class="btn btn-primary px-5">Submit</button>
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
            </form>

        </div>
    </div>
</div>

@endsection


@section('script')





<script>


document.addEventListener('DOMContentLoaded', function () {

    const variantRadios = document.querySelectorAll('.variantRadio');
    const priceDisplay = document.getElementById('priceDisplay');
    const priceInput = document.getElementById('priceInput');

    const quantityDisplay = document.getElementById('quantityDisplay');
    const quantityInput = document.getElementById('quantityInput');

    const plusBtn = document.getElementById('plusBtn');
    const minusBtn = document.getElementById('minusBtn');

    const productImage = document.getElementById('productImage');

    let variantPrice = 0;
    let quantity = 1;
    let stock = 0;

    function updateUI() {
        const total = variantPrice * quantity;

        priceDisplay.innerText = "₹" + total;
        priceInput.value = total;

        quantityDisplay.innerText = quantity;
        quantityInput.value = quantity;
    }

    // VARIANT CHANGE
    variantRadios.forEach(radio => {

        radio.addEventListener('change', function () {

            variantPrice = parseFloat(this.dataset.price) || 0;
            stock = parseInt(this.dataset.stock) || 0;

            const imageUrl = this.dataset.image;

            quantity = 1;

            updateUI();

            if (imageUrl) {
                productImage.src = imageUrl;
            }

        });

    });

    // PLUS BUTTON
    plusBtn.addEventListener('click', function () {

        if (!variantPrice) {
            // alert("Please select a variant first");
                Swal.fire({
                    icon: 'warning',
                    title: 'Variant Required',
                    text: 'Please select a variant first',
                    confirmButtonText: 'OK'
                });
            return;
        }

        if (quantity < stock) {
            quantity++;
            updateUI();
        }

    });

    // MINUS BUTTON
    minusBtn.addEventListener('click', function () {

        if (quantity > 1) {
            quantity--;
            updateUI();
        }

    });

});



// country and state


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


</script>
@endif
@endsection