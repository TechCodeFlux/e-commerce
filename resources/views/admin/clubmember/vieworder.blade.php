@extends('admin.components.app')
@section('page-title', $club->name)

@section('content')

<div class="mb-4">
    <nav style="--bs-breadcrumb-divider: '>';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.clubsindex') }}">Clubs</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.clubs.dashboard', $club->id) }}">
                    {{$club->name}}
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.clubmember.viewmembers', $club->id) }}">
                    Club Members
                </a>
            </li>
            <li class="breadcrumb-item active">
                {{$clubmember->name}}
            </li>
        </ol>
    </nav>
</div>

<div class="row">
    @include('admin.club.side_bar')

    <div class="col-md-9">

        <div class="card mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="mb-0">My Orders</h5>

                <select class="form-select w-auto" id="pageLength">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-borderless" id="order">
                <thead class="d-none">
                    <tr><th>Order</th></tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>
</div>

@endsection
@section('script')
<script src="{{ url('libs/dataTable/datatables.min.js') }}"></script>

<script>
$(document).ready(function() {

    let orderTable = $('#order').DataTable({
        processing: true,
        serverSide: false,
        ordering: false,
        dom: 'rtip',

        ajax: "{{ route('admin.clubmember.vieworder', $clubmember->id) }}",

        columns: [{
            data: 'name',
            render: function(data, type, row) {

                let isCancelled = row.order_status.toLowerCase().includes('cancel');
                let statusColor = isCancelled ? 'text-danger' : 'text-success';

                let date = row.created_at
                    ? new Date(row.created_at).toLocaleDateString('en-GB')
                    : 'N/A';

                return `
                <div class="card shadow-sm mb-3">
                    <div class="card-body">

                        <div class="row align-items-center">

                            <div class="col-md-2 text-center">
                                <img src="${row.image}" 
                                     onerror="this.src='{{ asset('images/no-image.png') }}'"
                                     class="img-fluid rounded"
                                     style="max-height:80px;">
                            </div>

                            <div class="col-md-4">
                                <h6 class="fw-bold">${row.name}</h6>

                                <span class="badge bg-light text-dark">
                                    Size: ${row.size}
                                </span>

                                <span class="badge bg-light text-dark">
                                    Color: ${row.color}
                                </span>
                            </div>

                            <div class="col-md-3 small">
                                <div><strong>${row.username}</strong></div>
                                <div>${row.email}</div>
                                <div>${row.phone}</div>
                                <div>${row.address}</div>
                            </div>

                            <div class="col-md-3 text-end">
                                <div class="${statusColor} fw-bold">
                                    ${row.order_status}
                                </div>
                                <div class="small text-muted">
                                    ${date}
                                </div>
                                <div>
                                    Qty: <strong>${row.quantity}</strong>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                `;
            }
        }]
    });

    $('#pageLength').change(function(){
        orderTable.page.len($(this).val()).draw();
    });

});
</script>
@endsection