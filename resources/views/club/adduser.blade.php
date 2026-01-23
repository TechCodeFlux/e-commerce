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
                <a href="">
                    <i class="bi bi-people-fill small me-2"></i> Clubs
                </a>
            </li>
            <li class="breadcrumb-item active">
                <i class="bi bi-building small me-2"></i>Add Another Users
            </li>
        </ol>
    </nav>
</div>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="text-center mb-4">
                {{-- {{ $clubuser->id ? 'Edit' : 'Add' }} User --}}
            </h4>

            <form
                {{-- action="{{ $clubuser->id ? route('club.update', $clubuser->id) : route('club.addclub') }}" --}}
                method="POST"
                novalidate>
                @csrf
                {{-- @if($clubuser->id) @method('PUT') @endif --}}

                <div class="row">

                    {{-- Name --}}
                    <div class="col-md-4 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control"
                            placeholder="Enter full name"
                            value="{{ old('name', default: $clubuser->name ?? '') }}">
                    </div>

                    {{-- Email --}}
                    <div class="col-md-4 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            placeholder="Enter email address"
                            value="{{ old('email', $clubuser->email ?? '') }}">
                    </div>

                    {{-- Role --}}
                    <div class="col-md-4 mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role" class="form-select">
                            <option value="">Select Role</option>
                            @php
                                $roles = ['Staff', 'Manager', 'Volunteer', 'Coordinator', 'Member'];
                                $selectedRole = old('role', $clubuser->role ?? '');
                            @endphp
                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ $selectedRole === $role ? 'selected' : '' }}>
                                    {{ $role }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Contact
                    <div class="col-md-4 mb-3">
                        <label for="contact" class="form-label">Contact</label>
                        <input
                            type="text"
                            id="contact"
                            name="contact"
                            class="form-control"
                            placeholder="Enter contact number"
                            value="{{ old('contact', $clubuser->contact ?? '') }}">
                    </div> --}}

                    {{-- Address --}}
                    {{-- <div class="col-md-12 mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea
                            id="address"
                            name="address"
                            class="form-control"
                            rows="3"
                            placeholder="Enter full address">{{ old('address', $clubuser->address ?? '') }}</textarea>
                    </div> --}}
{{-- Address --}}
<div class="col-md-4 mb-3">
    <label>Address</label>
    <textarea
        name="address"
        class="form-control"
        rows="1"
        style="height: 38px; resize: none; overflow: hidden;"
    >{{ old('address', $clubuser->address ?? '') }}</textarea>
</div>

{{-- Contact --}}
<div class="col-md-4 mb-3">
    <label>Contact</label>
    <input type="text" name="contact" class="form-control"
        value="{{ old('contact', $clubuser->contact ?? '') }}">
</div>

                    {{-- Country --}}
                    <div class="col-md-4 mb-3">
                        <label for="country" class="form-label">Country</label>
                        <select name="country" id="country" class="form-select">
                        </select>
                    </div>

                    {{-- State --}}
                    <div class="col-md-4 mb-3">
                        <label for="state" class="form-label">State</label>
                        <select name="state" id="state" class="form-select">
                            <option value="">Select State</option>
                        </select>
                    </div>

                    {{-- City --}}
                    <div class="col-md-4 mb-3">
                        <label for="city" class="form-label">City</label>
                        <input
                            type="text"
                            id="city"
                            name="city"
                            class="form-control"
                            placeholder="Enter city"
                            value="{{ old('city', $clubuser->city ?? '') }}">
                    </div>

                    {{-- ZIP --}}
                    <div class="col-md-4 mb-3">
                        <label for="zip_code" class="form-label">ZIP Code</label>
                        <input
                            type="text"
                            id="zip_code"
                            name="zip_code"
                            class="form-control"
                            placeholder="Enter ZIP code"
                            value="{{ old('zip_code', $clubuser->zip_code ?? '') }}">
                    </div>

                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5">
                        {{-- {{ $clubuser->id ? 'Update' : 'Submit' }} --}}
                        Submit
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

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
