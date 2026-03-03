
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
            <li class="breadcrumb-item active"><i class="fas fa-credit-card small me-2"> </i> Booking</li>
        </ol>
    </nav>
</div>

<div class="container mt-4"> 
    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class=" mb-4">
                Booking
                {{-- {{ $clubuser->id ? 'Edit' : 'Add' }} Club User --}}
            </h4>

            <form action="{{route('clubmember.placeorder')}}" method="POST">
                {{-- action="{{ $clubuser->id ? route('admin.update', $clubuser->id) : route('admin.addclub') }}"
                method="POST">
                @csrf
                @if($clubuser->id) @method('PUT') @endif --}}
                @csrf   
                <div class="row">

                    <div class="col-md-4 mb-3"></div>

                    

                    {{-- Name --}}
                    <div class="col-md-8 mb-3">
                        <label> Product Name</label>
                        <!-- Display name (read-only or disabled if needed) -->
                        <input type="text"
                            class="form-control"
                            value="{{ $product->name }}"
                            readonly>

                        <!-- Actual value submitted -->
                        <input type="hidden"
                            name="product_id"
                            value="{{ $product->id }}">
                    </div>

                   
                    
                    <div class="col-md-4 mb-3 text-center">
                    <img src="{{ asset('storage/' . $product->image) }}"
                    id="productImage"
                        width="100" height="100"
                        class="rounded">
                    </div>
                    

                    
                    <div class="col-md-8 mb-3">
                        <label>description</label>
                        <textarea name="description" class="form-control" readonly>{{ old('description', $product->description ?? '') }}</textarea>
                    </div>


                    <div class="col-md-4 mb-3"></div>
                    
                    <div class="col-md-8 mb-3">
                        <label>Quantity</label>
                        <input type="number" 
                            name="quantity" 
                            id="quantityInput"
                            class="form-control"
                            value="{{ old('quantity', $quantity ?? 1) }}" 
                            min="1">
                    </div>

                    <div class=' mb-3'> 
                        <h4> Your Details</h4>
                    </div>

                     <div class="col-md-4 mb-3">
                        <label>Name</label>

                        <!-- Display name (read-only or disabled if needed) -->
                        <input type="text"
                            class="form-control"
                            value="{{ $clubmember->name }}"
                            readonly>

                        <!-- Actual value submitted -->
                        <input type="hidden"
                            name="clubmember_id"
                            value="{{ $clubmember->id }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label> Phone</label>
                        <input type="number" name="phone" class="form-control" 
                                 value="{{ old('phone', $clubmember->contact ?? '') }}"> 
                    </div>

                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="col-md-4 mb-3">
                        <label> Email</label>
                        <input type="email" name="email" class="form-control" 
                                 value="{{ old('email', $clubmember->email ?? '') }}"> 
                    </div>

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="col-md-8 mb-3">
                        <label>Address</label>
                        <select name="selected_address"id="address" class="form-select">
                             <option value="">select you address</option>
                            @foreach($address as $address)
                                <option value="{{ $address->address1 }}">
                                    {{ $address->address1 }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                     
                    {{-- Address --}}
                    <div class="col-md-8 mb-3">
                        <label>Address to add as new</label>
                         
                         <textarea name="new_address" class="form-control">{{ old('new_address') }}</textarea> 
                    </div>

                    @error('new_address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="col-md-4 mb-3">
                        {{-- <label> club_id</label> --}}
                        <input type="hidden"
                            name="club_id"
                            value="{{ $clubmember->club_id }}">
                    </div>
                    

                        <div class="col-md-8 mb-3">
                            <label>Variant</label>
<select name="varient_id" id="variantSelect" class="form-select" required>
    <option value="">Select your variant</option>
    @foreach($varients as $varient)
        <option value="{{ $varient->id }}" 
                data-stock="{{ $varient->stock }}"
                data-image="{{ asset('storage/' . $varient->image) }}">
            Colour: {{ $varient->color }} - Size: {{ $varient->size }} - Available Stock: {{ $varient->stock }}
        </option>
    @endforeach
</select>
                        </div>
                    


                            </div>
                            <div class="text-center mt-9">
                                <button class="btn btn-primary px-5">submit
                        
                                </button>
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif

                </div>



            </form>
        </div>
    </div>
</div>

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const statusSwitch = document.getElementById('statusSwitch');
    const statusLabel = document.getElementById('statusLabel');

});


document.addEventListener('DOMContentLoaded', function () {

    const countrySelect = document.getElementById('country');
    const stateSelect   = document.getElementById('state');
    const selectedState = "{{ old('state', $clubuser->state_id ?? '') }}";

    function loadStates(countryId) {
        stateSelect.innerHTML = '<option value="">Loading...</option>';

       fetch(`/admin/get-states/${countryId}`)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network error');
        }
        return response.json();
    })
    .then(states => {
        stateSelect.innerHTML = '<option value="">Select State</option>';
        states.forEach(state => {
            stateSelect.innerHTML +=
                `<option value="${state.id}">${state.name}</option>`;
        });
    })
    .catch(error => {
        console.error(error);
        stateSelect.innerHTML = '<option value="">Failed to load states</option>';
    });

    }

    countrySelect.addEventListener('change', function () {
        if (this.value) {
            loadStates(this.value);
        } else {
            stateSelect.innerHTML = '<option value="">Select State</option>';
        }
    });

    // AUTO LOAD STATES ON EDIT
    if (countrySelect.value) {
        loadStates(countrySelect.value);
    }
    document.getElementById('variantSelect').addEventListener('change', function() {
    let selectedOption = this.options[this.selectedIndex];
    let stock = selectedOption.getAttribute('data-stock');
    let quantityInput = document.getElementById('quantityInput');

    if (stock) {
        quantityInput.setAttribute('max', stock);
        quantityInput.value = 1; // reset quantity
    }
    });

});

</script>
@endsection
@endsection


<!-- working on it not work -->