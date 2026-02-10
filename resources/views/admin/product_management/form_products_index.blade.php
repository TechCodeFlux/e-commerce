@extends('admin.components.app')
@section('page-title','Product Form')
@section('content')
<div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">
                        <i class="bi bi-globe2 small me-2"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-people-fill small me-2"></i>Products</li>
            </ol>
        </nav>
    </div>
 

<div class="container mt-4">

    <div class="card mb-4 shadow-sm">
        <div class="card-body">

           <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb d-flex gap-3">
               
                <li class="breadcrumb-item">
                    <a class="list-group-item-primary px-sm-4 border p-2 d-inline-block" href="{{ route('admin.product_management.form_products_index') }}">
                        Product Details 
                    </a>
                </li>
                <li class="list-group-item-dark px-sm-4 border p-2 d-inline-block" >Varient Details</li>
            </ol>
        </nav>
    </div>
            

            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <form class="productForm"
                     action="{{ route('admin.product_management.add_products') }}"
                     method="POST"
                    enctype="multipart/form-data"
                    autocomplete="off">
                        @csrf
                        
                        {{-- Row 1: Name, Category, Description --}}
                        <div class="row justify-content-center">
                            {{-- product-Name --}}
                            <!-- Increased width to col-md-6 -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Name" >
                                        @error('name')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div> 
                                    
                            {{-- category --}}
                            <!-- Increased width to col-md-6 -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Categories</label>
                                        <select name="category" id="category" class="form-select">
                                            
                                            <option value="">Select Category</option>
                                        
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->name }}
                                                    
                                                </option>
                                                
                                            @endforeach
                                            
                                        </select>
                                        @error('category')
                                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                            {{-- category --}}

                            {{-- ---Option (Commented out) --- --}}
                                    {{-- <div class="col-md-6 mb-3">
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
                                    </div> --}}
                            {{-- ---Option--- --}}

                            {{-- ---Description--- --}}
                            <!-- Increased width to col-md-12 (Full Width) -->
                                    <div class="col-md-12 mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" class="form-control" ></textarea>
                                            @error('description')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                            @enderror
                                    </div> 
                            {{-- ---Description--- --}}

                        </div>

                        {{-- Row 2: Image & Status --}}
                         <div class="row ">
                            {{---image---}}
                            <!-- Increased width to col-md-6 -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Image</label>
                                {{-- Pre-View image --}}
                                        <div class="mt-3 ">
                                            <img id="imagePreview" 
                                                src="{{ isset($product) && $product->image ? asset('storage/' . $product->image) : '#' }}"
                                                alt="Image Preview" 
                                                class="col-7 d-none img-fluid w-25">
                                        </div>
                                {{-- end-pre -View image --}}
                                <input type="file"
                                 name="image" 
                                 class="form-control swal2-radio"
                                 id="imageInput" 
                                 accept="image/*"
                                 onchange="previewImage(event)">
                                        
                                @error('image')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                           
                       
                        
                            {{-- ----status---- --}}
                         <!-- Increased width to col-md-6 -->
                            <div class="col-md-6 mb-3 mt-5 w-25 m-auto mt-lg-3">
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
                        <div class="text-center mt-3 w-25 ms-sm-auto">
                           <button type="submit" class="btn btn-primary px-5"> {{ $product->id ? 'Update' : 'Next' }}</button>
                        </div>

                    </form>
                    

                </div>
            </div>

        </div>
    </div>

</div>

@section('script')
<script>
$('.productForm').on('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);
       formData.append('_token', '{{ csrf_token() }}');
    $.ajax({
        url: "{{ route('admin.product_management.add_products') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,

       success: function (response) {

            // 🔹 Convert FormData → Object (for localStorage)
            let formObject = {};
            formData.forEach((value, key) => {
                formObject[key] = value;
            });

            // 🔹 Save form data temporarily
            localStorage.setItem('productForm', JSON.stringify(formObject));
           

            // 🔹 Redirect to Variant page
            window.location.href =
                "{{ route('admin.varient_management.generate_varient') }}" 
        },

        error: function (xhr) {
            if (xhr.status === 422) {
                $('.text-danger').remove();

                let errors = xhr.responseJSON.errors;
                $.each(errors, function (field, messages) {
                    $('[name="' + field + '"]')
                        .after('<small class="text-danger d-block mt-1">' + messages[0] + '</small>');
                });
            }
        }
    });
});




$(document).ready(function () {

    let savedData = localStorage.getItem('productForm');

    if (savedData) {
        let data = JSON.parse(savedData);

        $.each(data, function (key, value) {
            let field = $('[name="' + key + '"]');

            if (!field.length) return;

            if (field.attr('type') === 'checkbox') {
                field.prop('checked', value == 1);
            } else {
                field.val(value);
            }
        });
    }

});
































































// $('.productForm').on('submit', function (e) {
//     e.preventDefault();

//     let formData = new FormData(this);

//     $.ajax({
//         url: "{{ route('admin.product_management.add_products') }}",
//         type: "POST",
//         data: formData,
//         processData: false,
//         contentType: false,

//        success: function (response) {

//             // 🔹 Convert FormData → Object (for localStorage)
//             let formObject = {};
//             formData.forEach((value, key) => {
//                 formObject[key] = value;
//             });

//             // 🔹 Save form data temporarily
//             localStorage.setItem('productForm', JSON.stringify(formObject));
           

//             // 🔹 Redirect to Variant page
//             window.location.href =
//                 "{{ route('admin.varient_management.generate_varient') }}" 
//         },

//         error: function (xhr) {
//             if (xhr.status === 422) {
//                 $('.text-danger').remove();

//                 let errors = xhr.responseJSON.errors;
//                 $.each(errors, function (field, messages) {
//                     $('[name="' + field + '"]')
//                         .after('<small class="text-danger d-block mt-1">' + messages[0] + '</small>');
//                 });
//             }
//         }
//     });
// });




// $(document).ready(function () {

//     let savedData = localStorage.getItem('productForm');

//     if (savedData) {
//         let data = JSON.parse(savedData);

//         $.each(data, function (key, value) {
//             let field = $('[name="' + key + '"]');

//             if (!field.length) return;

//             if (field.attr('type') === 'checkbox') {
//                 field.prop('checked', value == 1);
//             } else {
//                 field.val(value);
//             }
//         });
//     }

// });








































//     error: function (xhr) {
//         if (xhr.status === 422) {
//             let errors = xhr.responseJSON.errors;

//             $.each(errors, function (field, messages) {
//                 let input = $('[name="' + field + '"]');

//                 if (input.length) {
//                     input.after(
//                         '<small class="text-danger d-block mt-1">' +
//                         messages[0] +
//                         '</small>'
//                     );
//                 }
//             });
//         }
//     },

//     complete: function () {
//         // ✅ ALWAYS runs (success or error)
//         $('button[type=submit]')
//             .prop('disabled', false)
//             .text('Next');
//     }
// });
//     });

// });








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
         const file = event.target.files[0];

        if (file) {
        imagePreview.src = URL.createObjectURL(file);
        imagePreview.classList.remove('d-none'); // show image
        }

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
</script>
@endsection
@endsection