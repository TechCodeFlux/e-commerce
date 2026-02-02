@extends('clubmember.components.app')

@section('content')

<div class="mb-4">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('clubmember.dashboard') }}">
                    <i class="bi bi-house-door small me-2"></i> Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active">
                <i class="bi bi-geo-alt small me-2"></i> Edit Address
            </li>
        </ol>
    </nav>
</div>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="text-center mb-4">Edit Address</h4>

            <form action="{{ route('clubmember.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Address --}}
                    <div class="col-md-12 mb-3">
                        <label>Address</label>
                        <textarea name="address" class="form-control" required>{{ old('address', $user->address) }}</textarea>
                    </div>

                    {{-- Country --}}
                    <div class="col-md-4 mb-3">
                        <label>Country</label>
                        <select name="country" id="country" class="form-select" required>
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}"
                                    {{ old('country', $user->country_id) == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- State --}}
                    <div class="col-md-4 mb-3">
                        <label>State</label>
                        <select name="state" id="state" class="form-select" required>
                            <option value="">Select State</option>
                        </select>
                    </div>

                    {{-- City --}}
                    <div class="col-md-4 mb-3">
                        <label>City</label>
                        <input type="text" name="city" class="form-control"
                               value="{{ old('city', $user->city) }}" required>
                    </div>

                    {{-- ZIP --}}
                    <div class="col-md-4 mb-3">
                        <label>ZIP Code</label>
                        <input type="text" name="zip_code" class="form-control"
                               value="{{ old('zip_code', $user->zip_code) }}" required>
                    </div>

                </div>

                <div class="text-center mt-3">
                    <button class="btn btn-primary px-5">Update Address</button>
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
    const selectedState = "{{ old('state', $user->state_id) }}";

    function loadStates(countryId) {
        stateSelect.innerHTML = '<option value="">Loading...</option>';

        fetch(`/clubmember/get-states/${countryId}`)
            .then(response => response.json())
            .then(states => {
                stateSelect.innerHTML = '<option value="">Select State</option>';
                states.forEach(state => {
                    stateSelect.innerHTML += `<option value="${state.id}">${state.name}</option>`;
                });

                if (selectedState) {
                    stateSelect.value = selectedState;
                }
            })
            .catch(() => {
                stateSelect.innerHTML = '<option value="">Failed to load states</option>';
            });
    }

    countrySelect.addEventListener('change', function () {
        if (this.value) loadStates(this.value);
    });

    // Auto load states if already selected
    if (countrySelect.value) {
        loadStates(countrySelect.value);
    }

});
</script>
@endsection
