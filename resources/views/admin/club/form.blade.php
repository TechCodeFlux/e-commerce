@extends('admin.components.app')

@section('content')

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
                    <i class="bi bi-people-fill small me-2"></i> Clubs
                </a>
            </li>
            <li class="breadcrumb-item active">
                <i class="bi bi-building small me-2"></i>Add Clubs
            </li>
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
    <input type="text" name="name"
        class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $clubuser->name ?? '') }}"
        required
        pattern="^[A-Za-z ]+$"
        title="Name should contain only letters and spaces">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

                
                        

                    {{-- Email --}}
                    <div class="col-md-4 mb-3">
                        <label>Email</label>
                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $clubuser->email ?? '') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
 {{-- Contact --}}
<div class="col-md-4 mb-3">
    <label>Contact</label>
    <input type="text" name="contact"
        class="form-control @error('contact') is-invalid @enderror"
        value="{{ old('contact', $clubuser->contact ?? '') }}"
        required
        inputmode="numeric"
        pattern="^[0-9]+$"
        title="Contact number should contain digits only">
    @error('contact')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

                    {{-- Address --}}
                    <div class="col-md-12 mb-3">
                        <label>Address</label>
                        <textarea name="address"
                            class="form-control @error('address') is-invalid @enderror"
                            required>{{ old('address', $clubuser->address ?? '') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Country --}}
                    <div class="col-md-4 mb-3">
                        <label>Country</label>
                        <select name="country" id="country"
                            class="form-select @error('country') is-invalid @enderror" required>
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}"
                                    {{ old('country', $clubuser->country_id ?? '') == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- State --}}
                    <div class="col-md-4 mb-3">
                        <label>State</label>
                        <select name="state" id="state"
                            class="form-select @error('state') is-invalid @enderror" required>
                            <option value="">Select State</option>
                        </select>
                        @error('state')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- City --}}
                    <div class="col-md-4 mb-3">
                        <label>City</label>
                        <input type="text" name="city"
                            class="form-control @error('city') is-invalid @enderror"
                            value="{{ old('city', $clubuser->city ?? '') }}" required>
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ZIP Code (US) --}}
                    <div class="col-md-4 mb-3">
                        <label>ZIP Code (US)</label>
                        <input type="text" name="zip_code"
                            class="form-control @error('zip_code') is-invalid @enderror"
                            value="{{ old('zip_code', $clubuser->zip_code ?? '') }}"
                            required
                            inputmode="numeric"
                            pattern="^\d{5}(-\d{4})?$"
                            placeholder="12345 or 12345-6789">
                        @error('zip_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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

@endsection

@section('script')
<script>
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

                if (selectedState) {
                    stateSelect.value = selectedState;
                }
            })
            .catch(() => {
                stateSelect.innerHTML = '<option value="">Failed to load states</option>';
            });
    }

    if (countrySelect.value) {
        loadStates(countrySelect.value);
    }

    countrySelect.addEventListener('change', function () {
        this.value ? loadStates(this.value)
                   : stateSelect.innerHTML = '<option value="">Select State</option>';
    });
});
</script>
@endsection
