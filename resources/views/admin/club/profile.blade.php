@extends('admin.components.app')
@section('page-title', $club->name)

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
                        <i class="bi bi-people-fill small me-2"></i> Clubs
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.clubs.dashboard', $club->id) }}">
                        <i class="bi bi-people-fill small me-2"></i> {{$club->name}}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-building small me-2"></i>Profile</li>
            </ol>
        </nav>
    </div>

<div class="content ">
    <div class="row flex-md-row">
        
        @include('admin.club.side_bar')

        <div class="col-md-9">

             <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="mb-4">
                                    <div class="d-flex flex-column flex-md-row text-center text-md-start mb-3">
                                        <figure class="me-4 flex-shrink-0">
                                            <img width="100" class="rounded-pill"
                                                src="../../../assets/images/user/man_avatar3.jpg" alt="...">
                                        </figure>
                                        <div class="flex-fill">
                                            <h5 class="mb-3">{{$club->name}}</h5>
                                             <h6 class="mb-3">{{$club->email}}</h6>
                                            {{-- <button class="btn btn-primary me-2">Change Avatar</button>
                                            <button class="btn btn-outline-danger btn-icon" data-bs-toggle="tooltip" title="Remove Avatar">
                                                <i class="bi bi-trash me-0"></i>
                                            </button>
                                            <p class="small text-muted mt-3">For best results, use an image at least
                                                256px by 256px in either .jpg or .png format</p> --}}
                                        </div>
                                    </div>
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h6 class="card-title mb-4">Basic Information</h6>
                                            <form method="POST" action="{{ route('admin.club.editprofile',$club->id) }}">
                                            @csrf
                                             {{-- @method('PUT') --}}
                                            <div class="row">
                                                {{-- <div class="col-md-6"> --}}
                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label">Name</label>
                                                        <input type="text" class="form-control" name="name" value="{{ old('name', $club->name) }}">
                                                        @error('name')
                                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                                        @enderror

                                                    </div>
                                                    {{-- <div class="mb-3">
                                                        <label class="form-label">Username</label>
                                                        <input type="text" class="form-control" value="adek-kembar">
                                                    </div> --}}
                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label">Email</label>
                                                        <input type="text" class="form-control" name="email" value="{{ old('email', $club->email) }}">
                                                        @error('email')
                                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                                        @enderror

                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label">Telephone no</label>
                                                        <input type="text" class="form-control" name="contact" value="{{ old('contact', $club->contact) }}">
                                                        @error('contact')
                                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                                        @enderror

                                                    </div>
                                                   <div class="col-md-12 mb-3">
                                                        <label class="form-label">Address</label>

                                                        <textarea name="address"
                                                            class="form-control @error('address') is-invalid @enderror">{{ old('address', $club->address ?? '') }}</textarea>

                                                        @error('address')
                                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                                        @enderror
                                                    </div>


                                                        <div class="col-md-4 mb-3">
                                                        <label>Country</label>
                                                        <select name="country" id="country" class="form-select">
                                                            <option value="">Select Country</option>
                                                            @foreach($countries as $country)
                                                                <option value="{{ $country->id }}"
                                                                {{ old('country', optional($club)->country_id) == $country->id ? 'selected' : '' }}>
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
                                                                {{ old('state', optional($club)->state_id) == $state->id ? 'selected' : '' }}>
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
                                                                value="{{ old('city', $club->city ?? '') }}">
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
                                                                value="{{ old('zip_code', $club->zip_code ?? '') }}">
                                                                @error('zip_code')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                      <div>  
                                                    <div class="d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary">
                                                            Save Changes
                                                        </button>
                                                    </div>
                                                      </div>
                                            </form>

                                            {{-- Success Modal --}}
                                            @if(session('success'))
                                            <div class="modal fade" id="successModal" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-success text-white">
                                                            <h5 class="modal-title">Success</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ session('success') }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                {{-- end for the success  --}}

                            
                            
                           
                </div>

                @section('script')
                <script>
                document.addEventListener('DOMContentLoaded', function () {

                    const countrySelect = document.getElementById('country');
                    const stateSelect   = document.getElementById('state');

                    // EDIT MODE VALUES
                    const selectedCountry = "{{ old('country', $club->country_id ?? '') }}";
                    const selectedState   = "{{ old('state', $club->state_id ?? '') }}";

                    function loadStates(countryId, selectedStateId = null) {
                        stateSelect.innerHTML = '<option value="">Loading...</option>';

                        fetch(`/admin/get-states/${countryId}`)
                            .then(response => response.json())
                            .then(states => {
                                stateSelect.innerHTML = '<option value="">Select State</option>';

                                states.forEach(state => {
                                    const selected = selectedStateId == state.id ? 'selected' : '';
                                    stateSelect.innerHTML +=
                                        `<option value="${state.id}" ${selected}>${state.name}</option>`;
                                });
                            })
                            .catch(() => {
                                stateSelect.innerHTML = '<option value="">Failed to load states</option>';
                            });
                    }

                    // ON COUNTRY CHANGE
                    countrySelect.addEventListener('change', function () {
                        if (this.value) {
                            loadStates(this.value);
                        } else {
                            stateSelect.innerHTML = '<option value="">Select State</option>';
                        }
                    });

                    // ✅ AUTO LOAD ON EDIT
                    // if (selectedCountry) {
                    //     countrySelect.value = selectedCountry;
                    //     loadStates(selectedCountry, selectedState);
                    // }
                    
                });
                </script>
                @endsection

            {{-- success modal javascript --}}
                @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        // var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                        // successModal.show();
                    Swal.fire
                    ({
                        icon: 'success',
                        title: 'Update!',
                        text: 'Profile updated successfully',
                        confirmButtonText: 'OK'
                        }).then(() => {
                            // location.reload();  //to reload the current page
                        });
                    });
                </script>
                @endif
             {{--end of success modal in javascript  --}}




        </div>
    </div>

</div>
@endsection