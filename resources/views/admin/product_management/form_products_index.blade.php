@extends('admin.components.app')
@section('page-title', $product->id ? 'Edit Product form' : ' Product Form')
@section('content')
<div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">
                        <i class="bi bi-globe2 small me-2"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-collection small me-2 "></i>Products</li>
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
                    <a class="list-group-item-primary px-sm-4 border p-2 d-inline-block " href="{{ route('admin.product_management.form_products_index') }}">
                         Product Details 
                    </a>
                </li>
                <li class="list-group-item-dark px-sm-4 border p-2 d-inline-block" >Varient Details</li>
            </ol>
        </nav>
    </div>
            

          
            <div class="row justify-content-center">
                <div class="col-lg-12">

            <form class="productForm"
                   action="{{ isset($product->id) 
                          ? route('admin.product_management.edit_product', $product->id) 
                          : route('admin.product_management.add_products') }}"
                    method="POST"
                    {{-- enctype="multipart/form-data"    --}}
                    autocomplete="off">
                    @csrf
                       @if(isset($product->id))
                             @method('PUT')
                          @endif
                        
                        {{-- Row 1: Name, Category, Description --}}
                        <div class="row justify-content-center">
                            {{-- product-Name --}}
                            <!-- Increased width to col-md-6 -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Name</label>
                                            <input type="text" 
                                                    name="name" 
                                                    class="form-control" 
                                                    placeholder="Name"
                                                    value="{{ old('name', $product->name ?? '') }}">
                                        @error('name')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div> 
                                    
                            {{-- category --}}
                            <!-- Increased width to col-md-6 -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Category</label>
                                       <select name="category" id="category" class="form-select">
                                            <option value="">Select Category</option>

                                           @foreach($categories as $category)
                                                @if($category->status == 1)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('category')
                                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                            {{-- category --}}

                            {{-- ---Description--- --}}
                            <!-- Increased width to col-md-12 (Full Width) -->
                                    <div class="col-md-12 mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
                                            @error('description')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                            @enderror
                                    </div> 
                            {{-- ---Description--- --}}

                        </div>

                        {{-- Row 2: Image & Status --}}
                     <div class="row ">
                            
                         <!-- Increased width to col-md-6 -->
                            <div class="col-md-6 mb-3 mt-5 w-25 m-auto m-lg-1">
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
                           <button type="submit" class="btn btn-primary px-5"> {{ $product->id ? 'Next' : 'Next' }}</button>
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

    e.preventDefault(); // prevent page reload

    let formData = new FormData(this);
    formData.append('_token', '{{ csrf_token() }}');

    @if(isset($product->id))
        var url = "{{ route('admin.product_management.edit_product', $product->id) }}";
        formData.append('_method', 'PUT');
    @else
        var url = "{{ route('admin.product_management.add_products') }}";
    @endif

    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,

        success: function (response) {

    @if(!isset($product->id))
        let formObject = {};
        formData.forEach((value, key) => {
            formObject[key] = value;
        });

        localStorage.setItem('productForm', JSON.stringify(formObject));

        window.location.href =
            "{{ route('admin.varient_management.generate_varient') }}";

    @else
       window.location.href ="{{ route('admin.varient_management.edit_varient_generator', $product->id ?? ':id') }}".replace(':id', response.id);
    @endif
},

        error: function(xhr) {

            if (xhr.status === 422) {

                let errors = xhr.responseJSON.errors;

                // remove old errors
                $('.text-danger').remove();

                $.each(errors, function (key, value) {

                    let field = $('[name="' + key + '"]');

                    field.after(
                        '<small class="text-danger d-block mt-1">' + value[0] + '</small>'
                    );
                });

            }
        }
    });

});


$(document).on('input change', '.productForm input, .productForm textarea, .productForm select', function () {

    let error = $(this).next('.text-danger');
    if (error.length) {
        error.fadeOut(200, function() {
            $(this).remove();
        });
    }

});





$(document).ready(function () {

   @if(!isset($product->id))
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
      @endif

});








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
</script>
@endsection
@endsection