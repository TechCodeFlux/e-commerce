@extends('admin.components.app')
@section('page-title', $club->name)

@section('content')
<div class="mb-4">
    <nav style="--bs-breadcrumb-divider: '>';">
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
            <li class="breadcrumb-item active">
                <i class="bi bi-building small me-2"></i>Profile
            </li>
        </ol>
    </nav>
</div>

<div class="content">
<div class="row flex-md-row">

@include('admin.club.side_bar')

<div class="col-md-9">

<div class="tab-content">
<div class="tab-pane fade show active">

<div class="mb-4">

<form method="POST"
      action="{{ route('admin.club.editprofile',$club->id) }}"
      enctype="multipart/form-data">
@csrf

<div class="d-flex flex-column flex-md-row text-center text-md-start mb-3">

    <figure class="me-4 flex-shrink-0 text-center">

        <label for="imageUpload"
               style="cursor:pointer; position:relative; display:inline-block;">

            {{-- PROFILE IMAGE --}}
            <img id="avatarPreview"
                 src="{{ $club->image 
                        ? asset('storage/'.$club->image) 
                        : asset('assets/images/user/man_avatar3.jpg') }}"
                 width="130"
                 height="130"
                 class="rounded-circle border shadow"
                 style="object-fit:cover;">

            {{-- CAMERA ICON --}}
            <span style="
                position:absolute;
                bottom:5px;
                right:5px;
                background:#0d6efd;
                color:white;
                border-radius:50%;
                padding:6px 8px;">
                <i class="bi bi-camera-fill"></i>
            </span>
        </label>

        <input type="file" name="image" id="imageUpload"
               accept="image/*" style="display:none;">
    </figure>

   <div class="flex-fill">

    <h4 class="fw-bold mb-1 text-dark">
        {{$club->name}}
    </h4>

    <div class="d-flex align-items-center gap-2 mb-2">

        <i class="bi bi-envelope-fill text-primary"></i>

        <span class="text-muted">
            {{$club->email}}
        </span>

    </div>

    <span class="badge bg-success-subtle text-success px-3 py-2">
        <i class="bi bi-patch-check-fill me-1"></i>
        Active
    </span>

</div>

</div>

<div class="card mb-4">
<div class="card-body">

<h6 class="card-title mb-4">Basic Information</h6>

<div class="row">

<div class="col-md-4 mb-3">
<label>Name</label>
<input type="text" name="name" class="form-control"
       value="{{ old('name',$club->name) }}">
</div>

<div class="col-md-4 mb-3">
<label>Email</label>
<input type="text" name="email" class="form-control"
       value="{{ old('email',$club->email) }}">
</div>

<div class="col-md-4 mb-3">
<label>Contact</label>
<input type="text" name="contact" class="form-control"
       value="{{ old('contact',$club->contact) }}">
</div>

<div class="col-md-12 mb-3">
<label>Address</label>
<textarea name="address" class="form-control">
{{ old('address',$club->address) }}
</textarea>
</div>

<div class="col-md-4 mb-3">
<label>Country</label>
<select name="country" id="country" class="form-select">
<option value="">Select Country</option>
@foreach($countries as $country)
<option value="{{$country->id}}"
{{$club->country_id == $country->id ? 'selected':''}}>
{{$country->name}}
</option>
@endforeach
</select>
</div>

<div class="col-md-4 mb-3">
<label>State</label>
<select name="state" id="state" class="form-select">
<option value="">Select State</option>
@foreach($states as $state)
<option value="{{$state->id}}"
{{$club->state_id == $state->id ? 'selected':''}}>
{{$state->name}}
</option>
@endforeach
</select>
</div>

<div class="col-md-4 mb-3">
<label>City</label>
<input type="text" name="city" class="form-control"
       value="{{$club->city}}">
</div>

<div class="col-md-4 mb-3">
<label>Zip Code</label>
<input type="text" name="zip_code" class="form-control"
       value="{{$club->zip_code}}">
</div>

<div class="d-flex justify-content-end mt-3">
    <button type="submit" class="btn btn-primary px-4">
        Save Changes
    </button>
</div>

</div>
</div>
</div>

</form>


</div>
</div>
</div>

</div>
</div>
</div>
@section('script')

<script>
// COUNTRY → STATE
document.addEventListener('DOMContentLoaded', function () {

    const countrySelect = document.getElementById('country');
    const stateSelect   = document.getElementById('state');

    function loadStates(countryId) {

        stateSelect.innerHTML = '<option>Loading...</option>';

        fetch(`/admin/get-states/${countryId}`)
            .then(response => response.json())
            .then(states => {

                stateSelect.innerHTML = '<option>Select State</option>';

                states.forEach(state => {
                    stateSelect.innerHTML +=
                        `<option value="${state.id}">${state.name}</option>`;
                });
            });
    }

    countrySelect.addEventListener('change', function () {
        if (this.value) loadStates(this.value);
    });
});
</script>


<script>
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
@endsection
