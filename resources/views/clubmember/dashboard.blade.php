<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account | Microsite System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --canvas-bg: #f8fafc;
            --surface: #ffffff;
            --primary-accent: #4f46e5;
            --text-main: #0f172a;
            --text-muted: #64748b;
        }

        body {
            background-color: var(--canvas-bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-main);
            padding-bottom: 80px;
        }

        /* --- Breadcrumb & Nav --- */
        .breadcrumb { font-size: 0.85rem; }
        .breadcrumb-item a { color: var(--text-muted); text-decoration: none; }
        .breadcrumb-item.active { color: var(--primary-accent); font-weight: 600; }
        
        .logout-pill {
            background: #fff; color: #ef4444; border: 1px solid #fee2e2;
            padding: 8px 20px; border-radius: 12px; font-weight: 600; transition: 0.2s;
        }
        .logout-pill:hover { background: #fef2f2; color: #b91c1c; }

        /* --- Profile Hero --- */
        .hero-profile {
            background: var(--surface);
            border-radius: 24px;
            padding: 35px;
            border: 1px solid rgba(0,0,0,0.03);
            box-shadow: 0 10px 30px -10px rgba(0,0,0,0.04);
            margin-bottom: 2.5rem;
        }

        .avatar-main {
            width: 130px; height: 130px;
            object-fit: cover; border-radius: 35px;
            border: 4px solid #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        /* --- Order Cards --- */
        .order-item {
            background: var(--surface);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .order-item:hover {
            border-color: var(--primary-accent);
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -12px rgba(79, 70, 229, 0.15);
        }

        .order-id-box {
            background: #f1f5f9;
            padding: 6px 12px; border-radius: 8px;
            font-family: 'Monaco', monospace;
            font-weight: 700; font-size: 0.85rem;
        }

        .product-scroll-area {
            max-height: 160px;
            overflow-y: auto;
            padding-right: 8px;
        }

        /* --- Status Pills --- */
        .status-pill {
            padding: 6px 14px; border-radius: 10px;
            font-size: 0.75rem; font-weight: 700;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .status-pending { background: #fff7ed; color: #c2410c; }
        .status-delivered { background: #f0fdf4; color: #15803d; }
        .status-cancelled { background: #fef2f2; color: #b91c1c; }

        .btn-action {
            width: 44px; height: 44px;
            border-radius: 14px; display: flex;
            align-items: center; justify-content: center;
            background: #f1f5f9; color: var(--text-main);
            border: none; transition: 0.2s;
        }
        .btn-action:hover { background: var(--primary-accent); color: white; }

        /* --- Modal Enhancements --- */
        .modal-content { border-radius: 28px; border: none; }
        .modal-header { border-bottom: 1px solid #f1f5f9; padding: 1.5rem 2rem; }
        .product-card-inline {
            transition: 0.2s;
            background: #fff;
            border: 1px solid #f1f5f9;
        }
        .product-card-inline:hover {
            border-color: var(--primary-accent);
            background: #fcfcff;
        }
        @media print {
    /* Hide everything on the page */
    body * {
        visibility: hidden;
    }

    /* Target the specific modal that is open and its contents */
    .modal.show, 
    .modal.show * {
        visibility: visible;
    }

    /* Position the modal content at the very top of the printed page */
    .modal.show {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        margin: 0;
        padding: 0;
        border: none;
    }

    /* Remove shadows and extra margins for a clean paper look */
    .modal-content {
        box-shadow: none !important;
        border: none !important;
    }

    /* Hide the Close and Print buttons during the actual print */
    .modal-footer, .btn-close {
        display: none !important;
    }
}
    </style>
</head>
<body>

<div class="container py-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Account Dashboard</li>
            </ol>
        </nav>
        <form action="{{ route('clubmember.logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-pill btn shadow-sm">
                <i class="bi bi-power me-2"></i>Sign Out
            </button>
        </form>
    </div>

    <div class="hero-profile">
        <div class="row align-items-center">
            <div class="col-md-auto d-flex justify-content-center mb-4 mb-md-0">
                <div class="position-relative">
                    <img id="avatarPreview" 
                         src="{{ $member->image ? asset('storage/'.$member->image) : asset('assets/images/user/man_avatar3.jpg') }}" 
                         class="avatar-main">
                    <label for="imageUpload" class="upload-trigger" style="position: absolute; bottom: 0; right: 0; background: var(--primary-accent); color: white; width: 35px; height: 35px; border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 3px solid #fff; cursor: pointer;">
                        <i class="bi bi-camera-fill"></i>
                    </label>
                    <input type="file" id="imageUpload" style="display:none;" accept="image/*">
                </div>
            </div>
            <div class="col-md text-center text-md-start">
                <h2 class="fw-bold mb-1">{{ $member->name }}</h2>
                <p class="text-muted mb-3">{{ $member->email }}</p>
                <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2">
                    <span class="status-pill border bg-white text-dark small"><i class="bi bi-fingerprint text-primary"></i> ID: {{ $member->id }}</span>
                    <span class="status-pill border bg-white text-dark small"><i class="bi bi-patch-check-fill text-success"></i> Active Member</span>
                </div>
            </div>
        </div>
    </div>

    <h4 class="fw-bold mb-4 px-2">Order History</h4>

    <div class="order-card-wrap">
        @foreach($orders as $order)
        <div class="order-item shadow-sm">
            <div class="row g-4 align-items-center">
                
                <div class="col-md-2 text-center text-md-start">
                    <span class="order-id-box text-primary d-inline-block mb-2">ORD-{{ $order->id }}</span>
                    <div class="text-muted small"><i class="bi bi-calendar3 me-1"></i> {{ $order->created_at ? $order->created_at->format('d M Y') : '29 Mar 2026' }}</div>
                </div>

                <div class="col-md-5">
                    <div class="product-scroll-area">
                        @forelse($order->items ?? [] as $item)
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom border-light">
                            <div>
                                <p class="mb-0 fw-bold small text-truncate" style="max-width: 200px;">{{ $item->product->name ?? 'Product #'.$item->product_id }}</p>
                                <small class="text-muted">Qty: {{ $item->quantity }}</small>
                            </div>
                            <span class="fw-bold small text-dark">₹{{ number_format($item->total, 2) }}</span>
                        </div>
                        @empty
                        <p class="text-muted small m-0">No items found.</p>
                        @endforelse
                    </div>
                </div>

                <div class="col-md-3 text-center">
                    <div class="mb-2">
                        <span class="fs-4 fw-bold text-dark">₹{{ number_format($order->total_amount, 2) }}</span>
                        <small class="text-muted d-block small" style="margin-top: -4px;">Grand Total</small>
                    </div>
                    @php
                        $statusData = [
                            1 => ['class' => 'status-pending', 'label' => 'Pending', 'icon' => 'bi-clock'],
                            2 => ['class' => 'status-delivered', 'label' => 'Delivered', 'icon' => 'bi-check2-circle'],
                            7 => ['class' => 'status-delivered', 'label' => 'Delivered', 'icon' => 'bi-check-circle']
                        ];
                        $curr = $statusData[$order->order_status_id] ?? $statusData[1];
                    @endphp
                    <span class="status-pill {{ $curr['class'] }}">
                        <i class="bi {{ $curr['icon'] }}"></i> {{ $curr['label'] }}
                    </span>
                </div>

                <div class="col-md-2 d-flex justify-content-center justify-content-md-end">
                    <button class="btn-action shadow-sm" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                        <i class="bi bi-arrow-right-short fs-4"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content shadow-lg">
                    <div class="modal-header border-0 bg-light px-4 py-3">
                        <div>
                            <h5 class="fw-bold mb-0">Order #{{ $order->id }}</h5>
                            <small class="text-muted">{{ $order->created_at ? $order->created_at->format('F d, Y') : 'March 29, 2026' }}</small>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-4 py-4">
                        <div class="row g-3">
                            @forelse($order->items as $item)
                            <div class="col-12">
                                <div class="d-flex align-items-center p-3 rounded-4 product-card-inline">
                                    <img src="{{ ($item->variant && $item->variant->image) ? asset('storage/'.$item->variant->image) : (($item->product && $item->product->image) ? asset('storage/'.$item->product->image) : asset('assets/images/no-image.png')) }}" 
                                         style="width:70px; height:70px; object-fit:cover; border-radius:15px;" class="me-3 border">
                                    
                                    <div class="flex-grow-1">
                                        <p class="mb-0 fw-bold text-dark">{{ $item->product->name ?? 'Product #'.$item->product_id }}</p>
                                        <div class="d-flex gap-3">
                                            <small class="text-muted">SKU: {{ $item->variant_id ?? 'STD-'.$item->product_id }}</small>
                                            <small class="text-muted">Qty: <strong>{{ $item->quantity }}</strong></small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <p class="mb-0 fw-bold text-primary">₹{{ number_format($item->total, 2) }}</p>
                                        <small class="text-muted">₹{{ number_format($item->price, 2) }}/unit</small>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center py-4">
                                <i class="bi bi-cart-x fs-1 text-muted"></i>
                                <p class="text-muted">No items found.</p>
                            </div>
                            @endforelse
                        </div>

                        <div class="mt-4 p-4 bg-light rounded-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small text-uppercase fw-bold">Payment Status</span>
                                <span class="badge {{ $curr['class'] }} rounded-pill px-3">{{ $curr['label'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-2">
                                <span class="fw-bold text-dark">Amount Payable</span>
                                <span class="fw-bold text-primary fs-4">₹{{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 px-4 pb-4 pt-0">
                        <button type="button" class="btn btn-light rounded-3 px-4 fw-bold" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary rounded-3 px-4 fw-bold shadow-sm" onclick="window.print()">
    <i class="bi bi-printer me-2"></i> Print Invoice
</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('imageUpload').addEventListener('change', function(e){
        const file = e.target.files[0];
        if(file){
            const reader = new FileReader();
            reader.onload = ev => document.getElementById('avatarPreview').src = ev.target.result;
            reader.readAsDataURL(file);
        }
    });
</script>
</body>
</html>