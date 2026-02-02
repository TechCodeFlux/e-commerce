@extends('admin.components.app')

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
                    <a href="{{ route('admin.product_management.show_products') }}">
                        <i class="bi bi-building small me-2"></i> Products 
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-people-fill small me-2"></i>{{ $product->id ? 'Edit product':'Add product' }}</li>
            </ol>
        </nav>
    </div>

<div class="container mt-4">

    <div class="card mb-4 shadow-sm">
        <div class="card-body">

            <h6 class="card-title mb-4 text-center">
                {{ $product->id ? 'Edit' : 'Add' }} product Form
            </h6>

            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <form 
                        action="{{ $product->id? route('admin.product_management.edit_product', $product->id): route('admin.product_management.add_products') }}"  enctype="multipart/form-data"
                        method="POST" 
                        autocomplete="off">
                        @csrf
                        @if($product->id)
                            @method('PUT')
                        @endif
                       
                        <div class="row">
                            {{-- product-Name & Stock --}}
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Name" 
                                        value="{{ old('name', $product->name ?? '') }}">
                                        @error('name')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div> 
                                    
                                    
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Stock</label>
                                        <input type="number" name="stock" class="form-control" placeholder="Stock" 
                                            value="{{ old('stock', $product->stock ?? '') }}">
                                        @error('stock')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div> 
                            {{-- product-Name & Stock --}} 


                            {{-- category --}}
                                        <div class="col-md-4 mb-3">
                                        <label class="form-label">Categories</label>
                                    <select name="category" id="category" class="form-select">
                                        
                                        <option value="">Select Category</option>
                                    
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                                
                                            </option>
                                            
                                        @endforeach
                                        
                                    </select>
                                    @error('category')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                            {{-- category --}}

                            {{-- ---Option --- --}}
                                        <div class="col-md-4 mb-3">
                                        <label class="form-label">Options</label>
                                    <select name="option" id="option" class="form-select">
                                        
                                        <option value="">Select Option</option>
                                    
                                        @foreach( $options as $option)
                                            <option value="{{ $option->id }}"
                                                {{ old('option', $product->option_id ?? '') == $option->id ? 'selected' : '' }}>
                                                {{ $option->name }}
                                                
                                            </option>
                                            
                                        @endforeach
                                        
                                    </select>
                                    @error('option')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                            {{-- ---Option--- --}}

                            {{-- ---Description--- --}}
                                    <div class="col-md-8 mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" class="form-control" >{{ old('description', $product->description ?? '') }}</textarea>
                                            @error('description')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div> 
                            {{-- ---Description--- --}}

                        </div>
                            {{---image---}}

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Image</label>
                            {{-- Pre-View image --}}
                                        <div class="mt-3">
                                            <img id="imagePreview" 
                                                src="{{ isset($product) && $product->image ? asset('storage/' . $product->image) : '#' }}"
                                                alt="Image Preview" 
                                                class="col-7 ">
                                        </div>
                            {{-- end-pre -View image --}}
                                <input type="file"
                                 name="image" 
                                 class="form-control"
                                 id="imageInput" 
                                 accept="image/*"
                                 onchange="previewImage(event)">
                                       
                                @error('image')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                    {{-- ----status---- --}}

                             <div class="col-md-4 mb-4">
                                <label class="form-label d-block">Status</label>

                                <input type="hidden" name="status" value="0">

                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input toggle-status"
                                        @if(isset($product->id)) data-id="{{ $product->id }}" @endif
                                        type="checkbox"
                                        name="status"
                                        id="statusSwitch"
                                        value="1"   
                                        {{ old('status', $product->status ?? 1) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="statusSwitch" id="statusLabel">
                                        {{ old('status', $product->status ?? 1) ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </div>
                              
                                </div>

                           

                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-5">
                                {{ $product->id ? 'Update' : 'Submit' }}
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

    let productId = $(this).data('id');
    let status = $(this).is(':checked') ? 1 : 0;

    // Javascript Conditional:
    // If productId is undefined (Add Page), do not run AJAX.
    if (!productId ) {
        // console.log('Add page detected: Status change will be saved on form submit.');
        return;
    }

    // If productId exists (Edit Page), run AJAX.
    $.ajax({
        url: "{{ route('admin.product_management.change-status') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: productId,
            status: status
        },
        success: function(response) {
            // Optional: update label text dynamically if needed
             if(status == 1){
                 $('#statusLabel').text('Active');
             } else {
                 $('#statusLabel').text('Inactive');
             }
        }
    });
});










function previewImage(event) {
        var input = event.target;
        var imagePreview = document.getElementById('imagePreview');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                // Set the src of the image to the file data
                imagePreview.src = e.target.result;
                // Make the image visible
                imagePreview.style.display = 'block';
            }

            // Read the file as a data URL
            reader.readAsDataURL(input.files[0]);
        } else {
            // If the user cancels selection, hide the preview
            imagePreview.src = '#';
            imagePreview.style.display = 'none';
        }
    }
// document.addEventListener('DOMContentLoaded', function () {

//     const countrySelect = document.getElementById('country');
//     const stateSelect   = document.getElementById('state');
//     const selectedState = "{{ old('state', $clubmember->state_id ?? '') }}";

//     function loadStates(countryId) {
//         stateSelect.innerHTML = '<product value="">Loading...</product>';

//        fetch(`/admin/get-states/${countryId}`)
//     .then(response => {
//         if (!response.ok) {
//             throw new Error('Network error');
//         }
//         return response.json();
//     })
//     .then(states => {
//         stateSelect.innerHTML = '<product value="">Select State</product>';
//         states.forEach(state => {
//             stateSelect.innerHTML +=
//                 `<product value="${state.id}">${state.name}</product>`;
//         });
//     })
//     .catch(error => {
//         console.error(error);
//         stateSelect.innerHTML = '<product value="">Failed to load states</product>';
//     });

//     }

//     countrySelect.addEventListener('change', function () {
//         if (this.value) {
//             loadStates(this.value);
//         } else {
//             stateSelect.innerHTML = '<product value="">Select State</product>';
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