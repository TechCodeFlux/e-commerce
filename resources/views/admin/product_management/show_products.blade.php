@extends('admin.components.app')
@section('page-title','Products')
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
    <div class="content">
        <div class="">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex gap-4 align-items-center">
                        <div class="d-none d-md-flex">All Products</div>
                        <div class="d-md-flex gap-4 align-items-center">
                            <form class="mb-3 mb-md-0">
                                <div class="row g-3">
                                    <div class="col-md-7">
                                        <select class="form-select" id="sort">
                                            <option>Sort by</option>
                                            <option data-sort="asc" data-column="1" value="">Name A-z</option>
                                            <option data-sort="desc" data-column="1" value=""> Name Z-a
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <select class="form-select" id="pageLength">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                        <option value="50">50</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div> 
                        <div class="dropdown ms-auto">
                            <a href="{{ route('admin.product_management.form_products_index') }}">
                                <button class="btn btn-primary btn-icon">
                                        <i class="bi bi-plus-circle"></i> Add Product
                                </button>
                            </a>
                        </div>
                        
                    </div>
                    </div>
                </div>
                <div class="" >
                    <table class="table table-custom table-lg mb-0"  id="admin" >
                    <thead>
                      <tr>
                        <th class="tooltip-inner link-dark">Image</th>  
                         <th >Name</th>  
                         <th>Description</th>
                          <th>Status</th>
                        <th  class=" ps-5" >Action</th>
                     </tr>
                    </thead>
                    </table>
                </div>
            </div>
        </div>
     



{{-- View once row --}}

{{-- 
    <div class="modal fade" id="productListModal" tabindex="-1" aria-labelledby="productListModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                
                <!-- Modal Header with Close Button -->
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="productListModalLabel">Available Products</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body: The Product List -->
               <div class="modal-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-center">
            <thead class="table-light">
                <tr>
                    <th scope="col" class=" pe-md-5">Image</th>
                    <th scope="col" class="py-3 ps-md-4"> Name</th>
                    <th scope="col" class="py-3"> Description</th>
                                       
                </tr>
            </thead>
            <tbody>
                <!-- Product Item Row -->
                <tr>
                    <td class="ps-4 py-3">
                        <img id="modalProductImage" class="rounded shadow-sm object-fit-cover" width="120" height="120" alt="Product">
                    </td>
                    <td class="py-3">
                        <h4 class="mb-1 fw-bold" id="modalProductName"></h4>
                    </td>
                    <td> 
                        <p class="mb-0 text-muted fs-6" id="modalProductDescription"></p>
                    </td>
                    
                </tr>
            </tbody>
        </table>
    </div>
</div>
                <!-- Modal Footer -->
               
                
            </div>
        </div>
    </div> --}}
<div class="modal fade" id="productListModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">

            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i> Product Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-4 ">

                <!-- TOP SECTION: Details and Image -->
                <div class="row align-items-start">

                    <!-- LEFT: DETAILS -->
                    <div class="col-md-7">
                        <table class="table table-sm table-borderless mb-0 m-md-2">
                            <tr>
                                <th width="40%" class="text-muted fw-bold">Product Name</th>
                                <td id="ms_name" class="text-dark"></td>
                            </tr>

                            <tr>
                                <th class="text-muted fw-bold">Description</th>
                                <td id="ms_description" class="text-dark"></td>
                            </tr>

                            <tr>
                                <th class="text-muted fw-bold">Category</th>
                                <td id="ms_category" class="text-dark"></td>
                            </tr>

                            <tr>
                                <th class="text-muted fw-bold">Category Status</th>
                                <td>
                                    <span id="ms_category_status" class="badge"></span>
                                </td>
                            </tr>

                            <tr>
                                <th class="text-muted fw-bold">Status</th>
                                <td>
                                    <span id="ms_status" class="badge bg-success"></span>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- RIGHT: IMAGE -->
                    <div class="col-md-5 text-center">
                        <div class="border rounded p-2 bg-light d-inline-block shadow-sm">
                            <img id="ms_image" class="rounded object-fit-cover" width="139" height="139" alt="Product" onerror="this.style.display='none'; document.getElementById('no_image').classList.remove('d-none');">
                            
                            <div id="no_image" class="text-muted d-none py-4">
                                <i class="fas fa-image fa-3x mb-2"></i>
                                <p class="mb-0 small">No Image Available</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- BOTTOM SECTION: VARIANT TABLE -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="px-2">
                            <h6 class="fw-bold mb-3 border-bottom pb-2">Available Variants</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover text-center align-middle">
                                    <thead class="table-light">
                                        <tr class="small text-uppercase">
                                            <th>Color</th>
                                            <th>Size</th>
                                            <th>Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody id="ms_varients_table">
                                        <!-- Dynamic Content -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>



