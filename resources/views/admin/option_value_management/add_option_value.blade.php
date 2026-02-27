@extends('admin.components.app')

@section('page-title', 'Add Option Values')

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
                <a href="{{ route('admin.option_value_management.show_option_value') }}">
                    <i class="bi bi-sliders me-2"></i> Option Value
                </a>
            </li>
            <li class="breadcrumb-item active">
                <i class="bi bi-building small me-2"></i>
                {{ $option_value->id ? 'Edit' : 'Add' }} Option Value
            </li>
        </ol>
    </nav>
</div>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="text-start mb-4">
                {{ $option_value->id ? 'Edit' : 'Add' }} Option Values
            </h4>

            <form  
                action="{{ $option_value->id ? route('admin.option_value_management.edit_optionvalue', $option_value->id) :  route('admin.option_value_management.addoptionvalue') }}"
                method="POST"
                id="optionValueForm"
                >

                @csrf
                @if($option_value->id)
                    @method('PUT')
                @endif

                {{-- ROW 1 --}}
                <div class="row">

                    {{-- Options --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Options</label>

                        <select name="option_id" class="form-select">
                            <option value="">Select Option</option>

                            @foreach($option_list as $opt)

                                <option value="{{ $opt->id }}"
                                    {{ old('option_value', $option_value->option_value_id ?? '') == $opt->id ? 'selected' : '' }}>
                                    {{ $opt->name }}
                                </option>

                            @endforeach
                        </select>

                        @error('option_id')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Name --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name', $option_value->name ?? '') }}">

                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                </div>
                {{-- ROW 2 --}}
                <div class="row">

                    {{-- Status --}}
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-semibold d-block">Status</label>

                        <input type="hidden" name="status" value="0">

                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="status"
                                   id="statusSwitch"
                                   value="1"
                                   {{ old('status', $option_value->status ?? 1) ? 'checked' : '' }}>

                            <label class="form-check-label ms-2"
                                   for="statusSwitch"
                                   id="statusLabel">
                                {{ old('status', $option_value->status ?? 1) ? 'Active' : 'Inactive' }}
                            </label>
                        </div>
                    </div>

                </div>

                {{-- Submit --}}
                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" id="submitBtn" class="btn btn-primary px-5">
                        {{ $option_value->id ? 'Update' : 'Submit' }}
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
    const statusLabel  = document.getElementById('statusLabel');

    if (statusSwitch) {
        statusSwitch.addEventListener('change', function () {
            statusLabel.innerText = this.checked ? 'Active' : 'Inactive';
        });
    }

});



document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('optionValueForm');
    const submitBtn = document.getElementById('submitBtn');

    if (!form) return;

    form.addEventListener('submit', function (e) {

        let hasError = false;

        // Clear old errors
        document.querySelectorAll('.client-error').forEach(el => el.remove());

        const optionSelect = form.querySelector('[name="option_id"]');
        const nameInput    = form.querySelector('[name="name"]');

        // Validate Option
        if (!optionSelect.value.trim()) {
            showError(optionSelect, 'Please select an option.');
            hasError = true;
        }

        // Validate Name
        if (!nameInput.value.trim()) {
            showError(nameInput, 'Name field is required.');
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
            return false;
        }

        // ✅ Prevent Double Submit (ONLY added logic)
        if (submitBtn.disabled) {
            e.preventDefault();
            return false;
        }

        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2"></span>
            Processing...
        `;
    });

    function showError(element, message) {
        const error = document.createElement('small');
        error.classList.add('text-danger', 'client-error');
        error.innerText = message;
        element.parentNode.appendChild(error);
    }

});
</script>

@endsection
@endsection