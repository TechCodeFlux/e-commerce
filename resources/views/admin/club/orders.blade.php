@extends('admin.components.app')

@section('page-title', 'Orders')

@section('content')

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<style>
    /* Table Header */
    table.dataTable thead th {
        border: none !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 1px;
    }

    /* Rounded table rows */
    #ordersTable tbody tr {
        background: #f8f9fa;
        border-radius: 12px;
    }

    #ordersTable tbody td {
        border-top: 10px solid #fff;
        vertical-align: middle;
    }

    /* Pagination Styling */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 8px !important;
        margin: 0 4px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #ff6b3d !important;
        border-color: #ff6b3d !important;
        color: #fff !important;
    }

    /* Search box styling */
    .dataTables_filter input {
        border-radius: 8px;
        padding: 6px 10px;
        border: 1px solid #ddd;
    }

    /* Entries dropdown */
    .dataTables_length select {
        border-radius: 8px;
        padding: 4px 8px;
    }
</style>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Orders - {{ $club->name }}</h5>
    </div>

    <div class="card-body">

        <table id="ordersTable" class="table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Quantity</th>
                    <th>Product</th>
                    <th>Member</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ $order->product->name ?? '-' }}</td>
                        <td>{{ $order->member->name ?? '-' }}</td>
                        <td>
                            <span class="badge bg-info">
                                {{ $order->status->name ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <button 
                                class="btn btn-sm btn-outline-primary view-order"
                                data-id="{{ $order->id }}"
                                data-quantity="{{ $order->quantity }}"
                                data-product="{{ $order->product->name ?? '-' }}"
                                data-member="{{ $order->member->name ?? '-' }}"
                                data-status="{{ $order->status->name ?? '-' }}"
                                data-date="{{ $order->created_at }}"
                                data-bs-toggle="modal"
                                data-bs-target="#orderModal">
                                View
                            </button>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>

    </div>
</div>

<!-- ORDER MODAL -->
<div class="modal fade" id="orderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p><strong>Order ID:</strong> <span id="modal-id"></span></p>
                <p><strong>Quantity:</strong> <span id="modal-quantity"></span></p>
                <p><strong>Product:</strong> <span id="modal-product"></span></p>
                <p><strong>Member:</strong> <span id="modal-member"></span></p>
                <p><strong>Status:</strong> <span id="modal-status"></span></p>
                <p><strong>Ordered At:</strong> <span id="modal-date"></span></p>
            </div>

        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {

    $('#ordersTable').DataTable({
        pageLength: 10,
        ordering: true,
        language: {
            search: "",
            searchPlaceholder: "Search orders..."
        }
    });

    $('.view-order').on('click', function() {
        $('#modal-id').text($(this).data('id'));
        $('#modal-quantity').text($(this).data('quantity'));
        $('#modal-product').text($(this).data('product'));
        $('#modal-member').text($(this).data('member'));
        $('#modal-status').text($(this).data('status'));
        $('#modal-date').text($(this).data('date'));
    });

});
</script>

@endsection