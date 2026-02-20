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

                    <form  class="VarientForm" 
                        method="POST" 
                        action="{{ route('admin.varient_management.add_varient') }}" 
                        enctype="multipart/form-data">
                        @csrf
                        
                        {{-- Added align-items-end to align button with inputs --}}
                      <div class="row align-items-end">
                         {{-- color-input --}}
                           <div class="col-md-5 mb-3">
                               <label class="form-label">Color</label>
                                  <select name="color[]" id="color"  class="js-example-basic-multiple" multiple="multiple">
                                            
                                            <option value="">Select Color</option>
                                        
                                            @foreach($optioncolorvalues as $optionvalue)
                                                <option value="{{ $optionvalue->id }}">
                                                    {{  ucfirst($optionvalue->name)  }}
                                                    
                                                </option>
                                                
                                            @endforeach
                                            
                                        </select>
                            </div>
                                    {{-- size-input --}}
                             <div class="col-md-5 mb-3">
                                    <label class="form-label">Size </label>
                                         <select name="size[]" id="size"  class="js-example-basic-multiple " multiple="multiple">
                                            
                                            <option value="">Select Size</option>
                                        
                                            @foreach($optionsizevalues as $optionvalue)
                                                <option  value="{{ $optionvalue->id }}">
                                                    {{  ucfirst($optionvalue->name) }}
                                                    
                                                </option>
                                                
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
                           
                        </div> 
                        

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
    $('.js-example-basic-multiple').select2();
    $('#color, #size').on('change', function () {
    $(this).next('.select2-container').find('.select2-selection')
        .removeClass('is-invalid');
    $(this).next('.select2-container')
        .siblings('.select-error').remove();
});
});



const STORAGE_KEY = "variant_matrix_data";
function saveVariantData() {

        const colors = $('#color').val();
        const sizes  = $('#size').val();
        const tableHtml = $('#variant-matrix-container').html();

        const data = {
            colors: colors,
            sizes: sizes,
            tableHtml: tableHtml
        };

        localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
    }

    // ✅ CLEAR STORAGE AFTER FINAL SUBMIT
    $('.VarientForm').on('submit', function () {
        localStorage.removeItem(STORAGE_KEY);
         localStorage.removeItem('productForm');
    });



  $(document).ready(function () {

        $('.js-example-basic-multiple').select2();

        $('#btn-generate-matrix').on('click', function () {

            const colors = $('#color option:selected');
            const sizes  = $('#size option:selected');







            // Validation
           $('.select-error').remove();
$('#color, #size').removeClass('is-invalid');

let hasError = false;

if (colors.length === 0) {
    $('#color').next('.select2-container').find('.select2-selection')
        .addClass('is-invalid');

    $('#color').next('.select2-container')
        .after('<div class="text-danger select-error mt-1">Please select at least one Color</div>');

    hasError = true;
}

if (sizes.length === 0) {
    $('#size').next('.select2-container').find('.select2-selection')
        .addClass('is-invalid');

    $('#size').next('.select2-container')
        .after('<div class="text-danger select-error mt-1">Please select at least one Size</div>');

    hasError = true;
}

if (hasError) {
    return;
}





            let table = `
                <div class="card shadow-sm">
                    <div class="card-body">
                      

                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Color</th>
                                    <th>Size</th>
                                    <th>Stock</th>
                                     <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
            `;

            let index = 0;

            colors.each(function () {
                const colorId   = $(this).val();
                const colorName = $(this).text().trim();    

                sizes.each(function () {
                    const sizeId   = $(this).val();
                    const sizeName = $(this).text().trim();

                    table += `
                        <tr>
                            <td class="col-2">
                               <input type="text" name="variants[${index}][color]" value="${colorName.toUpperCase()}"  class="border-0 text-center" readonly> 
                               
                            </td>

                            <td class="col-2">
                                 <input type="text" name="variants[${index}][size]" value="${sizeName.toUpperCase()}"  class="border-0 text-center" readonly> 
                                
                            </td>

                            <td class="col-2">
                                <input 
                                    type="number" 
                                    name="variants[${index}][stock]" 
                                    class="form-control text-center" 
                                    min="0"
                                    required
                                >
                            </td>
                             <td class="col-2">
                               <button 
                                 type="button"
                                 class=" btn btn-sm btn-outline-danger delete-club-member"
                                
                                 title="Delete">
                                                              <i class="fas fa-trash-alt"></i>
                            </button>
                            </td>
                        </tr>
                    `;
                    index++;
                });
            });

            table += `
                            </tbody>
                        </table>
                    </div>
                </div>
            `;

            $('#variant-matrix-container').html(table);
        });

    
    $(document).on('click', '.delete-club-member', function () {

    $(this).closest('tr').remove();

    reIndexVariants();

    // If no rows left → clear storage
    if ($('#variant-matrix-container tbody tr').length === 0) {
        localStorage.removeItem(STORAGE_KEY);
        
    } else {
        saveVariantData();
    }
});


   function reIndexVariants() {

    
    $('#variant-matrix-container tbody tr').each(function (index) {

        // Update color input
        $(this).find('input[name*="[color]"]')
            .attr('name', `variants[${index}][color]`);

        // Update size input
        $(this).find('input[name*="[size]"]')
            .attr('name', `variants[${index}][size]`);

        // Update stock input
        $(this).find('input[name*="[stock]"]')
            .attr('name', `variants[${index}][stock]`);
    });
}

    });




