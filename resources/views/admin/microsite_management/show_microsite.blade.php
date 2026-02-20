@extends('admin.components.app')
@section('page-title', 'Microsite')

@section('content')

<div class="mb-4">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-globe2 small me-2"></i> Dashboard
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.clubsindex') }}">
                    <i class="bi bi-person-badge small me-2"></i> Clubs
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.clubsindex') }}">
                    <i class="bi bi-people-fill small me-2"></i>{{$club->name}}
                </a>
            </li>
            <li class="breadcrumb-item active">
                <i class="bi bi-building small me-2"></i> Microsites 
            </li>
        </ol>
    </nav>
</div>

<div class="content">
    <div class="row">

        @include('admin.club.side_bar')

        <div class="col-md-9">

            <!-- Header -->
            <div class="card mb-4">
                <div class="card-body d-flex align-items-center">
                    <h6 class="mb-0 fw-semibold">All Microsites</h6>

                    <div class="ms-auto">
                        <a href="{{ route('admin.add_microsites', $club->id) }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Add Microsite
                        </a>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <table id="options" class="table table-custom table-lg">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Microsite Status</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-danger fw-semibold">
                    Confirm Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                Are you sure you want to delete this microsite?
                <br>
                <small class="text-muted">This action cannot be undone.</small>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-danger" id="confirmDelete">
                    Yes, Delete
                </button>
            </div>

        </div>
    </div>
</div>

@endsection

@section('script')

<script src="{{ url('libs/dataTable/datatables.min.js') }}"></script>

<script>
let table;
let deleteId;

// Initialize DataTable
$(document).ready(function() {

    table = $('#options').DataTable({
        processing: true,
        serverSide: true,
        dom: 'rtip',
        ajax: {
            url: "{{ route('admin.show_microsites', $club->id) }}",
            type: "GET", // or POST if your route expects POST
            data: function(d) {
                d.club_id = {{ $club->id }}; // pass current club ID
            }
        },
        columns: [
            { data: 'name', name: 'name' },
            { data: 'start_date', name: 'start_date' },
            { data: 'end_date', name: 'end_date' },
            { data: 'microsite_status', name: 'microsite_status', orderable: false },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

});



// ===============================
// TOGGLE STATUS
// ===============================
$(document).on('change', '.toggle-status', function () {

    let id = $(this).data('id');
    let status = $(this).is(':checked') ? 1 : 0;
    let label = $('#status-label-' + id);

    $.ajax({
        url: "{{ route('admin.microsite_change_status') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: id,
            status: status
        },
        success: function () {

            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "Status changed successfully!",
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


// ===============================
// DELETE
// ===============================
$(document).on('click', '.delete-microsite', function () {
    deleteId = $(this).data('id');
    $('#deleteModal').modal('show');
});

$('#confirmDelete').on('click', function () {

    $.ajax({
        url: "{{ route('admin.delete_microsite') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: deleteId
        },
        success: function () {

            $('#deleteModal').modal('hide');

            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: 'Microsite deleted successfully.',
            });

            table.ajax.reload(null, false);
        },
        error: function () {
            alert('Delete failed');
        }
    });

});
</script>

@endsection
