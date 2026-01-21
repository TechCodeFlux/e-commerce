@extends('admin.components.app')

@section('content')
{{-- title breadcrumb --}}
<div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-globe2 small me-2"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('admin.clubsindex') }}">
                    <i class="bi bi-people-fill small me-2"></i>Clubs</a></li>
                <li class="breadcrumb-item active" aria-current="page"> <i class="bi bi-building me-1"></i>Add Clubs</li>
            </ol>
        </nav>
    </div>

    {{-- content form --}}
<div class="container mt-4">

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            
            <?php
            echo $clubuser->id."dfvdxff"; 
            ?>

            <h6 class="card-title mb-4 text-center">
                {{ $clubuser->id ? 'Edit' : 'Add' }} Club User
            </h6>

            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <form 
                        action="{{ $clubuser->id ? route('admin.update', $clubuser->id) : route('admin.addclub') }}" 
                        method="POST" 
                        enctype="multipart/form-data"  autocomplete="off">
                        @csrf
                        @if($clubuser->id)
                            @method('PUT')
                        @endif
                       
                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Name" 
                                    value="{{ old('name', $clubuser->name ?? '') }}">
                                @error('name')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email"
                                    value="{{ old('email', $clubuser->email ?? '') }}">
                                @error('email')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="contact" class="form-control" placeholder="Contact"
                                    value="{{ old('contact', $clubuser->contact ?? '') }}">
                                @error('contact')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="Address">{{ old('address', $clubuser->address ?? '') }}</textarea>
                                @error('address')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" placeholder="Country"
                                    value="{{ old('country', $clubuser->country_id ?? '') }}">
                                @error('country')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control" placeholder="State"
                                    value="{{ old('state', $clubuser->state_id ?? '') }}">
                                @error('state')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" placeholder="City Name"
                                    value="{{ old('city', $clubuser->city ?? '') }}">
                                @error('city')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">ZIP Code</label>
                                <input type="text" name="zip_code" class="form-control" placeholder="ZIP Code"
                                    value="{{ old('zip_code', $clubuser->zip_code ?? '') }}">
                                @error('zip_code')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label d-block">Status</label>
                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="status"
                                        id="statusSwitch"
                                        {{ old('status', $clubuser->status ?? 1) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="statusSwitch" id="statusLabel">
                                        {{ old('status', $clubuser->status ?? 1) ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                                @error('status')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-5">
                                {{ $clubuser->id ? 'Update' : 'Submit' }}
                            </button> 
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@section('script')
<script>
    const statusSwitch = document.getElementById('statusSwitch');
    const statusLabel = document.getElementById('statusLabel');

    statusSwitch.addEventListener('change', function () {
        statusLabel.innerText = this.checked ? 'Active' : 'Inactive';
    });
</script>
@endsection
@endsection
