@extends('club.components.app')

@section('content')

 <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('club.dashboard') }}">
                        <i class="bi bi-globe2 small me-2"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('club.member.index', $club->id) }}">
                        <i class="bi bi-building small me-2"></i> Club Members
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-people-fill small me-2"></i>Add Club Members</li>
            </ol>
        </nav>
    </div>

<div class="container mt-4">

    <div class="card mb-4 shadow-sm">
        <div class="card-body">

            <h4 class="text-left mb-4">
                {{ $clubmember->id ? 'Edit' : 'Add' }} Club Member
            </h4>

            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <form 
                    id="memberForm"
                        action="{{ $clubmember->id ? route('club.clubmember.updatemember', $clubmember->id) : route('club.clubmember.storemember',$club->id) }}" 
                        method="POST" 
                        autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf
                        @if($clubmember->id)
                            @method('PUT')
                        @endif
                       
                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Name" 
                                    value="{{ old('name', $clubmember->name ?? '') }}">
                                @error('name')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email"
                                    value="{{ old('email', $clubmember->email ?? '') }}">
                                @error('email')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Contact</label>
                                <input type="text" name="contact" class="form-control" placeholder="Contact"
                                    value="{{ old('contact', $clubmember->contact ?? '') }}">
                                @error('contact')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                            <label>Profile Image</label>
                            <input type="file" name="image"
                                class="form-control @error('profile_image') is-invalid @enderror">

                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            {{-- Show existing image in edit --}}
                            @if(!empty($clubmember->image))
                                <div class="mt-2">
                                    <img src="{{ asset('storage/'.$clubmember->image) }}"
                                        width="80" height="80"
                                        class="rounded-circle"
                                        style="object-fit: cover;">
                                </div>
                            @endif
                        </div>

                            <div class="col-md-12 mb-3">
                                <label>Address</label>
                                <textarea name="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        >{{ old('address', $address->address1 ?? '') }}</textarea>



                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            

                            {{-- Country --}}
                            <div class="col-md-4 mb-3">
                                <label>Country</label>
                                <select name="country" id="country" class="form-select">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}"
                                           {{ old('country', optional($address)->country_id) == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            {{-- State --}}
                           <div class="col-md-4 mb-3">
                            <label>State</label>
                            <select name="state" id="state" class="form-select">
                                <option value="">Select State</option>
                                    @isset($states)
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}"
                                       {{ old('state', optional($address)->state_id) == $state->id ? 'selected' : '' }}>
                                        {{ $state->name }}
                                        </option>
                                    @endforeach
                                 @endisset
                                </select>
                            </div>

                            {{-- City --}}
                            <div class="col-md-4 mb-3">
                                <label>City</label>
                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                                    value="{{ old('city', $address->city ?? '') }}">
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
                                    value="{{ old('zip_code', $address->zip_code ?? '') }}">
                                    @error('zip_code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label d-block">Status</label>

                                <input type="hidden" name="status" value="0">

                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="status"
                                        id="statusSwitch"
                                        value="1"
                                        {{ old('status', $clubmember->status ?? 1) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="statusSwitch" id="statusLabel">
                                        {{ old('status', $clubmember->status ?? 1) ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" id="submitBtn" class="btn btn-primary px-5">
                                {{ $clubmember->id ? 'Update' : 'Submit' }}
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


document.addEventListener('DOMContentLoaded', function () {

    const countrySelect = document.getElementById('country');
    const stateSelect   = document.getElementById('state');
    const selectedState = "{{ old('state', $clubmember->state_id ?? '') }}";

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
});
// Prevent double submit (MAIN LOGIC)
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('memberForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function () {

        // Disable button immediately
        submitBtn.disabled = true;

        // Show loading spinner
        submitBtn.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2"></span>
            Processing...
        `;
    });

});
</script>
@endsection
@endsection