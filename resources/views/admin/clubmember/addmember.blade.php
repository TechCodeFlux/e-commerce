
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
                        <i class="bi bi-person-badge small me-2"></i> Clubs
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.clubs.dashboard', $club->id) }}">
                        <i class="bi bi-people-fill small me-2"></i>{{$club->name}}
                    </a>
                </li>
                    <li class="breadcrumb-item">
                    <a href="{{ route('admin.clubmember.viewmembers', $club->id) }}">
                        <i class="bi bi-people-fill small me-2"></i>Club members
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-building small me-2"></i>Add member</li>  
            </ol>
        </nav>
    </div>

<div class="content ">
    <div class="row flex-md-row">
        
        @include('admin.club.side_bar')
    

       <div class="col-md-9">
        <div class="card shadow-sm">
                <div class="card-body">

                <h4 class="text-center mb-4">
                        {{ $clubmember->id ? 'Edit' : 'Add' }} Club member
                    </h4>

                    <form
                        action="{{ $clubmember->id ? route('admin.clubmember.updatemember', $clubmember->id) : route('admin.clubmember.storemember',$club->id) }}"
                        {{--  --}}
                        method="POST">
                        @csrf
                        @if($clubmember->id) @method('POST') @endif

                        <div class="row">

                            {{-- Name --}}
                            <div class="col-md-4 mb-3">
                                <label>Name</label>
                                <input type="text" name="name"               
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $clubmember->name ?? '') }}">

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            {{-- Email --}}
                            <div class="col-md-4 mb-3">
                                <label>Email</label>
                                <input type="email" name="email" 
                            class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $clubmember->email ?? '') }}">

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Contact --}}
                            <div class="col-md-4 mb-3">
                                <label>Contact</label>
                                <input type="text" name="contact" 
                                class="form-control @error('contact') is-invalid @enderror"
                                value="{{ old('contact', $clubmember->contact ?? '') }}">

                                @error('contact')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Address --}}
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

                           

                        <div class="text-center mt-3">
                            <button class="btn btn-primary px-5">
                                {{ $clubmember->id ? 'Update' : 'Submit' }}
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

    // EDIT MODE VALUES
    const selectedCountry = "{{ old('country', $clubmember->country_id ?? '') }}";
    const selectedState   = "{{ old('state', $clubmember->state_id ?? '') }}";

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
    if (selectedCountry) {
        countrySelect.value = selectedCountry;
        loadStates(selectedCountry, selectedState);
    }
});
</script>
@endsection

        
    
       </div>
</div>
@endsection
