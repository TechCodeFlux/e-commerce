@extends('admin.components.app')

@section('page-title', 'Orders')

@section('content')

<div class="container-fluid">

    <h4 class="mb-4">All Orders</h4>

    @foreach($orders as $order)
        <div class="card mb-4 shadow-sm">

            {{-- HEADER --}}
            <div class="card-header d-flex justify-content-between">
                <div>
                    <strong>Order #{{ $order->id }}</strong><br>

                    <small>
                        Member: {{ $order->clubMember->name ?? $order->club_member_id }}
                    </small><br>

                    <small>
                        Club: {{ $order->club->name ?? $order->club_id }}
                    </small><br>

                    <small>
                        Microsite: {{ $order->microsite->name ?? $order->microsite_id }}
                    </small><br>

                    <small>
                        Date: {{ $order->created_at->format('d M Y, h:i A') }}
                    </small>
                </div>

                <div class="text-end">
                    <span class="badge bg-primary">
                        {{ $order->order_status }}
                    </span><br>

                    <strong>₹{{ number_format($order->total_amount, 2) }}</strong>
                </div>
            </div>

            {{-- ADDRESS --}}
            <div class="card-body border-bottom">
                <strong>Address:</strong><br>
                {{ $order->address->full_address ?? 'N/A' }}
            </div>

            {{-- ITEMS --}}
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Variant</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    {{ $item->product->name ?? $item->product_id }}
                                </td>

                                <td>
                                    {{-- SHOW FULL VARIANT DATA --}}
                                    @if($item->variant)
                                        {{ $item->variant->name }}
                                    @else
                                        {{ $item->variant_id }}
                                    @endif
                                </td>

                                <td>{{ $item->quantity }}</td>

                                <td>₹{{ number_format($item->price, 2) }}</td>

                                <td>
                                    ₹{{ number_format($item->total ?? ($item->price * $item->quantity), 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- FOOTER --}}
            
        </div>
    @endforeach

</div>

@endsection