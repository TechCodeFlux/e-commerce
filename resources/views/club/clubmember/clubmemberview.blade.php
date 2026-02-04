    @extends('club.components.app')
    {{-- @yield('page-title','Club') --}}
    @section('content')
    
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('club.dashboard') }}">
                        <i class="bi bi-globe2 small me-2"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-building  small me-2"></i>Club Members</li>
            </ol>
        </nav>
    </div>
    <div class="content">
        <div class="">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex gap-4 align-items-center">
                        <div class="d-none d-md-flex">All Club Members</div>
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
                            <a href="{{ route('club.addclubmember') }}">
                                <button class="btn btn-primary btn-icon">
                                        <i class="bi bi-plus-circle"></i> Add Club Member
                                </button>
                            </a>
                        </div>
                    </form>
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
                        <th>Zip Code</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="delete-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Club Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="deleteId">
                <p>Are you sure you want to delete this club member?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-sm btn-danger btn_delete_club_member">Delete</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ url('libs/dataTable/datatables.min.js') }}"></script>

<script>
let table = $('#club').DataTable({
    processing: true,
    serverSide: true,
    dom: 'rtip',
    ajax: '{{ route('club.clubmembersindex') }}',
    columns: [
        { data: 'name', name: 'name' },
        { data: 'email', name: 'email' },
        { data: 'contact', name: 'contact' },
        { data: 'address', name: 'address' },
        { data: 'country_id', name: 'country_id' },
        { data: 'state_id', name: 'state_id' },
        { data: 'city', name: 'city' },
        { data: 'zip_code', name: 'zip_code' },
        { data: 'action', orderable: false, searchable: false }
    ],

    drawCallback: function () {
        const wrapper = $('#club').closest('.dataTables_wrapper');

        wrapper.find('.dataTables_info, .dataTables_paginate')
            .css({
                'float': 'none',
                'text-align': 'center'
            });

        wrapper.find('.dataTables_paginate')
            .css({
                'display': 'flex',
                'justify-content': 'center'
            });
    }
});

</script>
@endsection
