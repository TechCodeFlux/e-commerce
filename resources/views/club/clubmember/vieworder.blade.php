@extends('club.components.app')
@section('page-title', $club->name)

@section('content')

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
                    <i class="bi bi-people-fill small me-2"></i> Clubs
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.clubs.dashboard', $club->id) }}">
                    <i class="bi bi-people-fill small me-2"></i> {{ $club->name }}
                </a>
            </li>
            <li class="breadcrumb-item active">
                <i class="bi bi-cart-check small me-2"></i> Orders
            </li>
        </ol>
    </nav>
</div>

<div class="content">
    <div class="row">



        <div class="col-md-9">

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">My Orders</h5>

                    {{-- Page length (optional UI) --}}
                    <select class="form-select w-auto">
                        <option>10</option>
                        <option>20</option>
                        <option>30</option>
                    </select>
                </div>
            </div>

            {{-- Orders List --}}
            @forelse($orders as $order)

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body">

                        {{-- Order Header --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">
                                    Order #{{ $order->id }}
                                </h6>
                                <small class="text-muted">
                                    Status: {{ $order->order_status }}
                                </small>
                            </div>

                            <div class="text-end">
                                <h6 class="mb-0 text-success">
                                    ₹{{ number_format($order->total_amount, 2) }}
                                </h6>

                                {{-- ✅ Button --}}
                                @if($order->order_status_id != 7)
                                    <form action="{{ route('admin.clubs.changestatus', $order->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-success">
                                            Mark as Completed
                                        </button>
                                    </form>
                                @else
                                    <span class="badge bg-success">Completed</span>
                                @endif
                            </div>
                        </div>

                        <hr>

                        {{-- Order Items (Grouped Variants) --}}
                        @foreach($order->items as $item)
                            <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded-3 bg-light">

                                <div>
                                    <strong>
                                        {{ $item->product->name ?? 'Product #' . $item->product_id }}
                                    </strong><br>

                                    <div class="mt-1">
                                        @if($item->variant)
                                            <small class="text-muted d-block">
                                                Size: {{ $item->variant->size ?? '-' }}
                                            </small>
                                            <small class="text-muted d-block">
                                                Color: {{ $item->variant->color ?? '-' }}
                                            </small>
                                        @else
                                            <small class="text-muted">
                                                Variant ID: {{ $item->variant_id }}
                                            </small>
                                        @endif
                                    </div>
                                </div>

                                <div class="text-end">
                                    <div>
                                        ₹{{ number_format($item->price, 2) }} × {{ $item->quantity }}
                                    </div>
                                    <small class="text-muted">
                                        Total: ₹{{ number_format($item->price * $item->quantity, 2) }}
                                    </small>
                                </div>

                            </div>
                        @endforeach

                    </div>
                </div>

            @empty
                <div class="text-center py-5">
                    <h6>No orders found for this club</h6>
                </div>
            @endforelse

        </div>
    </div>
</div>

@endsection