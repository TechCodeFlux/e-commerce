@extends('admin.components.app')
@section('page-title','Variant Form')
@section('content')

<div class="container mt-4">
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="mb-4">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb d-flex gap-3">
                        <li class="list-group-item-dark px-sm-4 border p-2 d-inline-block bg-teal">Product Details</li>
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
                        
                        {{-- Added align-items-end to align button with inputs --}}
                      <div class="row align-items-end">
    <div class="col-md-5 mb-3">
        <label class="form-label">Color (Hold Ctrl to select multiple)</label>
        <select name="option_color[]" id="option_color" class="form-select" multiple>
            @foreach($options->unique('color') as $option)
                <option value="{{ $option->color }}">{{ $option->color }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-5 mb-3">
        <label class="form-label">Size (Hold Ctrl to select multiple)</label>
        <select name="option_size[]" id="option_size" class="form-select" multiple>
            @foreach($options->unique('size') as $option)
                <option value="{{ $option->size }}">{{ $option->size }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2 mb-3">
        <button type="button" id="btn-generate-matrix" class="btn btn-secondary w-100">
            Generate
        </button>
    </div>
</div>

<div id="variant-matrix-container" class="mt-4"></div>

                            {{-- Generate Button --}}
                            {{-- Removed 'card-body' class from here to fix alignment padding issues --}}
                            <div class="col-md-2 mb-3">
                                <button type="submit" id="btn-generate-matrix" class="btn btn-secondary w-100">
                                    Generate
                                </button>
                            </div>
                        </div> 
                        <div id="variant-matrix-container" class="mt-4"></div>

                        {{-- Footer Buttons --}}
                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <button type="submit" form="previous-form" class="btn btn-secondary px-5 p-md-2">
                                Previous
                            </button> 

                            <button type="submit" class="btn btn-primary px-5 p-md-2">
                                {{$varient->id ?? '' ? 'Update' : 'Submit' }}
                            </button> 
                        </div>        
                    </form>
                    
                </div>
                
                <form id="previous-form" method="get" action="{{ route('admin.product_management.form_products_index') }}" class="previous-form d-none">
                </form>
            </div>
        </div>
    </div>
</div>

@section('script')
<script>

    
$(document).ready(function() {
    $('#btn-generate-matrix').on('click', function() {
        const colors = $('#option_color').val(); // Array of selected colors
        const sizes = $('#option_size').val();   // Array of selected sizes

        if (!colors.length || !sizes.length) {
            alert('Please select at least one Color and one Size.');
            return;
        }

        let tableHtml = `
            <table class="table table-bordered bg-white shadow-sm">
                <thead class="table-light">
                    <tr>
                        <th>Color</th>
                        <th>Size</th>
                        <th style="width: 200px;">Stock</th>
                    </tr>
                </thead>
                <tbody>`;

        colors.forEach(function(color) {
            sizes.forEach(function(size) {
                tableHtml += `
                    <tr>
                        <td>
                            <input type="hidden" name="variants[${color}_${size}][color]" value="${color}">
                            ${color}
                        </td>
                        <td>
                            <input type="hidden" name="variants[${color}_${size}][size]" value="${size}">
                            ${size}
                        </td>
                        <td>
                            <input type="number" name="variants[${color}_${size}][stock]" 
                                   class="form-control" placeholder="0" min="0" required>
                        </td>
                    </tr>`;
            });
        });

        tableHtml += `</tbody></table>`;
        $('#variant-matrix-container').html(tableHtml);
    });
});












// $(document).ready(function() {
//     // ✅ RESTORE FORM DATA ON PAGE LOAD
//     const savedData = localStorage.getItem('varientForm');
//     if (savedData) {
//         const formData = JSON.parse(savedData);
//         // Fixed selectors to match new names
//         $('.VarientForm select[name="option_size"]').val(formData.size || '');
//         $('.VarientForm select[name="option_color"]').val(formData.color || '');
//         $('.VarientForm input[name="stock"]').val(formData.stock || '');
            
//         const statusSwitch = $('#statusSwitch');
//         if (formData.status === '1' || formData.status === 1) {
//             statusSwitch.prop('checked', true);
//             $('#statusLabel').text('Active');
//         }
//     }

//     // ✅ SAVE FORM DATA BEFORE PREVIOUS BUTTON CLICK
//     $('.previous-form').on('submit', function(e) {
//         saveFormData();
//     });

//     function saveFormData() {
//         const formData = {
//             // Updated selectors to get value from SELECT inputs, not text inputs
//             size: $('.VarientForm select[name="option_size"]').val(),
//             color: $('.VarientForm select[name="option_color"]').val(),
//             stock: $('.VarientForm input[name="stock"]').val(),
//             status: $('#statusSwitch').is(':checked') ? '1' : '0'
//         };
//         localStorage.setItem('varientForm', JSON.stringify(formData));
//     }

//     // ✅ ORIGINAL FORM SUBMIT
//     $('.VarientForm').on('submit', function (e) {
//         e.preventDefault();
//         let formData = new FormData(this);
//         formData.append('_token', '{{ csrf_token() }}');

//         $.ajax({
//             url: "{{ route('admin.varient_management.add_varient') }}",
//             type: "POST",
//             data: formData,
//             processData: false,
//             contentType: false,
//             success: function (response) {
//                 localStorage.removeItem('varientForm'); 
//                 localStorage.removeItem('productForm');
//                 alert(response.message);
//                 window.location.href ="{{ route('admin.product_management.form_products_index') }}";
//             },
//             error: function (xhr) {
//                 if (xhr.status === 422) {
//                     $('.text-danger').remove();
//                     let errors = xhr.responseJSON.errors;
//                     $.each(errors, function (field, messages) {
//                         $('[name="' + field + '"]')
//                             .after(
//                                 '<small class="text-danger d-block mt-1">' +
//                                 messages[0] +
//                                 '</small>'
//                             );
//                     });
//                 }
//             }
//         });
//     });

//     // ✅ STATUS TOGGLE
//     document.addEventListener('DOMContentLoaded', function () {
//         const statusSwitch = document.getElementById('statusSwitch');
//         const statusLabel = document.getElementById('statusLabel');
//         if (statusSwitch) {
//             statusSwitch.addEventListener('change', function () {
//                 statusLabel.innerText = this.checked ? 'Active' : 'Inactive';
//                 saveFormData(); 
//             });
//         }
//     });

//     $(document).on('change', '.toggle-status', function () {
//         let varientId = $(this).data('id');
//         let status = $(this).is(':checked') ? 1 : 0;
//         $.ajax({
//             url: "{{ route('admin.varient_management.change-status') }}",
//             type: "POST",
//             data: {
//                 _token: "{{ csrf_token() }}",
//                 id: varientId,
//                 status: status
//             },
//         });
//     });
// });
// </script>
 @endsection
 @endsection