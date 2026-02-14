
@extends('admin.components.app')

@section('content')
@section('page-title', 'Add Clubs')
<div class="mb-4">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-globe2 small me-2"></i> Dashboard
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.show_option') }}">
                    <i class="bi bi-sliders me-2"></i> Options
                </a>
            </li>
            <li class="breadcrumb-item active"><i class="bi bi-building small me-2"></i>Add Options</li>
        </ol>
    </nav>
</div>

<div class="container mt-4"> 
    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="text-start mb-4">
                {{ $option->id ? 'Edit' : 'Add' }} Options
            </h4>

            <form
                action="{{ $option->id ? route('admin.updateoption', $option->id) : route('admin.addoption') }}" 
                method="POST">
                @csrf
                @if($option->id) @method('PUT') @endif

                <div class="row">

                    {{-- Name --}}
                    <div class="col-md-4 mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $option->name ?? '') }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
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
                                        {{ old('status', $option->status ?? 1) ? 'checked' : '' }}

                                    >
                                    <label class="form-check-label" for="statusSwitch" id="statusLabel">
                                        {{ old('status', $option->status ?? 1) ? 'Active' : 'Inactive' }}

                                    </label>
                                </div>
                            </div>

                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-primary px-5">
                        {{ $option->id ? 'Update' : 'Submit' }}
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

</script>
@endsection
@endsection
