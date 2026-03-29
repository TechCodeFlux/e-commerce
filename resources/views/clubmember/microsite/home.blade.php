<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $microsite->name }} | Exclusive Collection</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #0d6efd; /* Adjust this to your club's brand color */
            --glass-bg: rgba(255, 255, 255, 0.95);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            --accent-font: 'Inter', sans-serif;
        }

        body {
            font-family: var(--accent-font);
            background-color: #f8f9fa;
            color: #2d3436;
        }

        /* --- Header & Nav --- */
        .header_area {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .navbar-brand img {
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover img {
            transform: scale(1.05);
        }

        .nav-link {
            font-weight: 600;
            color: #2d3436 !important;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
            padding: 10px 20px !important;
        }

        /* --- Banner --- */
        .banner-card {
            position: relative;
            aspect-ratio: 21 / 8;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
        }

        .banner-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 6s ease;
        }

        .banner-card:hover img {
            transform: scale(1.1);
        }

        /* --- Description Section --- */
        .description-card {
            border: none;
            border-radius: 24px;
            background: white;
            box-shadow: var(--card-shadow);
            position: relative;
            top: -40px; /* Slight overlap for premium depth */
            z-index: 5;
        }

        /* --- Product Section --- */
        .section-title {
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background: var(--primary-color);
        }

        .product-card-wrapper {
            border-radius: 18px;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            background: #fff;
            border: 1px solid rgba(0,0,0,0.03);
        }

        .product-card-wrapper:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
        }

        .product-overlay {
            position: absolute;
            bottom: -50px; /* Hidden initially */
            left: 0;
            width: 100%;
            padding: 20px;
            background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            opacity: 0;
        }

        .product-card-wrapper:hover .product-overlay {
            bottom: 0;
            opacity: 1;
        }

        /* --- Variant Size Boxes --- */
        .size-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 18px;
            border: 2px solid #eee;
            margin: 5px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.2s;
        }

        .size-box:hover:not(.disabled) {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .size-box.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .size-box.disabled {
            background: #f8f9fa;
            color: #ccc;
            border-color: #eee;
            text-decoration: line-through;
            cursor: not-allowed;
        }

        /* --- Modals --- */
        .modal-content {
            border: none;
            border-radius: 24px;
        }

        .modal-img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 18px;
        }

        @keyframes pop {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</head>

<body>

    <header class="header_area sticky-top">
        <nav class="navbar navbar-expand-lg py-3">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="{{ Storage::url($club->image) }}" alt="{{ $club->name }}" 
                         style="height:45px; width:45px; object-fit: cover; border-radius:50%;" class="me-2">
                    <span class="fw-bold tracking-tight text-uppercase" style="font-size: 1.1rem;">{{ $club->name }}</span>
                </a>
                
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="fas fa-bars"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item"><a class="nav-link px-3" href="#">Home</a></li>
                        <li class="nav-item">
                            <a class="nav-link px-3 position-relative" href="{{ route('clubmember.microsite.carts', $microsite->slug) }}">
                                Cart <i class="fas fa-shopping-bag ms-1"></i>
                            </a>
                        </li>
                        <li class="nav-item ms-lg-3">
                            <form action="{{ route('microsite.logout', $microsite->slug) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-dark btn-sm px-4 rounded-pill fw-bold">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section class="banner-area mt-4">
        <div class="container">
            <div class="banner-card">
                @if($microsite && $microsite->image)
                    <img src="{{ Storage::url($microsite->image) }}" alt="Premium Banner">
                @else
                    <img src="{{ asset('img/banner/banner-img.png') }}" alt="Default Banner">
                @endif
            </div>
        </div>
    </section>

    <section class="description-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="description-card p-4 p-md-5">
                        <h2 class="h4 fw-bold mb-3 text-dark">Welcome to {{ $microsite->name }}</h2>
                        <div class="description-content text-muted lh-lg mb-0">
                            @if($microsite && $microsite->description)
                                {!! nl2br(e($microsite->description)) !!}
                            @else
                                <p class="fst-italic">Tailored experiences and premium products curated just for you.</p>
                            @endif
                        </div>
                        @if($microsite->category)
                            <div class="mt-4">
                                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-normal">
                                    <i class="fas fa-tag me-1 text-primary"></i> {{ $microsite->category }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="product-area pb-5">
        <div class="container">
            <div class="row mb-5 align-items-end">
                <div class="col-md-6">
                    <h3 class="section-title fw-bold">Exclusive Products</h3>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end">
                    <div class="filter-wrapper bg-white p-2 rounded-pill shadow-sm d-flex align-items-center border">
                        <i class="fas fa-sliders-h ms-3 text-muted"></i>
                        <select id="categoryFilter" class="form-select border-0 shadow-none bg-transparent fw-bold" style="cursor:pointer">
                            <option value="all">All Collections</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row g-4" id="productContainer">
                @forelse($micrositeProducts as $product)
                    @php
                        $variant = DB::table('varients')->where('product_id', $product->id)->first();
                    @endphp

                    <div class="col-lg-3 col-md-4 col-sm-6 product-item" data-category="{{ $product->category_id }}">
                        <div class="card h-100 product-card-wrapper border-0 overflow-hidden">
                            <div class="position-relative overflow-hidden" style="height: 280px;">
                                <img src="{{ $variant ? Storage::url($variant->image) : asset('img/product/p1.jpg') }}"
                                     class="w-100 h-100" style="object-fit: cover;" alt="{{ $product->name }}">
                                
                                <div class="product-overlay">
                                    <button class="btn btn-white bg-white text-dark fw-bold rounded-pill px-4 shadow viewProductBtn" 
                                            data-product="{{ $product->id }}">
                                        Quick View
                                    </button>
                                </div>
                            </div>

                            <div class="card-body p-4 text-center">
                                <h6 class="fw-bold mb-2">{{ $product->name }}</h6>
                                <p class="text-muted small mb-0">{{ \Illuminate\Support\Str::limit($product->description, 50) }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">No products available at this time.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <div class="modal fade" id="variantModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content overflow-hidden">
                <div class="modal-body p-0">
                    <div class="row g-0">
                        <div class="col-md-6">
                            <img id="modalImage" class="modal-img rounded-0" src="" alt="">
                        </div>
                        <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                            <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal"></button>
                            <h3 id="modalName" class="fw-bold mb-3"></h3>
                            <p id="modalDesc" class="text-muted lh-base mb-4"></p>

                            <label class="fw-bold small text-uppercase tracking-wider mb-2">Available Options</label>
                            <div id="sizeContainer" class="mb-4"></div>

                            <div id="stockText" class="mb-4 fw-bold"></div>

                            <button id="addToCartBtn" class="btn btn-dark btn-lg w-100 rounded-pill py-3 fw-bold" disabled>
                                SELECT OPTION
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cartSuccessModal" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content text-center p-4">
                <div class="py-3">
                    <i class="fa fa-circle-check text-success fa-4x mb-3" style="animation: pop 0.4s ease;"></i>
                    <h5 class="fw-bold">Added to Cart</h5>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
    const micrositeSlug = "{{ $microsite->slug }}";
    
    // Initialize Modals properly for BS5
    const variantModal = new bootstrap.Modal(document.getElementById('variantModal'));
    const cartSuccessModal = new bootstrap.Modal(document.getElementById('cartSuccessModal'));

    // --- Category Filter ---
    $('#categoryFilter').on('change', function() {
        let val = $(this).val();
        $('.product-item').each(function() {
            (val === 'all' || $(this).data('category') == val) ? $(this).fadeIn(300) : $(this).hide();
        });
    });

    // --- View Product (Opens Modal) ---
    $(document).on('click', '.viewProductBtn', function (e) {
        e.preventDefault();
        let productId = $(this).data('product');
        
        // Clear previous state
        $('#sizeContainer').html('<div class="spinner-border spinner-border-sm text-primary"></div>');
        $('#addToCartBtn').prop('disabled', true).text('SELECT OPTION');
        $('#stockText').text('');

        $.get(`/microsite-product-variants/${productId}`, function (data) {
            if (!data || data.length === 0) {
                alert("No variants available for this product.");
                return;
            }

            // Update Modal Content
            $('#modalName').text(data[0].product_name);
            $('#modalDesc').text(data[0].description);
            $('#modalImage').attr('src', data[0].image ? '/storage/' + data[0].image : '/img/product/p1.jpg');

            let variantsHtml = '';
            data.forEach(v => {
                let display = (v.size || '') + (v.color ? ' - ' + v.color : '');
                if(display.trim() == "") display = "Standard";

                variantsHtml += `
                    <div class="size-box ${v.stock <= 0 ? 'disabled' : ''}" 
                         data-id="${v.id}" 
                         data-stock="${v.stock}" 
                         data-image="${v.image}">
                        ${display}
                    </div>`;
            });

            $('#sizeContainer').html(variantsHtml);
            variantModal.show();
        }).fail(function() {
            alert("Error loading product details.");
        });
    });

    // --- Handle Variant Selection (Delegated Event) ---
    // This FIXES the "not working" issue by listening to the container, not the box itself.
    $(document).on('click', '.size-box', function() {
        if ($(this).hasClass('disabled')) return;

        // Visual toggle
        $('.size-box').removeClass('active');
        $(this).addClass('active');

        let stock = parseInt($(this).data('stock'));
        let variantId = $(this).data('id');
        let variantImg = $(this).data('image');

        // Update image if variant has a specific one
        if (variantImg) {
            $('#modalImage').attr('src', '/storage/' + variantImg);
        }

        // Update button and stock text
        if (stock > 0) {
            $('#stockText').html('<span class="text-success small fw-bold"><i class="fas fa-check-circle me-1"></i> In Stock</span>');
            $('#addToCartBtn')
                .prop('disabled', false)
                .text('ADD TO CART')
                .data('variant-id', variantId) // Store ID for the cart push
                .removeClass('btn-dark')
                .addClass('btn-primary');
        } else {
            $('#stockText').html('<span class="text-danger small fw-bold">Out of Stock</span>');
            $('#addToCartBtn').prop('disabled', true).text('OUT OF STOCK').addClass('btn-dark').removeClass('btn-primary');
        }
    });

    // --- Add to Cart Action ---
    $('#addToCartBtn').on('click', function () {
        let variantId = $(this).data('variant-id');
        if (!variantId) return;

        $(this).prop('disabled', true).text('Processing...');

        $.ajax({
            url: `/microsite/${micrositeSlug}/add-to-cart`,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                variant_id: variantId,
                quantity: 1
            },
            success: function (res) {
                variantModal.hide();
                cartSuccessModal.show();
                setTimeout(() => cartSuccessModal.hide(), 2000);
            },
            error: function (err) {
                alert("Could not add to cart. Please try again.");
                $('#addToCartBtn').prop('disabled', false).text('ADD TO CART');
            }
        });
    });
});
    </script>
</body>
</html>