@extends('club.components.app')

@section('content')

 <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">
                        <i class="bi bi-globe2 small me-2"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('club.varient_management.show_varient') }}">
                        <i class="bi bi-building small me-2"></i> Varient 
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-people-fill small me-2"></i>{{$varient->id ? 'Edit varient':'Add varient' }}</li>
            </ol>
        </nav>
    </div>

<div class="container mt-4">

    <div class="card mb-4 shadow-sm">
        <div class="card-body">

            <h6 class="card-title mb-4 text-center">
                {{$varient->id ? 'Edit' : 'Add' }} varient Form
            </h6>

            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <form 
                        action="{{$varient->id? route('club.varient_management.edit_varient',$varient->id): route('club.varient_management.add_varient') }}"
                        method="POST" 
                        autocomplete="off">
                        @csrf
                        @if($varient->id)
                            @method('PUT')
                        @endif
                       
                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Size</label>
                                <input type="text" name="size" class="form-control" placeholder="Size" 
                                    value="{{ old('size', $varient->size ?? '') }}">
                                @error('size')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>     

                             <div class="col-md-4 mb-3">
                                <label class="form-label">Color</label>
                                <input type="text" name="color" class="form-control" placeholder="Color" 
                                    value="{{ old('color', $varient->color ?? '') }}">
                                @error('color')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div> 

                             <div class="col-md-4 mb-3">
                                <label class="form-label">Stock</label>
                                <input type="text" name="stock" class="form-control" placeholder="Stock" 
                                    value="{{ old('stock', $varient->stock ?? '') }}">
                                @error('stock')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div> 

                            <div class="col-md-4 mb-4">
                                <label class="form-label d-block">Status</label>

                                <input type="hidden" name="status" value="0">

                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input toggle-status"
                                         data-id="{{$varient->id }}" {{ $varient->status ? 'checked' : '' }}
                                        type="checkbox"
                                        name="status"
                                        id="statusSwitch"
                                        value="1"   
                                        {{ old('status', $varient->status ?? 1) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="statusSwitch" id="statusLabel">
                                        {{ old('status', $varient->status ?? 1) ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-5">
                                {{$varient->id ? 'Update' : 'Submit' }}
                            </button> 
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusSwitch = document.getElementById('statusSwitch');
    const statusLabel = document.getElementById('statusLabel');

    if (statusSwitch) {
        statusSwitch.addEventListener('change', function () {
            statusLabel.innerText = this.checked ? 'Active' : 'Inactive';
        });
    }
});

    

$(document).on('change', '.toggle-status', function () {

    let varientId = $(this).data('id');
    let status = $(this).is(':checked') ? 1 : 0;

     $.ajax({
        url: "{{ route('club.varient_management.change-status') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: varientId,
            status: status
        },
    });
});


// document.addEventListener('DOMContentLoaded', function () {

//     const countrySelect = document.getElementById('country');
//     const stateSelect   = document.getElementById('state');
//     const selectedState = "{{ old('state', $clubmember->state_id ?? '') }}";

//     function loadStates(countryId) {
//         stateSelect.innerHTML = '<varient value="">Loading...</varient>';

//        fetch(`/admin/get-states/${countryId}`)
//     .then(response => {
//         if (!response.ok) {
//             throw new Error('Network error');
//         }
//         return response.json();
//     })
//     .then(states => {
//         stateSelect.innerHTML = '<varient value="">Select State</varient>';
//         states.forEach(state => {
//             stateSelect.innerHTML +=
//                 `<varient value="${state.id}">${state.name}</varient>`;
//         });
//     })
//     .catch(error => {
//         console.error(error);
//         stateSelect.innerHTML = '<varient value="">Failed to load states</varient>';
//     });

//     }

//     countrySelect.addEventListener('change', function () {
//         if (this.value) {
//             loadStates(this.value);
//         } else {
//             stateSelect.innerHTML = '<varient value="">Select State</varient>';
//         }
//     });

//     // AUTO LOAD STATES ON EDIT
//     if (countrySelect.value) {
//         loadStates(countrySelect.value);
//     }
// });
</script>
@endsection
@endsection