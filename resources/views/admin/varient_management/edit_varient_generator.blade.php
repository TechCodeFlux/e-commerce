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
                        action="{{ route('admin.varient_management.edit_varient', $product->id) }}"  
                        enctype="multipart/form-data">
                        @csrf
                        @if($product->id)
                            @method('PUT')
                        @endif
                        
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

                           <button type="submit"
                                id="submitBtn"
                                class="btn btn-primary px-5 p-md-2 d-none">
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

let existingVariants = @json($product->varients ?? []);

$(document).ready(function () {
    if (existingVariants.length > 0) {

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

    existingVariants.forEach(function(item, index){

        table += `
            <tr>
                <td>
                    <input type="text"
                        name="variants[${index}][color]"
                        value="${item.color.toUpperCase()}"
                        class="border-0 text-center"
                        readonly>
                </td>

                <td>
                    <input type="text"
                        name="variants[${index}][size]"
                        value="${item.size.toUpperCase()}"
                        class="border-0 text-center"
                        readonly>
                </td>

                <td>
                    <input type="number"
                        name="variants[${index}][stock]"
                        value="${item.stock}"
                        class="form-control text-center"
                        min="0"
                        required>
                </td>

                <td>
                    <button type="button"
                        class="btn btn-sm btn-outline-danger delete-club-member">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        `;
    });

    table += `
                    </tbody>
                </table>
            </div>
        </div>
    `;

    $('#variant-matrix-container').html(table);
    $('#submitBtn').removeClass('d-none');
}});








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
            if ($('#variant-matrix-container tbody tr').length > 0) {
    $('#submitBtn').removeClass('d-none');
}
        });

    
    $(document).on('click', '.delete-club-member', function () {

    $(this).closest('tr').remove();

    reIndexVariants();

    // If no rows left → clear storage
    if ($('#variant-matrix-container tbody tr').length === 0) {
        localStorage.removeItem(STORAGE_KEY);
         $('#submitBtn').addClass('d-none');
        
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
             if ($('#variant-matrix-container tbody tr').length > 0) {
              $('#submitBtn').removeClass('d-none');
    }
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








// </script>
 @endsection
 @endsection