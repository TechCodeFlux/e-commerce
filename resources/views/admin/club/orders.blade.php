@extends('admin.components.app')
@section('page-title', $club->name)

@section('head')
<link rel="stylesheet" href="{{ url('libs/dataTable/datatables.min.css') }}">
@endsection

@section('content')

{{-- ===== BREADCRUMB ===== --}}
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
                <a href="{{ route('admin.clubs.dashboard', $club->id) }}">
                    <i class="bi bi-people-fill small me-2"></i> {{ $club->name }}
                </a>
            </li>
            <li class="breadcrumb-item active">
                <i class="bi bi-receipt small me-2"></i> Orders
            </li>
        </ol>
    </nav>
</div>

<div class="content">
    <div class="row flex-md-row">

        {{-- SIDEBAR --}}
        @include('admin.club.side_bar')

        <div class="col-md-9">

            <div class="tab-content">
                <div class="tab-pane fade show active">

                    <div class="mb-4">
                        <div class="card">
                            <div class="card-body">

                                <div class="d-md-flex gap-4 align-items-center">
                                    <div class="d-none d-md-flex">
                                        All Orders
                                    </div>

                                    <div class="d-md-flex gap-4 align-items-center">
                                        <form class="mb-3 mb-md-0">
                                            <div class="row g-3">
                                                <div class="col-md-7">
                                                    <select class="form-select" id="sort">
                                                        <option>Sort by</option>
                                                        <option data-sort="asc" data-column="0">ID Asc</option>
                                                        <option data-sort="desc" data-column="0">ID Desc</option>
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

                                </div>

                            </div>
                        </div>

                        {{-- DATATABLE --}}
                        <div>
                            <table class="table table-custom table-lg mb-0" id="ordersTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Member</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection


@section('script')
<script src="{{ url('libs/dataTable/datatables.min.js') }}"></script>

<script>
$(document).ready(function() {

    var $ordersTable = $('#ordersTable').DataTable({
        processing: true,
        serverSide: false,
        dom: 'rtip',
        scrollY: '400px',
        scrollX: true,
        scrollCollapse: true,

        data: [
            {
                id: 1,
                product_id: "Club T-Shirt",
                club_member_id: "Aishwarya Singh",
                quantity: 2,
                order_status_id: '<span class="badge bg-warning text-dark">Pending</span>'
            },
            {
                id: 2,
                product_id: "Membership Card",
                club_member_id: "Rahul Verma",
                quantity: 1,
                order_status_id: '<span class="badge bg-success">Completed</span>'
            },
            {
                id: 3,
                product_id: "Event Pass",
                club_member_id: "Priya Sharma",
                quantity: 3,
                order_status_id: '<span class="badge bg-danger">Cancelled</span>'
            }
        ],

        columns: [
            { data: 'id' },
            { data: 'product_id' },
            { data: 'club_member_id' },
            { data: 'quantity' },
            { data: 'order_status_id' }
        ]
    });

    $('#sort').on('change', function() {
        var column = $(this).find(':selected').data('column');
        var sort = $(this).find(':selected').data('sort');
        if(column !== undefined){
            $ordersTable.order([column, sort]).draw();
        }
    });

    $('#pageLength').on('change', function() {
        $ordersTable.page.len($(this).val()).draw();
    });

});
</script>
@endsection