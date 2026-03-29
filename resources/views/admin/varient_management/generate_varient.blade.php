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
                            <a class="list-group-item-primary px-sm-4 border p-2 d-inline-block" href="{{ route('admin.varient_management.generate_varient') }}">
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
$(document).ready(function () {
    $('.js-example-basic-multiple').select2();

    $('#color, #size').on('change', function () {
        $(this).next('.select2-container').find('.select2-selection').removeClass('is-invalid');
        $(this).next('.select2-container').siblings('.select-error').remove();
    });
});

const STORAGE_KEY   = "variant_matrix_data";
const IMAGE_STORE_KEY = "variant_image_store"; // ✅ NEW: separate key for images

// ✅ Save images as base64 alongside table data
function saveImageToStore(index, file) {
    const reader = new FileReader();
    reader.onload = function (e) {
        let imageStore = JSON.parse(localStorage.getItem(IMAGE_STORE_KEY) || '{}');
        imageStore[index] = {
            dataUrl : e.target.result,
            name    : file.name,
            type    : file.type
        };
        localStorage.setItem(IMAGE_STORE_KEY, JSON.stringify(imageStore));
    };
    reader.readAsDataURL(file);
}

function saveVariantData() {
    const colors = $('#color').val();
    const sizes  = $('#size').val();

    $('#variant-matrix-container tbody tr').each(function () {
        const stock = $(this).find('input[name*="[stock]"]').val();
        const price = $(this).find('input[name*="[price]"]').val();
        $(this).find('input[name*="[stock]"]').attr('value', stock);
        $(this).find('input[name*="[price]"]').attr('value', price);
    });

    const tableHtml = $('#variant-matrix-container').html();
    localStorage.setItem(STORAGE_KEY, JSON.stringify({ colors, sizes, tableHtml }));
}

// ✅ Restore a base64 image back into a file input
async function restoreFileInput(index, imageData) {
    try {
        const response = await fetch(imageData.dataUrl);
        const blob     = await response.blob();
        const file     = new File([blob], imageData.name, { type: imageData.type });

        const dt    = new DataTransfer();
        dt.items.add(file);

        const input   = document.getElementById(`image-${index}`);
        const preview = document.getElementById(`preview-${index}`);
        const label   = document.getElementById(`fileName-${index}`);

        if (input) {
            input.files = dt.files; // ✅ Attach real File object

            // Show preview
            if (preview) {
                preview.src = imageData.dataUrl;
                preview.classList.remove('d-none');
                preview.style.display = 'block';
            }
            if (label) label.innerText = imageData.name;

            // Mark as uploaded
            let $input = $(input);
            if ($input.siblings('input[name*="[image_uploaded]"]').length === 0) {
                $input.after(`<input type="hidden" name="variants[${index}][image_uploaded]" value="1">`);
            }
        }
    } catch (err) {
        console.warn(`Could not restore image for index ${index}`, err);
    }
}

