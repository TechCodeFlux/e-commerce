@extends('club.components.app')
@section('page-title', $club->name)
@php
    $hideSearch = true;
@endphp

@section('content')
<div class="container-fluid px-3 px-md-4">
    {{-- Breadcrumbs --}}
    <div class="mb-4 mt-2">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                        <i class="bi bi-globe2 small me-1"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.clubsindex') }}" class="text-decoration-none">
                        <i class="bi bi-people-fill small me-1"></i> Clubs
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="bi bi-building small me-1"></i> Profile
                </li>
            </ol>
        </nav>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 p-md-5">
                    <form method="POST" action="{{ route('admin.club.editprofile',$club->id) }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Header Section: Image + Basic Info --}}
                        <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start mb-5 text-center text-md-start">
                            
                            {{-- Avatar with Upload Overlay --}}
                            <div class="position-relative mb-3 mb-md-0 me-md-4">
                                <label for="imageUpload" style="cursor:pointer;" class="d-block">
                                    <img id="avatarPreview"
                                         src="{{ $club->image ? asset('storage/'.$club->image) : asset('assets/images/user/man_avatar3.jpg') }}"
                                         width="140" height="140"
                                         class="rounded-circle border shadow-sm p-1"
                                         style="object-fit:cover;">
                                    
                                    <span class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow" 
                                          style="width: 38px; height: 38px; border: 3px solid #fff;">
                                        <i class="bi bi-camera-fill"></i>
                                    </span>
                                </label>
                                <input type="file" name="image" id="imageUpload" accept="image/*" class="d-none">
                            </div>

                            <div class="flex-grow-1 mt-md-2">
                                <h3 class="fw-bold mb-1 text-dark">{{$club->name}}</h3>
                                <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3 mb-3">
                                    <span class="text-muted">
                                        <i class="bi bi-envelope-fill text-primary me-1"></i> {{$club->email}}
                                    </span>
                                    <span class="text-muted">
                                        <i class="bi bi-telephone-fill text-primary me-1"></i> {{$club->contact}}
                                    </span>
                                </div>
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                    <i class="bi bi-patch-check-fill me-1"></i> Active Club Account
                                </span>
                            </div>
                        </div>

                        <hr class="my-4 opacity-25">

                        {{-- Form Fields --}}
                        <div class="row g-4">
                            <div class="col-12 mb-2">
                                <h5 class="fw-bold text-secondary mb-0">Basic Information</h5>
                                <p class="text-muted small">Update your club's public profile and contact details.</p>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label small fw-bold">Club Name</label>
                                <input type="text" name="name" class="form-control form-control-lg" value="{{ old('name',$club->name) }}">
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label small fw-bold">Email Address</label>
                                <input type="email" name="email" class="form-control form-control-lg" value="{{ old('email',$club->email) }}">
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label small fw-bold">Contact Number</label>
                                <input type="text" name="contact" class="form-control form-control-lg" value="{{ old('contact',$club->contact) }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-bold">Street Address</label>
                                <textarea name="address" class="form-control" rows="3">{{ old('address',$club->address) }}</textarea>
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <label class="form-label small fw-bold">Country</label>
                                <select name="country" id="country" class="form-select">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{$country->id}}" {{ $club->country_id == $country->id ? 'selected' : '' }}>
                                            {{$country->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <label class="form-label small fw-bold">State/Province</label>
                                <select name="state" id="state" class="form-select">
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                        <option value="{{$state->id}}" {{ $club->state_id == $state->id ? 'selected' : '' }}>
                                            {{$state->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <label class="form-label small fw-bold">City</label>
                                <input type="text" name="city" class="form-control" value="{{$club->city}}">
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <label class="form-label small fw-bold">Zip Code</label>
                                <input type="text" name="zip_code" class="form-control" value="{{$club->zip_code}}">
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="mt-5 pt-4 border-top d-flex flex-column flex-sm-row justify-content-end gap-2">
                            {{-- <button type="reset" class="btn btn-light px-4 py-2 border">Cancel</button> --}}
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm">
                                <i class="bi bi-check-circle me-1"></i> Save Changes
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
// COUNTRY → STATE AJAX
document.addEventListener('DOMContentLoaded', function () {
    const countrySelect = document.getElementById('country');
    const stateSelect = document.getElementById('state');

    function loadStates(countryId) {
        stateSelect.innerHTML = '<option>Loading...</option>';
        fetch(`/admin/get-states/${countryId}`)
            .then(response => response.json())
            .then(states => {
                stateSelect.innerHTML = '<option value="">Select State</option>';
                states.forEach(state => {
                    const option = document.createElement('option');
                    option.value = state.id;
                    option.textContent = state.name;
                    stateSelect.appendChild(option);
                });
            })
            .catch(error => {
                stateSelect.innerHTML = '<option value="">Error loading states</option>';
                console.error('Fetch error:', error);
            });
    }

    countrySelect.addEventListener('change', function () {
        if (this.value) loadStates(this.value);
    });
});

// IMAGE PREVIEW
document.getElementById('imageUpload').addEventListener('change', function(e){
    const file = e.target.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            document.getElementById('avatarPreview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection