<!-- layout-wrapper -->
<div class="layout-wrapper">

    <!-- header -->
    <div class="header">
    <div class="menu-toggle-btn"> <!-- Menu close button for mobile devices -->
        <a href="#">
            <i class="bi bi-list"></i>
        </a>
    </div>
    <!-- Logo -->
    <a href="index.html" class="logo">
        <img width="100" src="{{url('assets/images/logo.svg')}}" alt="logo">
    </a>
    <!-- ./ Logo -->
    <div class="page-title">Overview</div>
    <form class="search-form">
        <div class="input-group">
            <button class="btn btn-outline-light" type="button">
                <i class="bi bi-search"></i>
            </button>

            <input type="text"
                class="form-control searchInput"
                placeholder="Search...">

            <a href="#" class="btn btn-outline-light close-header-search-bar">
                <i class="bi bi-x"></i>
            </a>
        </div>
    </form>
    <div class="header-bar ms-auto">
        <ul class="navbar-nav justify-content-end">
            {{-- <li class="nav-item">
                <a href="#" class="nav-link nav-link-notify" data-count="2" data-sidebar-target="#notifications">
                    <i class="bi bi-bell icon-lg"></i>
                </a> --}}
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link nav-link-notify" data-count="{{ $cartItemCount }}" data-bs-toggle="dropdown">
                    <i class="bi bi-cart2 icon-lg"></i>
                </a> 
                   
                <!-- cart view dropdrown -->
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0 shadow-lg rounded-3" style="width: 350px;">

                        <!-- Header -->
                        <div class="px-4 py-3 border-bottom ">
                            <h6 class="m-0 fw-bold">🛒 My Cart</h6>
                        </div>

                        <!-- Cart Items -->
                        <div style="max-height: 300px; overflow-y: auto;">
                            
                            @forelse($cartItems as $item)
                                <div class="d-flex align-items-center px-3 py-3 border-bottom">
                                     
                                    <!-- Image -->
                                    <img src="{{ url('storage/' . $item->varient->image) }}"
                                        class="rounded shadow-sm me-3"
                                        width="60" height="60" style="object-fit: cover;">

                                    <!-- Details -->
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bold">{{ $item->name }}</h6>

                                        <small class="text-muted d-block">
                                            Qty: {{ $item->quantity }}
                                        </small>

                                        <span class="text-danger fw-bold fs-6">
                                            ₹{{ $item->price }}
                                        </span>
                                    </div>

                                    <!-- Actions -->
                                    <div class="text-end">
                                        <!-- Delete -->
                                        <a href="{{ route('clubmember.delete' ,$item->id) }}" 
                                        class="text-danger d-block mb-2"
                                        title="Remove">
                                            <i class="bi bi-trash fs-5"></i>
                                        </a>

                                        <!-- Buy -->
                                       <!-- <a href="{{ route('clubmember.order', $item->product_id ?? 0) }}"
                                        class="btn btn-sm btn-success">
                                            Buy
                                        </a> -->
                                    </div>

                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">
                                    🛒 Cart is empty
                                </div>
                            @endforelse
                        </div>

                        <!-- Footer -->
                        <div class="px-3 py-3 border-top ">

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold">Total:</span>
                                <span class="text-danger fw-bold fs-5">
                                    ₹{{ $total_price ?? 0 }}
                                </span>
                            </div>

                            @if(!empty($multipleproductids))
                                <a href="{{ route('clubmember.order', $multipleproductids) }}" 
                                class="btn btn-primary w-100 fw-bold">
                                    Checkout
                                </a>
                            @else
                                <button class="btn btn-secondary w-100" disabled>
                                    Checkout
                                </button>
                            @endif
                        </div>

                    </div> 
                    
                    
                    
            </li> 
            {{-- <li class="nav-item ms-3">
                    <button class="btn btn-primary btn-icon">
        <i class="bi bi-plus-circle"></i> Add Product
    </button>
            </li> --}}
        </ul>
    </div>
    <!-- Header mobile buttons -->
    <div class="header-mobile-buttons">
        <a href="#" class="search-bar-btn">
            <i class="bi bi-search"></i>
        </a>
        <a href="#" class="actions-btn">
            <i class="bi bi-three-dots"></i>
        </a>
    </div>
    <!-- ./ Header mobile buttons -->
</div>
    <!-- ./ header -->
