@extends('club.components.app')

@section('content')
<div class="mb-4">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('club.dashboard') }}">
                    <i class="bi bi-globe2 small me-2"></i> Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <i class="bi bi-building small me-2"></i> Club Members
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
                    <a href="{{ route('club.addclubmember') }}">
                        <button class="btn btn-primary btn-icon">
                            <i class="bi bi-plus-circle"></i> Add Club Member
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-custom table-lg mb-0" id="club_members">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Country ID</th>
                        <th>State ID</th>
                        <th>City</th>
                        <th>Zip Code</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="delete-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Club Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="deleteId" name="deleteId">
                <p>Are you sure you want to delete this club member?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-danger btn_delete_club_member">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ url('libs/dataTable/datatables.min.js') }}"></script>
<script src="{{ url('libs/range-slider/js/ion.rangeSlider.min.js') }}"></script>
<script>
$(document).ready(function() {

    // Initialize DataTable without default Search and Show Entries
    var table = $('#club_members').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("club.clubmembersindex") }}',
        columns: [
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'contact', name: 'contact' },
            { data: 'address.address1', name: 'address.address1' },
            { data: 'address.country_id', name: 'address.country_id' },
            { data: 'address.state_id', name: 'address.state_id' },
            { data: 'address.city', name: 'address.city' },
            { data: 'address.zip_code', name: 'address.zip_code' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        columnDefs: [
            { defaultContent: '--', targets: '_all' }
        ],
        searching: false,     // removes the Search box
        lengthChange: false,  // removes the "Show X entries" dropdown
        dom: 'rtip'           // only table, info, and pagination
    });

    // Sorting using custom select
    $('#sort').on('change', function() {
        var column = $(this).find(':selected').data('column');
        var order = $(this).find(':selected').data('sort');
        table.order([column, order]).draw();
    });

    // Page length using custom select
    $('#pageLength').on('change', function() {
        table.page.len($(this).val()).draw();
    }).val(table.page.len());
});
</script>
@endsection
