@extends('admin.components.app')

@section('content')
@section('page-title', 'Add Clubs')
<div class="mb-4">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-globe2 small me-2"></i> Dashboard
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.clubsindex') }}">
                    <i class="bi bi-person-badge"></i> Clubs
                </a>
            </li>
            <li class="breadcrumb-item active"><i class="bi bi-person-plus-fill small me-2"></i>Add Clubs</li>
        </ol>
    </nav>
</div>

<div class="container mt-4"> 
    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="text-center mb-4">
                {{ $clubuser->id ? 'Edit' : 'Add' }} Club User
            </h4>

            <form
                action="{{ $clubuser->id ? route('admin.update', $clubuser->id) : route('admin.addclub') }}"
                method="POST">
                @csrf
                @if($clubuser->id) @method('PUT') @endif

                <div class="row">

                    {{-- Name --}}
                    <div class="col-md-4 mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $clubuser->name ?? '') }}">
                    </div>

                    {{-- Email --}}
                    <div class="col-md-4 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', $clubuser->email ?? '') }}">
                    </div>

                    {{-- Contact --}}
                    <div class="col-md-4 mb-3">
                        <label>Contact</label>
                        <input type="text" name="contact" class="form-control"
                            value="{{ old('contact', $clubuser->contact ?? '') }}">
                    </div>

                    {{-- Address --}}
                    <div class="col-md-12 mb-3">
                        <label>Address</label>
                        <textarea name="address" class="form-control">{{ old('address', $clubuser->address ?? '') }}</textarea>
                    </div>

                    {{-- Country --}}
                    <div class="col-md-4 mb-3">
                        <label>Country</label>
                        <select name="country" id="country" class="form-select">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}"
                                    {{ old('country', $clubuser->country_id ?? '') == $country->id ? 'selected' : '' }}>
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
                        </select>
                    </div>

                    {{-- City --}}
                    <div class="col-md-4 mb-3">
                        <label>City</label>
                        <input type="text" name="city" class="form-control"
                            value="{{ old('city', $clubuser->city ?? '') }}">
                    </div>

                    {{-- ZIP --}}
                    <div class="col-md-4 mb-3">
                        <label>ZIP Code</label>
                        <input type="text" name="zip_code" class="form-control"
                            value="{{ old('zip_code', $clubuser->zip_code ?? '') }}">
                    </div>

                    {{-- Status --}}
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

                <div class="text-center mt-3">
                    <button class="btn btn-primary px-5">
                        {{ $clubuser->id ? 'Update' : 'Submit' }}
                    </button>
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

    if (statusSwitch) {
        statusSwitch.addEventListener('change', function () {
            statusLabel.innerText = this.checked ? 'Active' : 'Inactive';
        });
    }
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
});
</script>
@endsection
@endsection