$(document).ready(function () {
    $('.js-example-basic-multiple').select2();

    function getExistingVariants() {
        let existingData = {};
        $('#variant-matrix-container tbody tr').each(function () {
            let color = $(this).find('input[name*="[color]"]').val();
            let size  = $(this).find('input[name*="[size]"]').val();
            let stock = $(this).find('input[name*="[stock]"]').val();
            let price = $(this).find('input[name*="[price]"]').val();
            existingData[color + '_' + size] = { stock, price };
        });
        return existingData;
    }

    $('#btn-generate-matrix').on('click', function () {
        const existingVariants = getExistingVariants();
        const colors = $('#color option:selected');
        const sizes  = $('#size option:selected');

        $('.select-error').remove();
        $('#color, #size').removeClass('is-invalid');
        let hasError = false;

        if (colors.length === 0) {
            $('#color').next('.select2-container').find('.select2-selection').addClass('is-invalid');
            $('#color').next('.select2-container').after('<div class="text-danger select-error mt-1">Please select at least one Color</div>');
            hasError = true;
        }
        if (sizes.length === 0) {
            $('#size').next('.select2-container').find('.select2-selection').addClass('is-invalid');
            $('#size').next('.select2-container').after('<div class="text-danger select-error mt-1">Please select at least one Size</div>');
            hasError = true;
        }
        if (hasError) return;

        // ✅ Clear image store when regenerating
        localStorage.removeItem(IMAGE_STORE_KEY);

        let table = `
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Color</th><th>Size</th><th>Stock</th>
                                <th>Price</th><th>Image</th><th>Action</th>
                            </tr>
                        </thead>
                        <tbody>`;

        let index = 0;
        colors.each(function () {
            const colorId   = $(this).val();
            const colorName = $(this).text().trim();
            sizes.each(function () {
                const sizeId   = $(this).val();
                const sizeName = $(this).text().trim();
                let key      = colorName.toUpperCase() + '_' + sizeName.toUpperCase();
                let oldStock = existingVariants[key] ? existingVariants[key].stock : '';
                let oldPrice = existingVariants[key] ? existingVariants[key].price : '';

                table += `
                    <tr>
                        <td><input type="text" name="variants[${index}][color]" value="${colorName.toUpperCase()}" class="border-0 text-center" readonly></td>
                        <td><input type="text" name="variants[${index}][size]"  value="${sizeName.toUpperCase()}"  class="border-0 text-center" readonly></td>
                        <td><input type="number" name="variants[${index}][stock]" value="${oldStock}" class="form-control text-center" min="0" required></td>
                        <td><input type="number" name="variants[${index}][price]" value="${oldPrice}" class="form-control text-center" min="0" required></td>
                        <td class="text-center align-middle">
                            <div class="mb-2">
                                <img id="preview-${index}" class="img-thumbnail d-none" style="max-height:80px;">
                            </div>
                            <input type="file" name="variants[${index}][image]" id="image-${index}"
                                class="d-none" accept="image/*"
                                onchange="previewVariantImage(event, ${index})">
                            <label for="image-${index}" class="btn btn-outline-primary btn-sm w-100 d-flex align-items-center justify-content-center gap-2">
                                <i class="fas fa-upload"></i> Upload
                            </label>
                            <small id="fileName-${index}" class="d-block mt-1 text-muted small"></small>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-danger delete-club-member" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>`;
                index++;
            });
        });

        table += `</tbody></table></div></div>`;
        $('#variant-matrix-container').html(table);

        if ($('#variant-matrix-container tbody tr').length > 0) {
            $('#submitBtn').removeClass('d-none');
        }

        setTimeout(saveVariantData, 200);
    });

    // ✅ Delete row & clean up image store
    $(document).on('click', '.delete-club-member', function () {
        const row   = $(this).closest('tr');
        const index = row.find('input[name*="[image]"]').attr('id')?.replace('image-', '');

        // Remove from image store
        if (index !== undefined) {
            let imageStore = JSON.parse(localStorage.getItem(IMAGE_STORE_KEY) || '{}');
            delete imageStore[index];
            localStorage.setItem(IMAGE_STORE_KEY, JSON.stringify(imageStore));
        }

        row.remove();
        reIndexVariants();
        saveVariantData();

        if ($('#variant-matrix-container tbody tr').length === 0) {
            $('#submitBtn').addClass('d-none');
        }
    });

    function reIndexVariants() {
        $('#variant-matrix-container tbody tr').each(function (index) {
            $(this).find('input[name*="[color]"]').attr('name',          `variants[${index}][color]`);
            $(this).find('input[name*="[size]"]').attr('name',           `variants[${index}][size]`);
            $(this).find('input[name*="[stock]"]').attr('name',          `variants[${index}][stock]`);
            $(this).find('input[name*="[price]"]').attr('name',          `variants[${index}][price]`);
            $(this).find('input[name*="[image_uploaded]"]').attr('name', `variants[${index}][image_uploaded]`);

            const oldId  = $(this).find('input[type="file"]').attr('id');
            const fileInput    = $(this).find('input[type="file"]');
            const previewImg   = $(this).find('img[id^="preview-"]');
            const fileNameSpan = $(this).find('small[id^="fileName-"]');
            const uploadLabel  = $(this).find('label[for^="image-"]');

            fileInput.attr({
                name    : `variants[${index}][image]`,
                id      : `image-${index}`,
                onchange: `previewVariantImage(event, ${index})`
            });
            previewImg.attr('id',    `preview-${index}`);
            fileNameSpan.attr('id',  `fileName-${index}`);
            uploadLabel.attr('for',  `image-${index}`);
        });
    }

    // ✅ RESTORE on page load
    const saved = localStorage.getItem(STORAGE_KEY);
    if (saved) {
        const data = JSON.parse(saved);
        if (data.colors) $('#color').val(data.colors).trigger('change');
        if (data.sizes)  $('#size').val(data.sizes).trigger('change');

        if (data.tableHtml) {
            $('#variant-matrix-container').html(data.tableHtml);

            if ($('#variant-matrix-container tbody tr').length > 0) {
                $('#submitBtn').removeClass('d-none');
            }

            // ✅ Restore actual File objects into each file input
            const imageStore = JSON.parse(localStorage.getItem(IMAGE_STORE_KEY) || '{}');
            const restorePromises = Object.entries(imageStore).map(([index, imgData]) =>
                restoreFileInput(parseInt(index), imgData)
            );

            Promise.all(restorePromises).then(() => {
                console.log('All images restored successfully');
            });
        }
    }

    // Save on stock/price change
    $(document).on('input', 'input[name*="[stock]"], input[name*="[price]"]', function () {
        saveVariantData();
    });
});

// ✅ Preview + save image to localStorage
function previewVariantImage(event, index) {
    const file     = event.target.files[0];
    const preview  = document.getElementById(`preview-${index}`);
    const label    = document.getElementById(`fileName-${index}`);

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');
        preview.style.display = 'block';
        label.innerText = file.name;

        // ✅ Save base64 to localStorage
        saveImageToStore(index, file);

        // Mark as uploaded
        let $input = $(event.target);
        if ($input.siblings('input[name*="[image_uploaded]"]').length === 0) {
            $input.after(`<input type="hidden" name="variants[${index}][image_uploaded]" value="1">`);
        } else {
            $input.siblings('input[name*="[image_uploaded]"]').val('1');
        }

        $(event.target).closest('td').find('.image-error').remove();
    } else {
        preview.src = '';
        preview.classList.add('d-none');
        label.innerText = '';
    }
}

// ✅ Submit validation — now file inputs are real so this works normally
$('.VarientForm').on('submit', function (e) {
    let hasError = false;
    $('.image-error').remove();

    $('input[type="file"][name*="[image]"]').each(function () {
        const alreadyUploaded = $(this).siblings('input[name*="[image_uploaded]"]').val() === '1';
        const hasFile         = this.files && this.files.length > 0;

        if (!alreadyUploaded && !hasFile) {
            $(this).closest('td').append('<div class="text-danger mt-1 image-error">Please upload image</div>');
            hasError = true;
        }
    });

    if (hasError) {
        e.preventDefault();
        return false;
    }

    const submitBtn = $('#submitBtn');
    if (submitBtn.prop('disabled')) return false;

    submitBtn.prop('disabled', true);
    submitBtn.html(`<span class="spinner-border spinner-border-sm me-2"></span>Processing...`);
});
</script>
 @endsection
 @endsection