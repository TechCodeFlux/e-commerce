@extends('clubmember.components.app')

@section('content')
<div class="container mt-4">
    <h2>Order History</h2>

    @if($orders->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover mt-3">
                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Items</th>
                        <th>Total Quantity</th>
                        <th>Status</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>
                                <ul class="list-unstyled mb-0">
                                    @foreach($order->items as $item)
                                        <li>
                                            Product ID: {{ $item->product_id }} (Qty: {{ $item->quantity }})
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $order->items->sum('quantity') }}</td>
                            <td>{{ $order->status->status ?? 'N/A' }}</td>
                            <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No orders found.</p>
    @endif
</div>
@endsection
