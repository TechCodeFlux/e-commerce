
@extends('admin.components.app')
@section('page-title','varient Form')
@section('content')

<div class="container mt-4">

    <div class="card mb-4 shadow-sm">
        <div class="card-body">

             <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb d-flex gap-3">
                <li class="list-group-item-dark px-sm-4 border p-2 d-inline-block" >Product Details</li>

                 <li class="breadcrumb-item">
                    <a class="list-group-item-primary px-sm-4 border p-2 d-inline-block" href="{{ route('admin.varient_management.form_varient_index') }}">
                        Varient Details 
                    </a>
                </li>
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

                    <form class="VarientForm" enctype="multipart/form-data">
                            @csrf
                        
                       
                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Size</label>
                                <input type="text" name="size" class="form-control" placeholder="Size"  
                                    >
                                 {{-- <input type="hidden" name="product_id" value="{{ $product->id }}">  --}}

                                @error('size')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>     

                             <div class="col-md-4 mb-3">
                                <label class="form-label">Color</label>
                                <input type="text" name="color" class="form-control" placeholder="Color" 
                                    >
                                @error('color')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div> 

                             <div class="col-md-4 mb-3">
                                <label class="form-label">Stock</label>
                                <input type="text" name="stock" class="form-control" placeholder="Stock" 
                                >
                                @error('stock')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div> 

                            <div class="col-md-6 mb-3 mt-3 mt-5 w-25 m-lg-0 mx-lg-4 m-lg-2 ">
                                <label class="form-label d-block ">Status</label>

                                <input type="hidden" name="status" value="0">

                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input toggle-status"
                                         data-id="{{$varient->id }}" {{ $varient->status ? 'checked' : '' }}
                                        type="checkbox"
                                        name="status"
                                        id="statusSwitch"
                                        value="1"   
                                        {{ old('status', $varient->status ?? 1) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="statusSwitch" id="statusLabel">
                                        {{ old('status', $varient->status ?? 1) ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </div>

                        </div>

                         

                        <div class="text-center mt-3 w-25 ms-sm-auto">
                            <button type="submit" class="btn btn-primary px-5">
                                {{$varient->id ? 'Update' : 'Submit' }}
                            </button> 
                        </div>

                    </form>
                    

                </div>
                   <form method="get"  action="{{ route('admin.product_management.form_products_index') }}">
                        <div class="text-center mt-3 w-25 ms-sm-auto">
                            <button type="submit" class="btn btn-primary px-5">
                                Previous
                            </button> 
                        </div>
                    </form>
            </div>

        </div>
    </div>

</div>

@section('script')
<script>
$('.VarientForm').on('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "{{ route('admin.varient_management.add_varient') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,

        success: function (response) {
              // ✅ CLEAR TEMP PRODUCT DATA
            localStorage.removeItem('productForm');
            alert(response.message);
            window.location.href ="{{ route('admin.product_management.form_products_index') }}";
        },

        error: function (xhr) {
            if (xhr.status === 422) {
                $('.text-danger').remove();

                let errors = xhr.responseJSON.errors;
                $.each(errors, function (field, messages) {
                    $('[name="' + field + '"]')
                        .after(
                            '<small class="text-danger d-block mt-1">' +
                            messages[0] +
                            '</small>'
                        );
                });
            }
        }
    });
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

    let varientId = $(this).data('id');
    let status = $(this).is(':checked') ? 1 : 0;

     $.ajax({
        url: "{{ route('admin.varient_management.change-status') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: varientId,
            status: status
        },
    });
});


// document.addEventListener('DOMContentLoaded', function () {

//     const countrySelect = document.getElementById('country');
//     const stateSelect   = document.getElementById('state');
;

//     function loadStates(countryId) {
//         stateSelect.innerHTML = '<varient value="">Loading...</varient>';

//        fetch(`/admin/get-states/${countryId}`)
//     .then(response => {
//         if (!response.ok) {
//             throw new Error('Network error');
//         }
//         return response.json();
//     })
//     .then(states => {
//         stateSelect.innerHTML = '<varient value="">Select State</varient>';
//         states.forEach(state => {
//             stateSelect.innerHTML +=
//                 `<varient value="${state.id}">${state.name}</varient>`;
//         });
//     })
//     .catch(error => {
//         console.error(error);
//         stateSelect.innerHTML = '<varient value="">Failed to load states</varient>';
//     });

//     }

//     countrySelect.addEventListener('change', function () {
//         if (this.value) {
//             loadStates(this.value);
//         } else {
//             stateSelect.innerHTML = '<varient value="">Select State</varient>';
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