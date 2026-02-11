@extends('admin.components.app')
@section('page-title', 'Clubs')

@section('content')
<div class="mb-4">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-globe2 small me-2"></i> Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active">
                <i class="bi bi-person-badge small me-2"></i> Clubs
            </li>
        </ol>
    </nav>
</div>

<div class="content">
<div class="card">
<div class="card-body">

<div class="d-md-flex gap-4 align-items-center mb-3">

    <div class="d-none d-md-flex">All Club Members</div>

    <div class="d-md-flex gap-4 align-items-center">
        <form class="row g-3">
            <div class="col-md-7">
                <select class="form-select" id="sort">
                    <option value="">Sort by</option>
                    <option data-sort="asc" data-column="0">Name A-Z</option>
                    <option data-sort="desc" data-column="0">Name Z-A</option>
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
        </form>
    </div>

    <div class="ms-auto">
        <a href="{{ route('admin.club') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Club
        </a>
    </div>

</div>

</div>
</div>

<div class="table-responsive">
<table class="table table-custom table-lg mb-0" id="club">
<thead>
<tr>
<th>Name</th>
<th>Email</th>
<th>Contact</th>
<th>Address</th>
<th>Country</th>
<th>State</th>
<th>City</th>
<th>Zip</th>
<th>Action</th>
</tr>
</thead>
</table>
</div>

</div>


{{-- DELETE MODAL --}}
<div class="modal fade" id="delete-modal">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Delete Club</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<input type="hidden" id="deleteId">
<p>Are you sure you want to delete this club?</p>
</div>

<div class="modal-footer">
<button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
<button class="btn btn-danger btn_delete_club_member">Delete</button>
</div>

</div>
</div>
</div>

@section('script')

<script src="{{ url('libs/dataTable/datatables.min.js') }}"></script>

<script>

$(document).ready(function () {

    let clubTable = $('#club').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.clubsindex') }}",

        columns: [
            {data: 'name'},
            {data: 'email'},
            {data: 'contact'},
            {data: 'address'},
            {data: 'country_name', name: 'countries.name'},
            {data: 'state_name', name: 'states.name'},
            {data: 'city'},
            {data: 'zip_code'},
            {data: 'action', orderable:false, searchable:false}
        ],searching: false,     // removes the Search box
        lengthChange: false,  // removes the "Show X entries" dropdown
        dom: 'rtip'           // only table, info, and pagination
        
    });


    // SORT
    $('#sort').change(function () {
        let column = $(this).find(':selected').data('column');
        let sort = $(this).find(':selected').data('sort');
        clubTable.order([column, sort]).draw();
    });


    // PAGE LENGTH
    $('#pageLength').change(function () {
        clubTable.page.len($(this).val()).draw();
    });


    // OPEN DELETE MODAL
    $(document).on('click', '.delete-club', function () {
        let id = $(this).data('id');
        $('#deleteId').val(id);
        $('#delete-modal').modal('show');
    });


    // DELETE AJAX
    $('.btn_delete_club_member').click(function () {

        let id = $('#deleteId').val();

        $.ajax({
            url: "/admin/clubs/" + id,
            type: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function () {

                $('#delete-modal').modal('hide');
                clubTable.ajax.reload(null,false);

                Swal.fire({
                    icon: 'success',
                    title: 'Club deleted successfully'
                });
            }
        });

    });

    $('.dataTables_paginate').addClass('d-flex justify-content-center');


});

</script>

@endsection

@endsection