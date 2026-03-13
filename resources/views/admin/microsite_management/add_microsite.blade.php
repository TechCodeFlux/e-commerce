@extends('admin.components.app')

@section('page-title', 'Club ' . $club->name)

@php
    $hideSearch = true;
@endphp

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
                <a href="{{ route('admin.clubsindex') }}">
                    <i class="bi bi-people-fill small me-2"></i> {{ $club->name }}
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.show_microsites', $club->id) }}">
                    <i class="bi bi-building small me-2"></i> Microsites 
                </a>
            </li>
            <li class="breadcrumb-item active">
                <i class="bi bi-building small me-2"></i>
                {{ isset($microsite) && $microsite->exists ? 'Edit Microsite' : 'Add Microsite' }}
            </li>
        </ol>
    </nav>
</div>

<div class="content">
    <div class="row">

        {{-- Sidebar --}}
        @include('admin.club.side_bar')

        {{-- Main Content --}}
        <div class="col-md-9">
            <div class="card">

                <h5 class="card-header border-0">
                    {{ isset($microsite) && $microsite->exists ? 'Edit Microsite' : 'Create Microsite' }}
                </h5>

                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form 
                        id="MicrositeForm"
                        action="{{ isset($microsite->id) 
                            ? route('admin.microsite_update', $microsite->id) 
                            : route('admin.microsite_store') }}" 
                        method="POST" 
                        enctype="multipart/form-data"
                    >

                        @csrf

                        @if(isset($microsite->id))
                            @method('PUT')
                        @endif

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $microsite->name ?? '') }}">
                            @error('name') 
                                <small class="text-danger">{{ $message }}</small> 
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" class="form-control">{{ old('description', $microsite->description ?? '') }}</textarea>
                            @error('description') 
                                <small class="text-danger">{{ $message }}</small> 
                            @enderror
                        </div>

                        {{-- Image Upload --}}
                        <div class="mb-3">
                            <label class="form-label">Event Banner</label>

                            <input type="file" 
                                name="image" 
                                id="bannerInput" 
                                class="form-control" 
                                accept="image/*">

                            @error('image') 
                                <small class="text-danger">{{ $message }}</small> 
                            @enderror

                            <input type="hidden" name="old_image" value="{{ $microsite->image ?? '' }}">

                            {{-- Preview --}}
                            <div class="mt-3">
                                <img id="bannerPreview"
                                    src="{{ !empty($microsite->image) ? asset('storage/' . $microsite->image) : '#' }}"
                                    class="img-fluid rounded {{ empty($microsite->image) ? 'd-none' : '' }}"
                                    style="max-height: 200px;">
                            </div>
                        </div>

                        {{-- Dates --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control"
                                    value="{{ old('start_date', isset($microsite->start_date) ? \Carbon\Carbon::parse($microsite->start_date)->format('Y-m-d') : '') }}">
                                @error('start_date') 
                                    <small class="text-danger">{{ $message }}</small> 
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control"
                                    value="{{ old('end_date', isset($microsite->end_date) ? \Carbon\Carbon::parse($microsite->end_date)->format('Y-m-d') : '') }}">
                                @error('end_date') 
                                    <small class="text-danger">{{ $message }}</small> 
                                @enderror
                            </div>
                        </div>

                        {{-- Hidden Club ID --}}
                        <input type="hidden" name="club_id" value="{{ $club->id }}">

                        {{-- Status + Submit --}}
                        <div class="d-flex justify-content-between align-items-center mt-4">

                            <div class="form-check form-switch">
                                <input class="form-check-input"
                                    type="checkbox"
                                    name="status"
                                    value="1"
                                    {{ old('status', $microsite->status ?? 1) ? 'checked' : '' }}>
                                <label class="form-check-label ms-2">
                                    Active
                                </label>
                            </div>

                            <button type="submit" id="submitBtn" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i> 
                                {{ isset($microsite) && $microsite->exists ? 'Update Microsite' : 'Create Microsite' }}
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
document.addEventListener('DOMContentLoaded', function () {

    // Image Preview
    const bannerInput = document.getElementById('bannerInput');
    const preview = document.getElementById('bannerPreview');

    if (bannerInput && preview) {
        bannerInput.addEventListener('change', function (event) {
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Submit Loader
    const form = document.getElementById('MicrositeForm');
    const submitBtn = document.getElementById('submitBtn');

    if (form && submitBtn) {
        form.addEventListener('submit', function () {
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2"></span>
                Processing...
            `;
        });
    }

});
</script>
@endsection