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
            <table id="micrositeTable" class="table table-custom table-lg">
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
<div class="modal fade" id="micrositeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">

            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i> Microsite Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">

                <div class="row">

                    <!-- LEFT: DETAILS -->
                    <div class="col-md-7">

                        <table class="table table-borderless mb-0">
                            <tr>
                                <th width="40%">Microsite Name</th>
                                <td id="ms_name"></td>
                            </tr>
                            <tr>
                                <th>Club Name</th>
                                <td id="ms_club"></td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td id="ms_description"></td>
                            </tr>
                            <tr>
                                <th>Start Date</th>
                                <td id="ms_start"></td>
                            </tr>
                            <tr>
                                <th>End Date</th>
                                <td id="ms_end"></td>
                            </tr>
                            <tr>
                                <th>password</th>
                                <td id="ms_password"></td>
                            </tr>
                            <tr>
                                <th>Microsite Status</th>
                                <td>
                                    <span id="ms_microsite_status" class="badge"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span id="ms_status" class="badge bg-success"></span>
                                </td>
                            </tr>
                        </table>

                    </div>

                    <!-- RIGHT: IMAGE -->
                    <div class="col-md-5 text-center">

                        <img id="ms_image"
                             class="img-fluid rounded shadow-sm d-none"
                             style="max-height: 250px; object-fit: cover;">

                        <div id="no_image" class="text-muted d-none">
                            <i class="fas fa-image fa-3x mb-2"></i>
                            <p>No Image Available</p>
                        </div>

                    </div>

                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>
//
<!-- Success Modal -->
@if(session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-success">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Success</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{ session('success') }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    });
</script>
@endif
//
@endsection

@section('script')

<script src="{{ url('libs/dataTable/datatables.min.js') }}"></script>

<script>
let table;
let deleteId;

// Initialize DataTable
$(document).ready(function() {

    table = $('#micrositeTable').DataTable({
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

// SHOW MODAL
    document.addEventListener('click', function (e) {

        if (e.target.closest('.showMicrosite')) {

            let id = e.target.closest('.showMicrosite').dataset.id;

            fetch("{{ route('admin.microsite_show', ':id') }}".replace(':id', id))
                .then(res => res.json())
                .then(data => {
                        document.getElementById('ms_name').innerText = data.name;
                        document.getElementById('ms_club').innerText = data.club;
                        document.getElementById('ms_description').innerText = data.description;
                        document.getElementById('ms_start').innerText = data.start_date;
                        document.getElementById('ms_end').innerText = data.end_date;

                         document.getElementById('ms_password').innerText = data.password;

                        // NORMAL STATUS (toggle)
                        let statusEl = document.getElementById('ms_status');
                        statusEl.innerText = data.status;
                        statusEl.className = 'badge ' + (data.status === 'Active' ? 'bg-success' : 'bg-secondary');

                        // MICROSITE STATUS (date-based)
                        let msStatusEl = document.getElementById('ms_microsite_status');
                        msStatusEl.innerText = data.microsite_status;

                        if (data.microsite_status === 'Upcoming') {
                            msStatusEl.className = 'badge bg-warning';
                        } else if (data.microsite_status === 'Active') {
                            msStatusEl.className = 'badge bg-success';
                        } else {
                            msStatusEl.className = 'badge bg-danger';
                        }

                        let img = document.getElementById('ms_image');
                        let noImg = document.getElementById('no_image');

                        if (data.image) {
                            img.src = data.image;
                            img.classList.remove('d-none');
                            noImg.classList.add('d-none');
                        } else {
                            img.classList.add('d-none');
                            noImg.classList.remove('d-none');
                        }

                        new bootstrap.Modal(document.getElementById('micrositeModal')).show();
                    });
        }

    });
</script>

@endsection
