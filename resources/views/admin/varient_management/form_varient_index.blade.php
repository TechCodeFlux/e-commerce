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
                                @error('size')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>     

                             <div class="col-md-4 mb-3">
                                <label class="form-label">Color</label>
                                <input type="text" name="color" class="form-control" placeholder="Color" 
                                    value="{{ old('color') }}">
                                @error('color')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div> 

                             <div class="col-md-4 mb-3">
                                <label class="form-label">Stock</label>
                                <input type="text" name="stock" class="form-control" placeholder="Stock" 
                                value="{{ old('stock') }}">
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
                                         data-id="{{$varient->id ?? '' }}" {{ $varient->status ?? old('status', 1) ? 'checked' : '' }}
                                        type="checkbox"
                                        name="status"
                                        id="statusSwitch"
                                        value="1"   
                                    >
                                    <label class="form-check-label" for="statusSwitch" id="statusLabel">
                                        {{ $varient->status ?? old('status', 1) ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-3 w-25 ms-sm-auto">
                            <button type="submit" class="btn btn-primary px-5">
                                {{$varient->id ?? '' ? 'Update' : 'Submit' }}
                            </button> 
                        </div>         
                    </form>
                    
                </div>
                
                {{-- Previous Button - Now preserves form data --}}
                <form method="get" action="{{ route('admin.product_management.form_products_index') }}" class="previous-form">
                    <div class="text-center mt-3 w-25 ms-sm-auto">
                        <button type="submit" class="btn btn-secondary px-5">
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
$(document).ready(function() {
    // ✅ RESTORE FORM DATA ON PAGE LOAD (from localStorage)
    const savedData = localStorage.getItem('varientForm');
    if (savedData) {
        const formData = JSON.parse(savedData);
        $('.VarientForm input[name="size"]').val(formData.size || '');
        $('.VarientForm input[name="color"]').val(formData.color || '');
        $('.VarientForm input[name="stock"]').val(formData.stock || '');
            
        // Restore status toggle
        const statusSwitch = $('#statusSwitch');
        if (formData.status === '1' || formData.status === 1) {
            statusSwitch.prop('checked', true);
            $('#statusLabel').text('Active');
        }
    }

    // ✅ SAVE FORM DATA ON ANY INPUT CHANGE (before Previous button)
    $('.VarientForm input, .VarientForm select, .VarientForm textarea').on('input change', function() {
        saveFormData();
    });

    // ✅ SAVE FORM DATA BEFORE PREVIOUS BUTTON CLICK
    $('.previous-form').on('submit', function(e) {
        saveFormData();
    });

    function saveFormData() {
        const formData = {
            size: $('.VarientForm input[name="size"]').val(),
            color: $('.VarientForm input[name="color"]').val(),
            stock: $('.VarientForm input[name="stock"]').val(),
            status: $('#statusSwitch').is(':checked') ? '1' : '0'
        };
        localStorage.setItem('varientForm', JSON.stringify(formData));
    }

    // ✅ ORIGINAL FORM SUBMIT (unchanged)
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
                localStorage.removeItem('varientForm'); // ✅ CLEAR ON SUCCESS
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

    // ✅ STATUS TOGGLE (unchanged)
    document.addEventListener('DOMContentLoaded', function () {
        const statusSwitch = document.getElementById('statusSwitch');
        const statusLabel = document.getElementById('statusLabel');
        if (statusSwitch) {
            statusSwitch.addEventListener('change', function () {
                statusLabel.innerText = this.checked ? 'Active' : 'Inactive';
                saveFormData(); // ✅ SAVE STATUS CHANGE
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
});
</script>
@endsection
@endsection