{{-- modal delete --}}


           <div class="modal fade" id="delete-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Delete Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="deleteId">
                <p>Are you sure you want to delete this category?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>

                <!-- ✅ class used in JS -->
                <button type="button" class="btn btn-sm btn-danger btn_delete_club_member">
                    Delete
                </button>
            </div>

        </div>
    </div>
</div>

{{-- delete-modal --}}

@section('script')
<script src="{{ url('libs/dataTable/datatables.min.js') }}"></script>
<script src="{{ url('libs/range-slider/js/ion.rangeSlider.min.js') }}"></script>
<script>

//view single row
$(document).on('click', '.view-product', function () {

    let productId = $(this).data('id');

    $.ajax({
        url: "{{ route('admin.product_management.show_single', ':id') }}".replace(':id', productId),
        type: "GET",
        success: function (res) {

            $('#ms_name').text(res.name);
            $('#ms_description').text(res.description);
            $('#ms_image').attr('src', res.image);
             $('#ms_category').text(res.categories.name);
             if(res.categories.status == 1){
                  $('#ms_category_status')
                  .text("Active")
                  .removeClass("bg-danger")
                  .addClass("bg-success");
             }
             else{
                   $('#ms_category_status')
                  .text("Inactive")
                  .removeClass("bg-success")
                  .addClass("bg-danger");
             }

              if(res.status == 1){
                  $('#ms_status')
                  .text("Active")
                  .removeClass("bg-danger")
                  .addClass("bg-success");
             }
             else{
                   $('#ms_status')
                  .text("Inactive")
                  .removeClass("bg-success")
                  .addClass("bg-danger");
             }

            let rows = '';

            if(res.varients.length > 0){

                res.varients.forEach(function(v){
                    rows += `
                        <tr>
                            <td>${v.color ?? '-'}</td>
                            <td>${v.size ?? '-'}</td>
                            <td>${v.stock ?? 0}</td>
                        </tr>
                    `;
                });

            } else {

                rows = `
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            No varients available
                        </td>
                    </tr>
                `;
            }

            $('#ms_varients_table').html(rows);
        },
        error: function () {
            alert('Failed to load product');
        }
    });
});



//status toggle
    

$(document).on('change', '.toggle-status', function () {

    let productId = $(this).data('id');
    let status = $(this).is(':checked') ? 1 : 0;
    let label = $('#status-label-' + productId);

    $.ajax({
        url: "{{ route('admin.product_management.change-status') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: productId,
            status: status
        },
         success: function (res) {
            // alert('Status Changed!');
            // bootstrap.Modal.getInstance(document.getElementById('status-modal')).hide();
            Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "Status changed successfully!",
                    confirmButtonText: 'OK'
                });
           if (status === 1) {
                    label.text('Active')
                         .removeClass('bg-secondary-subtle text-secondary')
                         .addClass('bg-success-subtle text-success');
                } else {
                    label.text('Inactive')
                         .removeClass('bg-success-subtle text-success')
                         .addClass('bg-secondary-subtle text-secondary');
                }
                
        },
        error: function () {
            alert('Status update failed');
        }
    });

});

//table rows

