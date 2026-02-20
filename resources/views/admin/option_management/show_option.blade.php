

@extends('admin.components.app')
@section('page-title', 'Options')
@section('content')
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb"> 
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">
                        <i class="bi bi-globe2 small me-2"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-sliders me-2"></i>Options</li>
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
                            <a href="{{ route('admin.add_option') }}">
                                <button class="btn btn-primary btn-icon">
                                        <i class="bi bi-plus-circle"></i> Add Options
                                </button>
                            </a>
                        </div>
                        
                    </div>
                    </div>
                </div>
                <div class="" >
                    <table id="options" class="table table-custom table-lg mb-0" >
                    <thead>
                      <tr>
                         <th >Option Name</th>  
                          <th>Status</th>
                        <th  class=" ps-5" >Action</th>
                     </tr>
                    </thead>
                    </table>
                </div>
            </div>
        </div>
       



    {{-- modal --}}

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
                        {{-- <input type="hidden" name="_token" > --}}
                        <input type="hidden" id="deleteId" name="deleteId">
                        <p>Are you sure you want to delete this option?</p>
                        <div class="modal-footer">
                        
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-sm btn-danger btn_delete_option" data-loading-text="">Delete</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>   
        </div>


    {{-- end modal --}}
@section('script')
<script src="{{ url('libs/dataTable/datatables.min.js') }}"></script>
<script src="{{ url('libs/range-slider/js/ion.rangeSlider.min.js') }}"></script>
<script>





//status toggle


let categoryId;
let status;
let label;

$(document).on('change', '.toggle-status', function () {

    categoryId = $(this).data('id');
    status = $(this).is(':checked') ? 1 : 0;
    label = $('#status-label-' + categoryId);

//     let statusModal = new bootstrap.Modal(document.getElementById('status-modal'));
//     statusModal.show();
// });

// $(document).on('click', '#confirmStatusChange', function () {

    $.ajax({
        url: "{{ route('admin.option_change_status') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: categoryId,
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
    $OptionsTable= $('#options').DataTable({
        processing: true,
        serverSide: true,
         dom: 'rtip',
        ajax: {
           url: "{{ route('admin.show_option') }}",
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
        $OptionsTable.search($(this).val()).draw();
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
        $OptionsTable.order([$column, $sort]).draw();
    })
    $('#pageLength').on('change',function(){
        $OptionsTable.page.len($(this).val()).draw();
    })
    $('#pageLength').val($OptionsTable.page.len());
})


//delete option
// delete modal

    function delete_option(id) {
    $('#deleteId').val(id);
    const modal = new bootstrap.Modal(document.getElementById('delete-modal'));
    modal.show();
}

$(document).ready(function () {

            $(document).on('click', '.delete-option', function () {
            let id = $(this).data('id');
            $('#deleteId').val(id);
        });

    $(document).on('click', '.btn_delete_option', function () {

        let id = $('#deleteId').val();
        let $btn = $(this);

        if (!id) {
            Swal.fire('Error', 'Invalid Option ID', 'error');
            return;
        }

        $btn.prop('disabled', true).text('Deleting...');

        $.ajax({
            url: "{{ url('admin/delete_option') }}/" + id,
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

</script>

@endsection
@endsection