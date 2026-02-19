@extends('admin.components.app')
@section('page-title','Varient Form')
@section('content')

<div class="container mt-4">
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
             <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb d-flex gap-3">
                <li class="list-group-item-dark px-sm-4 border p-2 d-inline-block bg-teal" >Product Details</li>
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
                <div class="col-lg-12 ">

                    <form class="VarientForm" enctype="multipart/form-data">
                            @csrf
                        
                        <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Color</label>

                                    <!-- Fake Select (Button styled as form-select) -->
                                    {{-- <select  multiple="multiple">
                                            <option value="AL">Alabama</option>
                                             <option value="WY">Wyoming</option>
                                    </select> --}}
                                    <select name="color[]" id="color"  class="js-example-basic-multiple" multiple="multiple">
                                            
                                            <option value="">Select Color</option>
                                        
                                            @foreach($optioncolorvalues as $optionvalue)
                                                <option value="{{ $optionvalue->id }}">
                                                    {{  ucfirst($optionvalue->name)  }}
                                                    
                                                </option>
                                                
                                            @endforeach
                                            
                                        </select>

                                    <!-- Hidden input to submit values -->
                                    <input type="hidden" name="option" id="selectedOptions">

                                    @error('option')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>

                            {{-- <div class="col-md-4 mb-3">
                                <label class="form-label">Size</label>
                                <input type="text" name="size" class="form-control" placeholder="Size"  
                                    >
                                @error('size')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>      --}}

                             <div class="col-md-4 mb-3">
                                <label class="form-label">Size</label>
                                <select name="size[]" id="size"  class="js-example-basic-multiple" multiple="multiple">
                                            
                                            <option value="">Select Size</option>
                                        
                                            @foreach($optionsizevalues as $optionvalue)
                                                <option style="text-transform: lowercase;" value="{{ $optionvalue->id }}">
                                                    {{  ucfirst($optionvalue->name) }}
                                                    
                                                </option>
                                                
                                            @endforeach
                                            
                                        </select>

                                @error('color')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div> 

                            
                        </div>

                        {{-- CHANGED: Combined Button Container using Bootstrap d-flex --}}
                        <div class="d-flex justify-content-end gap-3 mt-4">
                            
                            {{-- Previous Button: Linked to external form via form attribute --}}
                            <button type="submit" form="previous-form" class="btn btn-secondary px-5 p-md-2">
                                Previous
                            </button> 

                            {{-- Submit Button --}}
                            <button type="submit" class="btn btn-primary px-5 p-md-2">
                                {{$varient->id ?? '' ? 'Update' : 'Submit' }}
                            </button> 
                        </div>        
                    </form>
                    
                </div>
                
                {{-- Previous Form: Hidden shell that handles the logic --}}
                <form id="previous-form" method="get" action="{{ route('admin.product_management.form_products_index') }}" class="previous-form d-none">
                    {{-- Button moved inside the main form group above for alignment --}}
                </form>
            </div>
        </div>
    </div>
</div>

@section('script')
<script>


$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});




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
        formData.append('_token', '{{ csrf_token() }}');

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


document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.option-checkbox');
    const dropdownBtn = document.getElementById('multiSelectDropdown');
    const hiddenInput = document.getElementById('selectedOptions');

    checkboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            let selectedNames = [];
            let selectedIds = [];

            checkboxes.forEach(c => {
                if (c.checked) {
                    selectedNames.push(c.dataset.name);
                    selectedIds.push(c.value);
                }
            });

            dropdownBtn.textContent = selectedNames.length
                ? selectedNames.join(', ')
                : 'Select Option';

            hiddenInput.value = selectedIds.join(',');
        });
    });
});
</script>
@endsection
@endsection