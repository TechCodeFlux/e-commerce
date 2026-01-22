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
            <button class="btn btn-outline-light" type="button" id="button-addon1">
                <i class="bi bi-search"></i>
            </button>
            <input type="text" class="form-control" placeholder="Search..."
                   aria-label="Example text with button addon" aria-describedby="button-addon1">
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

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0">
                    {{-- @include('clubmember.product.cart') --}}
                    <h6 class="m-0 px-4 py-3 border-bottom">My Cart</h6>
                    <div class="dropdown-menu-body">
                        
                    @forelse($cartItems as $item)
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex align-items-center">

                                

                                <!-- Image --> 
                                <a href="#" class="me-3 flex-shrink-0">
                                    <img src="{{ url('storage/' . $item->image) }}"
                                        class="rounded" width="60" alt="">
                                </a>

                                <!-- Details -->
                                <div>
                                    <h6 class="mb-1">{{ $item->name }}</h6>
                                    <div>
                                    Description: {{ $item->description }}    
                                    </div>
                                    <div>
                                    Quantity: {{ $item->quantity }}    
                                    </div>
                                </div>
                                <!-- Remove -->
                                <a href={{ route('clubmember.delete' ,$item->id) }}
                                class="text-danger me-3" title="Remove">
                                    <i class="bi bi-trash"></i>
                                </a> 

                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted py-3">
                            Cart is empty
                        </p>
                    @endforelse

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
