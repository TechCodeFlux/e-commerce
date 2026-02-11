@extends('admin.components.app')
@section('page-title', 'Categories')
@section('content')

 <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">
                        <i class="bi bi-globe2 small me-2"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.category_management.show_category') }}">
                        <i class="bi bi-tags me-2"></i> Category
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-folder-plus me-2"></i>{{ $category->id ? 'Edit Category':'Add category' }}</li>
            </ol>
        </nav>
    </div>

<div class="container mt-4">

    <div class="card mb-4 shadow-sm">
        <div class="card-body">

            <h6 class="card-title mb-4 text-center">
                {{ $category->id ? 'Edit' : 'Add' }} Category Form
            </h6>

            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <form 
                        action="{{ $category->id? route('admin.category_management.edit_category', $category->id): route('admin.category_management.add_category') }}"
                        method="POST" 
                        autocomplete="off">
                        @csrf
                        @if($category->id)
                            @method('PUT')
                        @endif
                       
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Name" 
                                    value="{{ old('name', $category->name ?? '') }}">
                                @error('name')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>  
                            
                             <div class="col-md-6 mb-3">
                                        <label class="form-label">Categories</label>
                                        <select name="category" id="category" class="form-select">
                                          <option value="">Select Category</option>

                                        @foreach($category_list as $cat)

                                          
                                            @if(isset($category->id) && $category->id == $cat->id)
                                                @continue
                                            @endif

                                            <option value="{{ $cat->id }}"
                                                {{ old('category', $category->parent_id ?? '') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>

                                            @endforeach
                                        </select>
                                        @error('category')
                                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label d-block">Status</label>

                                <input type="hidden" name="status" value="0">

                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input toggle-status"
                                         data-id="{{ $category->id }}" {{ $category->status ? 'checked' : '' }}
                                        type="checkbox"
                                        name="status"
                                        id="statusSwitch"
                                        value="1"   
                                        {{ old('status', $category->status ?? 1) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="statusSwitch" id="statusLabel">
                                        {{ old('status', $category->status ?? 1) ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-5">
                                {{ $category->id ? 'Update' : 'Submit' }}
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
document.addEventListener('DOMContentLoaded', function () {
    const statusSwitch = document.getElementById('statusSwitch');
    const statusLabel = document.getElementById('statusLabel');

    if (statusSwitch) {
        statusSwitch.addEventListener('change', function () {
            statusLabel.innerText = this.checked ? 'Active' : 'Inactive';
        });
    }
});

    

$(document).on('change', '.toggle-status', function () {

    let categoryId = $(this).data('id');
    let status = $(this).is(':checked') ? 1 : 0;

     $.ajax({
        url: "{{ route('admin.category_management.change-status') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: categoryId,
            status: status
        },
    });
});


// document.addEventListener('DOMContentLoaded', function () {

//     const countrySelect = document.getElementById('country');
//     const stateSelect   = document.getElementById('state');
//     const selectedState = "{{ old('state', $clubmember->state_id ?? '') }}";

//     function loadStates(countryId) {
//         stateSelect.innerHTML = '<category value="">Loading...</category>';

//        fetch(`/admin/get-states/${countryId}`)
//     .then(response => {
//         if (!response.ok) {
//             throw new Error('Network error');
//         }
//         return response.json();
//     })
//     .then(states => {
//         stateSelect.innerHTML = '<category value="">Select State</category>';
//         states.forEach(state => {
//             stateSelect.innerHTML +=
//                 `<category value="${state.id}">${state.name}</category>`;
//         });
//     })
//     .catch(error => {
//         console.error(error);
//         stateSelect.innerHTML = '<category value="">Failed to load states</category>';
//     });

//     }

//     countrySelect.addEventListener('change', function () {
//         if (this.value) {
//             loadStates(this.value);
//         } else {
//             stateSelect.innerHTML = '<category value="">Select State</category>';
//         }
//     });

//     // AUTO LOAD STATES ON EDIT
//     if (countrySelect.value) {
//         loadStates(countrySelect.value);
//     }
// });
</script>
@endsection
@endsection