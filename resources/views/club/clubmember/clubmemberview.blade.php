@extends('club.components.app')

@section('page-title', 'Club Members')

@section('content')
<div class="mb-4">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('club.dashboard') }}">
                    <i class="bi bi-globe2 small me-2"></i> Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active">
                <i class="bi bi-building small me-2"></i> Club members
            </li>
        </ol>
    </nav>
</div>

<div class="content">
    <div class="row flex-md-row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <!-- Header -->
                    <div class="d-md-flex gap-4 align-items-center mb-3">
                        <div class="d-none d-md-flex">
                            <h5>All Club Members</h5>
                        </div>

                        <div class="d-md-flex gap-4 align-items-center">
                            <div class="row g-3">
                                <div class="col-md-7">
                                    <select class="form-select" id="sort">
                                        <option>Sort by</option>
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
                            </div>
                        </div>

                        <div class="ms-auto">
                            <a href="{{ route('club.clubmember.addmember',$club->id) }}" class="btn btn-primary btn-icon">
                                <i class="bi bi-plus-circle"></i> Add Member
                            </a>
                        </div>
                    </div>

                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-custom table-lg mb-0" id="club_members_table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Zip</th>
                                <th>Country</th>
                                <th>State</th>
                                <th>City</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="delete-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Delete Club Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="deleteId">
                <p>Are you sure you want to delete this member?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-sm btn-danger btn_confirm_delete">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ url('libs/dataTable/datatables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {

    let table = $('#club_members_table').DataTable({
        processing: true,
        serverSide: true,
        dom: 'rtip',

        scrollY: '400px',        // ✅ same as admin
        scrollX: true,
        scrollCollapse: true,

        ajax: "{{ route('club.member.list', $club->id) }}",

        columns: [
            { data: 'name' },
            { data: 'contact' },
            { data: 'email' },
            { data: 'address' },
            { data: 'zip_code' },
            { data: 'country' },
            { data: 'state' },
            { data: 'city' },
            { data: 'action', orderable: false, searchable: false }
        ],

        columnDefs: [{
            defaultContent: '--',
            targets: '_all'
        }]
    });

    // Sort
    $('#sort').on('change', function() {
        let col = $(this).find(':selected').data('column');
        let sort = $(this).find(':selected').data('sort');
        if (col !== undefined) {
            table.order([col, sort]).draw();
        }
    });

    // Page Length
    $('#pageLength').on('change', function() {
        table.page.len($(this).val()).draw();
    });

    $('#pageLength').val(table.page.len());

    // Delete modal
    window.deletemember = function(id) {
        $('#deleteId').val(id);
        new bootstrap.Modal('#delete-modal').show();
    };

    // Delete action
    $(document).on('click', '.btn_confirm_delete', function() {

        let id = $('#deleteId').val();
        let $btn = $(this);

        $btn.prop('disabled', true).text('Deleting...');

        $.ajax({
            url: "/club/member/delete/" + id,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                _method: "DELETE"
            },
            success: function() {
                bootstrap.Modal.getInstance(document.getElementById('delete-modal')).hide();

                Swal.fire('Deleted!', 'Member removed successfully', 'success');

                table.ajax.reload(null, false); // ✅ no full reload
            },
            error: function() {
                Swal.fire('Error', 'Delete failed', 'error');
            },
            complete: function() {
                $btn.prop('disabled', false).text('Delete');
            }
        });
    });

    $('.dataTables_paginate').addClass('d-flex justify-content-center');

});
</script>
@endsection