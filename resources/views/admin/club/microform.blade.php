@extends('admin.components.app')
@section('page-title', 'Club #' . $club->id)

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
                <i class="bi bi-building small me-2"></i> Club #{{ $club->id }}
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
                <div class="card-header">
                    <h5 class="mb-0">Create Microsite</h5>
                </div>

                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                  <form action="{{ route('admin.clubs.microsites.store') }}" method="POST" enctype="multipart/form-data">

                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Event Name</label>
                            <input type="text" name="event_name" class="form-control" value="{{ old('event_name') }}">
                            @error('event_name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Event Banner</label>
                            <input type="file" name="banner" class="form-control">
                            @error('banner') <small class="text-danger">{{ $message }}</small> @enderror
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
                        {{-- <input type="hidden" name="club_id" value="{{ $club->id }}"> --}}

                        <div class="text-end">
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
