@extends('admin.components.app')

@section('content')
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">
                        <i class="bi bi-globe2 small me-2"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-people-fill small me-2"></i>Categories</li>
            </ol>
        </nav>
    </div>
    <div class="content">
        <div class="">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex gap-4 align-items-center">
                        <div class="d-none d-md-flex">All Categories</div>
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
                            <a href="{{ route('admin.category_management.add_category_index') }}">
                                <button class="btn btn-primary btn-icon">
                                        <i class="bi bi-plus-circle"></i> Add Category
                                </button>
                            </a>
                        </div>
                        
                    </div>
                    </div>
                </div>
                <div class="" >
                    <table id="club" class="table table-custom table-lg mb-0" >
                    <thead>
                      <tr>
                         <th >Category Name</th>  
                          <th>Status</th>
                        <th  class=" ps-5" >Action</th>
                     </tr>
                    </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="delete-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
            <div class="modal-body">
                    <!-- <input type="hidden" name="_method" value="DELETE"> -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" id="deleteId" name="deleteId">
                        <p>Are you sure you want to delete this category</p>
                        <div class="modal-footer">
                        
                            <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-sm btn-danger btn_delete_club_member" data-loading-text="">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>   
</div> 



{{-- View once row --}}


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
                    <div class="list-group list-group-flush">
                        
                        <!-- Product Item 1 -->
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center p-3">
                          <div class="flex-grow-1">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 fw-bold" id="modalCategoryName"   ></h6>
                                  
                                </div>
                              
                            </div>
                        </a>

                    
                    </div>
                </div>

                <!-- Modal Footer -->
               
                
            </div>
        </div>
    </div>
@section('script')
<script src="{{ url('libs/dataTable/datatables.min.js') }}"></script>
<script src="{{ url('libs/range-slider/js/ion.rangeSlider.min.js') }}"></script>
<script>

//view single row
$(document).on('click', '.view-category', function () {

    let categoryId = $(this).data('id');

    $.ajax({
        url: "{{ route('admin.category_management.show_single', ':id') }}".replace(':id', categoryId),
        type: "GET",
        success: function (res) {
            $('#modalCategoryName').text(res.name);
        },
        error: function () {
            alert('Failed to load category');
        }
    });
});



//status toggle
    

$(document).on('change', '.toggle-status', function () {

    let categoryId = $(this).data('id');
    let status = $(this).is(':checked') ? 1 : 0;
    let label = $('#status-label-' + categoryId);

    $.ajax({
        url: "{{ route('admin.category_management.change-status') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: categoryId,
            status: status
        },
        success: function (res) {
           alert('Status Changed!');
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
    $categoryTable= $('#club').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
           url: "{{ route('admin.category_management.show_category') }}",
            data: function(d) {
                
            }
        },

        columns: [
            { data: 'name', name: 'name', orderable: false,searchable: false },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],

        columnDefs: [{
            'defaultContent': '--',
            "targets": "_all"
        }],
    });
    
    $(document).on("keyup", ".searchInput", function(e) {
        $categoryTable.search($(this).val()).draw();
    });
    $("#club_filter").css({
        "display": "none"
    });
    $("#club_length").css({
        "display": "none"
    });
    $('#sort').on('change', function() {
        $column = $(this).find(':selected').data('column');
        $sort = $(this).find(':selected').data('sort');
        $categoryTable.order([$column, $sort]).draw();
    })
    $('#pageLength').on('change',function(){
        $categoryTable.page.len($(this).val()).draw();
    })
    $('#pageLength').val($categoryTable.page.len());
})






function deleteCategory(id) {

    if (!confirm("Are you sure you want to delete this category?")) {
        return;
    }

    $.ajax({
       url: "{{ url('club/category_management/destroy_category') }}/" + id,
        type: "DELETE",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            alert(response.message);

            // Reload DataTable
            $('#club').DataTable().ajax.reload(null, false);
        },
        error: function (xhr) {
            alert("Something went wrong. Try again.");
        }
    });
}








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