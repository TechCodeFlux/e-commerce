@extends('admin.components.app')
 @section('page-title', $club->name) 
@php
    $hideSearch = true;
@endphp
@section('head')
@endsection

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
                        <i class="bi bi-person-badge small me-2"></i> Clubs
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.clubs.dashboard', $club->id) }}">
                        <i class="bi bi-people-fill small me-2"></i>{{$club->name}}
                    </a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.clubmember.viewmembers', $club->id) }}">
                        <i class="bi bi-people-fill small me-2"></i>club members
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-building small me-2"></i>Profile</li>  
            </ol>
        </nav>
    </div>

<div class="row">

    {{-- <div class="col-md-3"> --}}
        @include('admin.club.side_bar')
    {{-- </div> --}}

                <div class="col-md-9">
                                <div class="row justify-content-center">
                                    <div class="col-12 col-md-8 col-lg-10">
                                    <div class="d-flex justify-content-between align-items-center">
                                                
                                            <h2 class="fw-bold mb-0">Profile</h2>

                                                <a href="{{ route('admin.clubmember.vieworder', $clubmember->id) }}" id="btn-settings"
                                                    class="btn border-black m-2 bg-primary text-bg-secondary"
                                                    type="button">
                                                    <i class="bi bi-receipt me-2 "></i> Order History
                                                </a>
                                        </div>
                                        {{-- <button onclick="switchTab('settings')" id="btn-settings" class="nav-link text-secondary rounded-4 fw-bold py-2" type="button">
                                            <i class="fa-solid fa-gears me-2"></i>Settings
                                        </button> --}}
                                        <!-- Main Card -->
                                        <div class="card border-0 shadow-lg rounded-5 overflow-hidden bg-white">
                                            
                                            <!-- Header Banner -->
                                            <div class="p-5 bg-primary bg-gradient position-relative" style="height: 120px;">
                                                <!-- Avatar Container -->
                                                <div class="position-absolute bottom-0 start-0 ms-4 translate-middle-y" style="margin-bottom: -40px;">
                                                    {{-- <div class="bg-white p-1 rounded-4 shadow-sm">
                                                        <img id="profileImage" src="{{ $clubmember->image ? asset('storage/' . $clubmember->image) : asset('assets/images/default-avatar.png') }}" 
                                                        alt="Avatar" class="rounded-4 bg-light" style="width: 90px; height: 90px; object-fit: contain;">
                                                    </div> --}}
                                                    <figure class="me-4 flex-shrink-0 text-center m-1">

                                                        <label for="imageUpload" style="cursor:pointer; position:relative; display:inline-block;">

                                                            {{-- Profile Image --}}
                                                            <img id="avatarPreview"
                                                                src="{{ $clubmember->image 
                                                                        ? asset('storage/'.$clubmember->image) 
                                                                        : asset('assets/images/user/man_avatar3.jpg') }}"
                                                                width="100"
                                                                height="100"
                                                                {{-- style="object-fit:contain;" --}}
                                                                class="rounded-4 bg-light" style="width: 90px; height: 90px;object-fit: contain;">

                                                            {{-- Edit Icon Overlay --}}
                                                            <span style="
                                                                position:absolute;
                                                                bottom:5px;
                                                                right:5px;
                                                                background:#0d6efd;
                                                                color:white;
                                                                border-radius:50%;
                                                                padding:6px 8px;
                                                                font-size:14px;">
                                                                <i class="bi bi-camera-fill"></i>
                                                            </span>
                                                        </label>

                                                        {{-- Hidden file input --}}
                                                        <input type="file" name="image" id="imageUpload" accept="image/*" style="display:none;">

                                            </figure>
                                                </div> 
                                            </div>

                                            <div class="card-body p-4 pt-3 mt-2">
                                                <!-- Profile Header Info -->
                                                <div class="mb-4">
                                                    <h2 id="display-name" class="fw-bold text-dark mb-0">{{ $clubmember->name }}</h2>
                                                    <p class="text-primary fw-semibold">{{ $clubmember->email }}</p>
                                                </div>

                                                <!-- Navigation Tab Buttons -->
                                                <div class="nav nav-pills nav-fill bg-light p-1 rounded-4 mb-4" id="pills-tab" role="tablist">
                                                    <a onclick="switchTab('details')" id="btn-details" class="nav-link active rounded-4 fw-bold py-2" type="button">
                                                        <i class="fas fa-address-card me-2"></i>Details
                                                    </a>
                                                    <a onclick="switchTab('edit')" id="btn-edit" class="nav-link rounded-4 fw-bold py-2" type="button">
                                                        <i class="fas fa-edit me-2"></i>Edit
                                                    </a>
                                                    
                                                </div>

                                                <!-- Details Tab Content -->
                                                <div id="tab-details" class="d-block">
                                                    <div class="row g-4">
                                                        <div class="col-12 col-sm-6">
                                                            <label class="small fw-bold text-uppercase  ls-wide mb-1 d-block " style="letter-spacing: 0.10em;">Email Address</label>
                                                            <div id="view-email" class="text-dark fw-medium d-flex align-items-center ">
                                                                <i class="fa fa-solid fa-envelope me-3 text-muted opacity-50 "></i>{{ $clubmember->email }}
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <label class="small fw-bold text-uppercase  ls-wide mb-1 d-block" style="letter-spacing: 0.10em;">Contact Number</label>
                                                            <div id="view-contact" class="text-dark fw-medium d-flex align-items-center">
                                                                <i class="fa fa-solid fa-phone me-3 text-muted opacity-50"></i>{{ $clubmember->contact }}
                                                            </div>
                                                        </div>
                                                        <div class="col-12 ">
                                                            <label class="small fw-bold text-uppercase  ls-wide mb-1 d-block" style="letter-spacing: 0.10em;">Physical Address</label>
                                                            <div id="view-address" class="text-dark fw-medium d-flex align-items-center">
                                                                <i class="fa fa-map-marker me-3 text-muted opacity-50"></i>{{ $address->address1 }}, {{ $address->city }}, {{ $address->state->name }}, {{ $address->country->name }}
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    
                                                    <hr class="my-4 opacity-10">
                                                    
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="small text-muted">Joined Jan 2023</span>
                                                        @if($clubmember->status===1)
                                                            <span class="badge rounded-pill bg-success px-3 py-2 fw-bold text-uppercase" style="font-size: 0.65rem;">Active Member</span>
                                                            @else
                                                            <span class="badge rounded-pill bg-secondary px-3 py-2 fw-bold text-uppercase" style="font-size: 0.65rem;">Inactive Member</span>
                                                        @endif
                                                        
                                                    </div>
                                                </div>

                                                <!-- Edit Tab Content -->
                                                <div id="tab-edit" class="d-none">
                                                    <form 
                                                        id="editProfileForm"
                                                        method="POST"
                                                        action="{{ route('admin.clubmember.updateprofile', $clubmember->id) }}"
                                                        enctype="multipart/form-data"
                                                        class="row g-3">
                                                        @csrf
                                                        {{-- @method('PUT') --}}
                                                        <div class="col-md-4">
                                                            <label class="form-label small fw-bold">Full Name</label>

                                                            <input type="text"
                                                                id="edit-name"
                                                                name="name"
                                                                value="{{ old('name', $clubmember->name) }}"
                                                                class="form-control border-light bg-light rounded-3 @error('name') is-invalid @enderror">

                                                            @error('name')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label small fw-bold">Email</label>

                                                            <input type="email"
                                                                id="edit-email"
                                                                name="email"
                                                                value="{{ old('email', $clubmember->email) }}"
                                                                class="form-control border-light bg-light rounded-3 @error('email') is-invalid @enderror">

                                                            @error('email')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label small fw-bold">Contact</label>

                                                            <input type="text"
                                                                id="edit-contact"
                                                                name="contact"
                                                                value="{{ old('contact', $clubmember->contact) }}"
                                                                class="form-control border-light bg-light rounded-3 @error('contact') is-invalid @enderror">

                                                            @error('contact')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-12">
                                                        <label class="form-label small fw-bold ">Address</label>
                                                            <textarea id="edit-address" name="address" rows="2" class="form-control border-light bg-light rounded-3 @error('address') is-invalid @enderror">{{ old('address', $address->address1 ?? '') }}
                                                            </textarea>

                                                            @error('address')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                            </div>
                                                        {{-- Country --}}
                                                        <div class="col-md-4 mb-3">
                                                            <label>Country</label>
                                                            <select name="country" id="country" class="form-control border-light bg-light rounded-3 @error('country') is-invalid @enderror">
                                                                <option value="">Select Country</option>
                                                                @foreach($countries as $country)
                                                                    <option value="{{ $country->id }}"
                                                                    {{ old('country', optional($address)->country_id) == $country->id ? 'selected' : '' }}>
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
                                                        <select name="state" id="state" class="form-control border-light bg-light rounded-3 @error('state') is-invalid @enderror">
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
                                                            @error('state')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>

                                                        {{-- City --}}
                                                        <div class="col-md-4 mb-3">
                                                            <label>City</label>
                                                            <input type="text" name="city" class="form-control border-light bg-light rounded-3 @error('city') is-invalid @enderror"
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
                                                            <input type="text" name="zip_code" class="form-control border-light bg-light rounded-3 @error('zip_code') is-invalid @enderror"
                                                                value="{{ old('zip_code', $address->zip_code ?? '') }}">
                                                                @error('zip_code')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        
                                                        <div class="col-12 d-flex justify-content-end mt-3">
                                                            <button type="submit" id="submitBtn" class="btn btn-primary px-4 fw-bold shadow-sm rounded-3">
                                                                Save Changes
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>

                                                <!-- Settings Tab Content -->
                                                <div id="tab-settings" class="d-none">
                                                    <div class="list-group list-group-flush">
                                                        <div class="list-group-item px-0 py-3 border-0 border-bottom d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 me-3">
                                                                    <i class="fa-solid fa-bell"></i>
                                                                </div>
                                                                <div>
                                                                    <p class="mb-0 fw-bold">Push Notifications</p>
                                                                    <p class="mb-0 small text-muted">Alerts for club events</p>
                                                                </div>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" checked>
                                                            </div>
                                                        </div>
                                                        <div class="list-group-item px-0 py-3 border-0 border-bottom d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <div class="bg-secondary bg-opacity-10 text-secondary p-2 rounded-3 me-3">
                                                                    <i class="fa-solid fa-eye-slash"></i>
                                                                </div>
                                                                <div>
                                                                    <p class="mb-0 fw-bold">Private Profile</p>
                                                                    <p class="mb-0 small text-muted">Hide info from members</p>
                                                                </div>
                                                            </div>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox">
                                                            </div>
                                                        </div>
                                                        <div class="mt-4">
                                                            <button onclick="showAlert('Deactivation request sent.')" class="btn btn-outline-danger w-100 rounded-3 small fw-bold">Deactivate Membership</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Alert Toast (Custom Bootstrap) -->
                            <div id="custom-alert" class="position-fixed top-0 start-50 translate-middle-x mt-3 opacity-0 transition shadow-lg px-4 py-2 bg-dark text-white rounded-pill d-none" style="transition: all 0.5s ease; z-index: 1060;">
                                <span id="alert-message">Message here</span>
                            </div>

                        
                            @if ($errors->any())
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        switchTab('edit');
                                    });
                                </script>
                                @endif
                            <script>
                                function switchTab(tabName) {
                                    // Hide all tab content
                                    document.getElementById('tab-details').className = 'd-none';
                                    document.getElementById('tab-edit').className = 'd-none';
                                    document.getElementById('tab-settings').className = 'd-none';
                                    
                                    // Show selected
                                    document.getElementById('tab-' + tabName).className = 'd-block';

                                

                                    // Reset all buttons
                                    ['details', 'edit'].forEach(btn => {
                                        const el = document.getElementById('btn-' + btn);
                                        el.classList.remove('active', 'text-dark');
                                        el.classList.add('text-dark');
                                    });

                                    // Set active button
                                    const activeBtn = document.getElementById('btn-' + tabName);
                                    activeBtn.classList.add('active', 'text-dark');
                                    activeBtn.classList.remove('text-dark');
                                }

                                </script>
                                @if(session('success'))
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Success!',
                                                text: "{{ session('success') }}",
                                                confirmButtonColor: '#ff6b35',
                                                confirmButtonText: 'OK'
                                            });
                                        });
                                    </script>
                                @endif
                            </script>
            <script>
            document.addEventListener("DOMContentLoaded", function () {
                const imageInput = document.getElementById('imageUpload');
                const preview = document.getElementById('avatarPreview');

                if (imageInput && preview) {
                    imageInput.addEventListener('change', function (e) {
                        const file = e.target.files[0];
                        if (!file) return;

                        // 1️⃣ Show preview immediately
                        const reader = new FileReader();
                        reader.onload = function (event) {
                            preview.src = event.target.result;
                        };
                        reader.readAsDataURL(file);

                        // 2️⃣ Prepare FormData for AJAX upload
                        const formData = new FormData();
                        formData.append('image', file);

                        // 3️⃣ Send image to Laravel controller
                        fetch("{{ route('admin.clubmember.editimage', $clubmember->id) }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                        .then(async response => {

                            if (!response.ok) {

                                // 🔴 If validation error (422)
                                // if (response.status === 422) {
                                    const errorData = await response.json();

                                    // Switch to Edit Tab
                                    switchTab('edit');

                                    // Show first validation error
                                    let firstError = Object.values(errorData.errors)[0][0];

                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Validation Error',
                                        text: firstError
                                    });
                            

                                throw new Error("Upload failed");
                            }

                            return response.json();
                        })
                        .then(data => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.message
                            });
                        })
                        .catch(error => {
                            console.error('Upload error:', error);
                        });

                    });
                }
            });

            
// Prevent double submit (MAIN LOGIC)
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('editProfileForm');
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
        

    </div>
</div>
@endsection