$(document).ready(function () {

    const STORAGE_KEY = "variant_matrix_data";

    // ✅ RESTORE DATA ON PAGE LOAD
    const saved = localStorage.getItem(STORAGE_KEY);
    if (saved) {
        const data = JSON.parse(saved);

        // Restore Select2 values
        if (data.colors) {
            $('#color').val(data.colors).trigger('change');
        }

        if (data.sizes) {
            $('#size').val(data.sizes).trigger('change');
        }

        // Restore table
        if (data.tableHtml) {
            $('#variant-matrix-container').html(data.tableHtml);
        }
    }

    // ✅ SAVE WHEN GENERATE BUTTON CLICKED
    $('#btn-generate-matrix').on('click', function () {

        setTimeout(function () {
            saveVariantData();
        }, 200); // wait for table render

    });

    // ✅ SAVE WHEN STOCK VALUE CHANGES
    $(document).on('input', 'input[name*="[stock]"]', function () {
        saveVariantData();
    });

    // ✅ FUNCTION TO SAVE
    

});







// $(document).ready(function() {
//     // ✅ RESTORE FORM DATA ON PAGE LOAD
//     const savedData = localStorage.getItem('varientForm');
//     if (savedData) {
//         const formData = JSON.parse(savedData);
//         // Fixed selectors to match new names
//         $('.VarientForm select[name="size[]"]').val(formData.size || '');
//         $('.VarientForm select[name="color[]"]').val(formData.color || '');
            
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
//             size: $('.VarientForm select[name="size[]"]').val(),
//             color: $('.VarientForm select[name="color[]"]').val(),

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





// $(document).ready(function () {

//     $('#btn-generate-matrix').on('click', function () {

//         let colorValue = $('#option_color').val(); // "red,white"
//         let sizeValue  = $('#option_size').val();  // "S,M,L"

//         if (!colorValue || !sizeValue) {
//             alert('Please select Color and Size');
//             return;
//         }

//         let colors = colorValue.split(',').map(c => c.trim());
//         let sizes  = sizeValue.split(',').map(s => s.trim());

//         let html = `
//             <table class="table table-bordered mt-3">
//                 <thead class="table-light text-sm-center">
//                     <tr>
//                         <th>Color</th>
//                         <th>Size</th>
//                         <th>Stock</th>
//                         <th>Action</th>
//                     </tr>
//                 </thead>
//                 <tbody>
//         `;

//         let found = false;

//         EXISTING_VARIANTS.forEach(function (variant) {

//             if (
//                 colors.includes(variant.color) &&
//                 sizes.includes(variant.size)
//             ) {
//                 found = true;

//                 html += `
//                     <tr>
//                         <td class="text-md-center">
//                             ${variant.color}
//                             <input type="hidden" name="variants[${variant.id}][color]" value="${variant.color}">
//                         </td>
//                         <td class="text-md-center">
//                             ${variant.size}
//                             <input type="hidden" name="variants[${variant.id}][size]" value="${variant.size}">
//                         </td>
//                         <td class="w-25">
//                             <input type="number"
//                                    class="form-control"
//                                    name="variants[${variant.id}][stock]"
//                                    value="${variant.stock}"
//                                    min="0">
//                         </td>
//                          <td class="text-md-center">
//                             <button 
//                                  type="button"
//                                  class="bi-trash-fill btn btn-sm btn-outline-danger delete-club-member"
//                                  onclick="deleteCategory(' . $category->id . ')"
//                                  title="Delete">
//                                                               <i class="fas fa-trash-alt"></i>
//                             </button>
//                         </td>
//                     </tr>
//                 `;
//             }
//         });

//         if (!found) {
//             html += `
//                 <tr>
//                     <td colspan="3" class="text-center text-muted">
//                         No variants found for selected options
//                     </td>
//                 </tr>
//             `;
//         }

//         html += `</tbody></table>`;

//         $('#variant-matrix-container').html(html);
//     });

// });



// </script>
 @endsection
 @endsection