@extends('clubmember.components.app')
@section('page-title', 'Order History')

@section('head')
    <link rel="stylesheet" href="{{ url('libs/dataTable/datatables.min.css') }}" type="text/css">
@endsection

@section('content')
<div class="mb-4">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('club.dashboard') }}">
                    <i class="bi bi-globe2 small me-2"></i> Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Order History</li>
        </ol>
    </nav>
</div>

<div class="content">
    <div class="">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex gap-4 align-items-center">
                    <div class="d-none d-md-flex">All Orders</div>

                    <div class="d-md-flex gap-4 align-items-center">
                        <form class="mb-3 mb-md-0">
                            <div class="row g-3">
                                <div class="col-md-7">
                                    <select class="form-select" id="sort">
                                        <option>Sort by</option>
                                        <option data-sort="asc" data-column="0">Order ID Asc</option>
                                        <option data-sort="desc" data-column="0">Order ID Desc</option>
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

            <div class="table-responsive">
                <table class="table table-custom table-lg mb-0" id="orderhistorytb">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Items</th>
                            <th>Total Qty</th>
                            <th>Status</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order['order_id'] }}</td>

                                <td>
                                    <ul class="list-unstyled mb-0">
                                        @foreach($order['items'] as $item)
                                            <li>
                                                Product #{{ $item['product_id'] }} (Qty: {{ $item['quantity'] }})
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>

                                <td>{{ collect($order['items'])->sum('quantity') }}</td>

                                <td>
                                    <span class="badge
                                        @if($order['status'] === 'Delivered') bg-success
                                        @elseif($order['status'] === 'Pending') bg-warning
                                        @else bg-danger
                                        @endif
                                    ">
                                        {{ $order['status'] }}
                                    </span>
                                </td>

                                <td>{{ $order['order_date'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ url('libs/dataTable/datatables.min.js') }}"></script>

<script>
$(document).ready(function () {

    let table = $('#orderhistorytb').DataTable({
        paging: true,
        ordering: true,
        info: false,
        searching: false
    });

    $('#sort').on('change', function () {
        let column = $(this).find(':selected').data('column');
        let sort = $(this).find(':selected').data('sort');
        if(column !== undefined) {
            table.order([column, sort]).draw();
        }
    });

    $('#pageLength').on('change', function () {
        table.page.len($(this).val()).draw();
    });

    $('#pageLength').val(table.page.len());
});
</script>
@endsection
