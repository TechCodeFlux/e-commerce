@extends('admin.components.app')
@section('page-title', 'Club ' . $club->name)

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
            <li class="breadcrumb-item active" aria-current="page">
                <i class="bi bi-building small me-2"></i>{{ $club->name }}
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
                
                    <h5 class="card-header border-0">Create Microsite</h5>
                

                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                  <form action="{{ route('admin.microsite_store') }}" method="POST" enctype="multipart/form-data">

                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Event Banner</label>
                            <input type="file" name="image" id="bannerInput" class="form-control" accept="image/*">
                            @error('image') 
                                <small class="text-danger">{{ $message }}</small> 
                            @enderror

                            <!-- Image Preview -->
                            <div class="mt-3">
                                <img id="bannerPreview" 
                                    src="#" 
                                    alt="Banner Preview" 
                                    class="img-fluid rounded d-none" 
                                    style="max-height: 200px;">
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                                @error('start_date') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                                @error('end_date') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        {{-- Hidden Club ID --}}
                        <input type="hidden" name="club_id" value="{{ $club->id }}"  readonly>

                        <div class="d-flex justify-content-between align-items-center mt-4">

                        <!-- Status Toggle -->
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                type="checkbox" 
                                name="status" 
                                id="statusToggle" 1
                                value="1" 
                                checked>
                            <label class="form-check-label ms-2" for="statusToggle">
                                Active
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Create Microsite
                        </button>

                </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const bannerInput = document.getElementById('bannerInput');
    const preview = document.getElementById('bannerPreview');

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

});
</script>
@endsection