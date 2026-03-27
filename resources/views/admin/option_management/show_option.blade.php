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
                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-people-fill small me-2"></i>Option</li>
            </ol>
        </nav>
    </div>
    <div class="content">
        <div class="">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex gap-4 align-items-center">
                        <div class="d-none d-md-flex">All Options</div>
                        <div class="d-md-flex gap-4 align-items-center">
                            <form class="mb-3 mb-md-0">
                                <div class="row g-3">
                                    <div class="col-md-7">
                                        <select class="form-select" id="sort">
                                            <option>Sort by</option>
                                            <option data-sort="asc" data-column="0" value="">Name A-z</option>
                                            <option data-sort="desc" data-column="0" value=""> Name Z-a
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
                            <a href="{{ route('admin.option_management.form_option_index') }}">
                                <button class="btn btn-primary btn-icon">
                                        <i class="bi bi-plus-circle"></i> Add Option
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
                         <th >Option Name</th>  
               
                          <th>Status</th>
                        <th >Action</th>
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
                <h5 class="modal-title" id="staticBackdropLabel">Delete Option</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
            <div class="modal-body">
                    <!-- <input type="hidden" name="_method" value="DELETE"> -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" id="deleteId" name="deleteId">
                        <p>Are you sure you want to delete this option</p>
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
                                    <h6 class="mb-1 fw-bold" id="modalOptionName"   ></h6>
                                  
                                </div>
                              
                            </div>
                        </a>

                    
                    </div>
                </div>

                <!-- Modal Footer -->
                
            </div>
        </div>
    </div>
      <div class="modal fade" id="delete-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Delete Option</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="deleteId">
                <p>Are you sure you want to delete this Option?</p>
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
@section('script')
<script src="{{ url('libs/dataTable/datatables.min.js') }}"></script>
<script src="{{ url('libs/range-slider/js/ion.rangeSlider.min.js') }}"></script>
<script>

//view single row
$(document).on('click', '.view-option', function () {

    let optionId = $(this).data('id');

    $.ajax({
        url: "{{ route('admin.option_management.show_single', ':id') }}".replace(':id', optionId),
        type: "GET",
        success: function (res) {
            $('#modalOptionName').text(res.name);
        },
        error: function () {
            alert('Failed to load Option');
        }
    });
});



//status toggle
    

$(document).on('change', '.toggle-status', function () {

    let optionId = $(this).data('id');
    let status = $(this).is(':checked') ? 1 : 0;
    let label = $('#status-label-' + optionId);

    $.ajax({
        url: "{{ route('admin.option_management.change-status') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: optionId,
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

    var $optionTable = $('#club').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.option_management.show_option') }}",
            type: "GET"
        },

        columns: [
            { data: 'name', name: 'name' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],

        columnDefs: [{
            defaultContent: '--',
            targets: "_all"
        }],

        order: [[0, 'asc']] // default sort
    });

    // Search
    $(document).on("keyup", ".searchInput", function () {
        $optionTable.search($(this).val()).draw();
    });

    // Hide default UI
    $("#club_filter").hide();
    $("#club_length").hide();

    // Sort dropdown
    $('#sort').on('change', function () {
        let column = $(this).find(':selected').data('column');
        let sort = $(this).find(':selected').data('sort');

        if(column !== undefined && sort !== undefined){
            $optionTable.order([column, sort]).draw();
        }
    });

    // Page length
    $('#pageLength').on('change', function () {
        $optionTable.page.len($(this).val()).draw();
    });

});





function deleteOption(id) {

    if (!confirm("Are you sure you want to delete this option?")) {
        return;
    }

    $.ajax({
       url: "{{ url('club/option_management/destroy_option') }}/" + id,
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




function deleteOption(id) {
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
            url: "{{ url('admin/option_management/destroy_option') }}/" + id,
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
                    text: 'Option deleted successfully',
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


</script>
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: "{{ session('success') }}",
        confirmButtonText: 'OK'
    });
});
</script>
@endif

@endsection
@endsection