$(document).ready(function() {
    console.log("hello");
    var $column = $('#sort').find(':selected').data('column');
    var $sort = $('#sort').find(':selected').data('sort');
    $productTable= $('#admin').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
           url: "{{ route('admin.product_management.show_products') }}",
            data: function(d) {
                
            }
        },

        columns: [
            { data: 'image', name: 'image' },
            { data: 'name', name: 'name', orderable: false,searchable: false },
            { data: 'description', name: 'description' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],

        columnDefs: [{
            'defaultContent': '--',
            "targets": "_all"
        }],
    });
    
    $(document).on("keyup", ".searchInput", function(e) {
        $productTable.search($(this).val()).draw();
    });
    $("#admin_filter").css({
        "display": "none"
    });
    $("#admin_length").css({
        "display": "none"
    });
    // $('#sort').on('change', function() {
    //     $column = $(this).find(':selected').data('column');
    //     $sort = $(this).find(':selected').data('sort');
    //     $productTable.order([$column, $sort]).draw();
    // })

    
    //sorting


    document.getElementById('sort').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    const sortType = selectedOption.dataset.sort;
    const columnIndex = selectedOption.dataset.column;

    if (!sortType) return;

    const table = document.getElementById('admin');
    const tbody = table.tBodies[0];
    const rows = Array.from(tbody.rows);

    rows.sort((a, b) => {
        let textA = a.cells[columnIndex].innerText.toLowerCase();
        let textB = b.cells[columnIndex].innerText.toLowerCase();

        if (sortType === 'asc') {
            return textA.localeCompare(textB);
        } else {
            return textB.localeCompare(textA);
        }
    });

    // Re-append sorted rows
    rows.forEach(row => tbody.appendChild(row));
});


    $('#pageLength').on('change',function(){
        $productTable.page.len($(this).val()).draw();
    })
    $('#pageLength').val($productTable.page.len());
})






// function deleteProduct(id) {

//     if (!confirm("Are you sure you want to delete this product?")) {
//         return;
//     }

//     $.ajax({
//        url: "{{ url('admin/product_management/destroy_products') }}/" + id,
//         type: "DELETE",
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         success: function (response) {
//             alert(response.message);

//             // Reload DataTable
//             $('#admin').DataTable().ajax.reload(null, false);
//         },
//         error: function (xhr) {
//             alert("Something went wrong. Try again.");
//         }
//     });
// }



function deleteProduct(id) {
    $('#deleteId').val(id);
    const modal = new bootstrap.Modal(document.getElementById('delete-modal'));
    modal.show();
}

$(document).ready(function () {

    $(document).on('click', '.btn_delete_club_member', function () {

        let id = $('#deleteId').val();
        let $btn = $(this);

        if (!id) {
            Swal.fire('Error', 'Invalid category ID', 'error');
            return;
        }

        $btn.prop('disabled', true).text('Deleting...');

        $.ajax({
            url: "{{ url('admin/product_management/destroy_products') }}/" + id,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                _method: "DELETE"
            },
           success: function () {

                const modalEl = document.getElementById('delete-modal');
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();

                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'Product deleted successfully',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload(); 
                });
            },
            error: function (xhr) {
                Swal.fire('Error', 'Delete failed', 'error');
                console.log(xhr.responseText);
            },
            complete: function () {
                $btn.prop('disabled', false).text('Delete');
            }
        });
    });
});



// image view scale

document.addEventListener('mouseover', function (e) {
    if (e.target.classList.contains('product-image')) {
        e.target.dataset.originalWidth = e.target.offsetWidth;
        e.target.dataset.originalHeight = e.target.offsetHeight;

        e.target.style.position = 'relative';
        e.target.style.zIndex = '999';
        e.target.style.transform = 'scale(2)';
        e.target.style.transition = 'transform 0.2s ease';
    }
});

document.addEventListener('mouseout', function (e) {
    if (e.target.classList.contains('product-image')) {
        e.target.style.transform = 'scale(1)';
        e.target.style.zIndex = '1';
    }
});







//delete club member
// $('table').off('click').on('click','.delete-club-member',function(){
//     var href=$(this).data('href');
//     $('.btn_delete_club_member').click(function(){
//         $.ajax({
//             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
//             type: 'DELETE',
//             dataType : 'JSON',
//             url : href,
//             success:function(response){
//                 $('#delete-modal').modal('hide');
//                 $('#club').DataTable().ajax.reload();
//                 Swal.fire({
//                     icon: 'success',
//                     title: 'Member deleted successfully',
//                     footer: ''
//                 })
//             }  
//         })
//     })

// })
</script>

@endsection
@endsection