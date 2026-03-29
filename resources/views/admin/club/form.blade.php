@extends('admin.components.app')
@php
    $hideSearch = true;
@endphp
@section('content')
@section('page-title', 'Add Clubs')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
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
            <li class="breadcrumb-item active"><i class="bi bi-building small me-2"></i>Add Clubs</li>
        </ol>
    </nav>
</div>

<div class="container mt-4"> 
    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="text-left mb-4">
                {{ $clubuser->id ? 'Edit' : 'Add' }} Club User
            </h4>

            <form 
                id="clubForm"
                enctype="multipart/form-data"
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
                            @isset($states)
                                @foreach($states as $state)
                        <option value="{{ $state->id }}"
                            {{ old('state', $clubuser->state_id ?? '') == $state->id ? 'selected' : '' }}>
                                {{ $state->name }}
            </option>
        @endforeach
    @endisset
</select>
                    </div>

                    {{-- City --}}
                    <div class="col-md-4 mb-3">
                        <label>City</label>
                        <input type="text" name="city" class="form-control"
                            value="{{ old('city', $clubuser->city ?? '') }}">
                    </div>
                    {{-- Image --}}
                    <div class="col-md-4 mb-3">
                        <label>Profile Picture</label>
                        <input type="file" name="image" class="form-control" 
                            value="">
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
                                        {{ old('status', $clubuser->status ?? 1) ? 'checked' : '' }}

                                    >
                                    <label class="form-check-label" for="statusSwitch" id="statusLabel">
                                        {{ old('status', $clubuser->status ?? 1) ? 'Active' : 'Inactive' }}

                                    </label>
                                </div>
                            </div>

                </div>
                <div class="col-12 d-flex justify-content-end mt-4">
                    <button type="submit" id="submitBtn" class="btn btn-primary px-5">
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
        stateSelect.innerHTML = '<option value="state">Failed to load states</option>';
    });

    }

    countrySelect.addEventListener('change', function () {
        if (this.value) {
            loadStates(this.value);
        } else {
            stateSelect.innerHTML = '<option value="">Select State</option>';
        }
    });

});

// Prevent double submit (MAIN LOGIC)
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('clubForm');
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

<script>
    document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('clubForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function (e) {
        e.preventDefault(); 

        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2"></span>
            Processing...
        `;

        let formData = new FormData(form);

        fetch(form.action, {
            method: form.method,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        })
        .then(async response => {
            if (response.status === 422) {
                let data = await response.json();
                showErrors(data.errors);
                throw new Error('Validation error');
            }
            return response.json();
        })
        .then(data => {
            // Success
            alert('Saved successfully ✅');
            window.location.reload(); // or redirect
        })
        .catch(error => {
            console.log(error);
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = `{{ $clubuser->id ? 'Update' : 'Submit' }}`;
        });
    });

    function showErrors(errors) {

    // remove old errors
    document.querySelectorAll('.ajax-error').forEach(el => el.remove());

    Object.keys(errors).forEach(field => {

        let input = document.querySelector(`[name="${field}"]`);

        if (input) {
            let errorHtml = `<small class="text-danger ajax-error d-block mt-1">${errors[field][0]}</small>`;
            input.insertAdjacentHTML('afterend', errorHtml);
        }

    });


   function showErrors(errors) {

    // remove old errors
    document.querySelectorAll('.ajax-error').forEach(el => el.remove());
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

    Object.keys(errors).forEach(field => {

        let input = document.querySelector(`[name="${field}"]`);

        if (input) {

            // add red border
            input.classList.add('is-invalid');

            let errorHtml = `<small class="text-danger ajax-error d-block mt-1">${errors[field][0]}</small>`;

            // handle file input separately
            if (input.type === "file") {
                input.closest('.mb-3').insertAdjacentHTML('beforeend', errorHtml);
            } else {
                input.insertAdjacentHTML('afterend', errorHtml);
            }
        }
    });
}
    
}
});


// LIVE VALIDATION ON BLUR (focus out)
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('clubForm');

    const fields = form.querySelectorAll('input, textarea, select');

    fields.forEach(field => {

        field.addEventListener('blur', function () {

            validateField(this);

        });

        field.addEventListener('input', function () {

            removeError(this);

        });

        field.addEventListener('change', function () {

            removeError(this);

        });

    });

    function validateField(field) {

        let value = field.value.trim();

        removeError(field);

        // REQUIRED VALIDATION
        if (field.hasAttribute('required') || field.name === 'name' || field.name === 'email') {

            if (value === '') {
                showError(field, 'This field is required');
                return;
            }
        }

        // EMAIL VALIDATION
        if (field.name === 'email' && value !== '') {
            let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(value)) {
                showError(field, 'Enter a valid email address');
                return;
            }
        }

        // PHONE VALIDATION
        if (field.name === 'contact' && value !== '') {
            let phonePattern = /^[0-9]{10}$/;
            if (!phonePattern.test(value)) {
                showError(field, 'Enter a valid 10-digit number');
                return;
            }
        }

        // ZIP VALIDATION
        if (field.name === 'zip_code' && value !== '') {
            let zipPattern = /^[0-9]{5,6}$/;
            if (!zipPattern.test(value)) {
                showError(field, 'Enter a valid ZIP code');
                return;
            }
        }
    }

    function showError(field, message) {

        field.classList.add('is-invalid');

        let error = document.createElement('small');
        error.className = 'text-danger ajax-error d-block mt-1';
        error.innerText = message;

        if (field.type === "file") {
            field.closest('.mb-3').appendChild(error);
        } else {
            field.parentNode.appendChild(error);
        }
    }

    function removeError(field) {

        field.classList.remove('is-invalid');

        let error = field.parentNode.querySelector('.ajax-error');
        if (error) error.remove();
    }

});
</script>
@endsection
@endsection