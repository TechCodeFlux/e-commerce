<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $microsite->name }}</title>
    <link rel="icon" href="{{ Storage::url($club->image) }}">

    <link rel="stylesheet" href="{{ url('assets/micro/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ url('assets/micro/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/micro/css/main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .size-box {
            display: inline-block;
            padding: 8px 14px;
            border: 1px solid #ccc;
            margin: 4px;
            cursor: pointer;
            transition: 0.2s;
            min-width: 45px;
            text-align: center;
        }

        .size-box:hover {
            border-color: black;
        }

        .size-box.active {
            background: black;
            color: white;
            border-color: black;
        }

        .size-box.disabled {
            background: #eee;
            color: #999;
            cursor: not-allowed;
        }

        .modal-img {
            width: 100%;
            height: 320px;
            object-fit: cover;
            border-radius: 6px;
        }

        @keyframes pop {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="header_area sticky-header">
        <div class="main_menu">
            <nav class="navbar navbar-expand-lg navbar-light main_box">
                <div class="container">
                    <a class="navbar-brand logo_h" href="index.html">
                        <img src="img/logo.png" alt="">
                        <span class="ms-2 fw-bold">
                            <img src="{{ Storage::url($club->image) }}" alt="{{ $club->name }}" class="ms-2"
                                style="height:40px; width:auto; border-radius:50%;">
                            {{ $club->name }}
                        </span>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                        <ul class="nav navbar-nav menu_nav ml-auto">
                            <li class="nav-item active"><a class="nav-link" href="#">Home</a></li>
                            <li class="nav-item"><a class="nav-link"
                                    href="{{ route('clubmember.microsite.carts', $microsite->slug) }}">Cart</a></li>
                            <form action="{{ route('microsite.logout', $microsite->slug) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link" >
                                    Logout
                                </button>
                            </form>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Banner -->
    <section class="banner-area">
        <div class="banner-img">
            @if($microsite->image)
                <img class="img-fluid w-100" src="{{ Storage::url($microsite->image) }}" alt="Banner Image"
                    style="object-fit:cover; height:400px;">
            @else
                <img class="img-fluid w-100" src="img/banner/banner-img.png" alt="Default Banner"
                    style="object-fit:cover; height:400px;">
            @endif
        </div>
    </section>

    <!-- Products -->
    <section class="product-area section_gap">
        <div class="container">
            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <h3 class="mb-0">Products</h3>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <select id="categoryFilter" class="form-control w-auto">
                        <option value="all">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row" id="productContainer">
                @forelse($micrositeProducts as $product)
                    @php
                        $variant = DB::table('varients')->where('product_id', $product->id)->first();
                    @endphp

                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4 product-card"
                        data-category="{{ $product->category_id }}">
                        <div class="single-product">
                            <img class="img-fluid"
                                src="{{ $variant ? Storage::url($variant->image) : asset('img/product/p1.jpg') }}"
                                style="height:220px;object-fit:cover;width:100%;">

                            <div class="product-details">
                                <h6>{{ $product->name }}</h6>
                                <p style="font-size:13px;">
                                    {{ \Illuminate\Support\Str::limit($product->description, 60) }}
                                </p>

                                <div class="prd-bottom">
                                    {{-- <a href="javascript:void(0)" class="social-info">
                                        <span class="fas fa-shopping-bag"></span>
                                        <p class="hover-text">Add to cart</p>
                                    </a> --}}

                                    <a href="javascript:void(0)" class="social-info viewProductBtn"
                                        data-product="{{ $product->id }}">
                                        <span class="fas fa-eye"></span>
                                        <p class="hover-text">view more</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>No products available</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Variant Modal -->
    <div class="modal fade" id="variantModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Product Details</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img id="modalImage" class="modal-img">
                        </div>

                        <div class="col-md-6 d-flex flex-column justify-content-center">
                            <h4 id="modalName" class="mb-2"></h4>
                            <p class="text-muted" id="modalDesc"></p>

                            <h6 class="mt-3">Select Variant</h6>
                            <div id="sizeContainer"></div>

                            <p id="stockText" class="mt-2"></p>

                            <div class="mt-3">
                                <button id="addToCartBtn" class="btn btn-dark w-100" disabled>
                                    SELECT VARIANT
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <!-- Success Modal for add to cart -->
<div class="modal fade" id="cartSuccessModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-5">
                <div class="mb-3">
                    <div style="width:70px;height:70px;margin:auto;border-radius:50%;background:#28a745;display:flex;align-items:center;justify-content:center;animation: pop 0.3s ease;">
                        <i class="fa fa-check text-white" style="font-size:28px;"></i>
                    </div>
                </div>
                <h4 class="mb-2 font-weight-bold">Added to Cart</h4>
                <p class="text-muted mb-4">Your item has been successfully added.</p>
                <div class="d-flex justify-content-center gap-2">
                    <h4>Continue Shopping</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Success Modal -->
<div class="modal fade" id="orderSuccessModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
            <div class="modal-body">
                <i class="fa fa-check-circle text-success" style="font-size:50px;"></i>
                <h4 class="mt-3">Success</h4>
                <p>{{ session('success') }}</p>
                
            </div>
        </div>
    </div>
</div>
    <!-- Scripts -->
    <script src="{{ url('assets/micro/js/vendor/jquery-2.2.4.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {

            const micrositeSlug = "{{ $microsite->slug }}";

            // Category filter
            $('#categoryFilter').change(function () {
                const selected = $(this).val();
                $('.product-card').each(function () {
                    const category = $(this).data('category');
                    $(this).toggle(selected === 'all' || selected == category);
                });
            });

            // View product
            $(document).on('click', '.viewProductBtn', function () {
                let productId = $(this).data('product');

                $.get(`/microsite-product-variants/${productId}`, function (data) {
                    if (!data || data.length === 0) {
                        alert("No variants found");
                        return;
                    }

                    $('#modalName').text(data[0].product_name);
                    $('#modalDesc').text(data[0].description);
                    $('#modalImage').attr('src', data[0].image ? '/storage/' + data[0].image : '/img/product/p1.jpg');

                    let variantsHtml = '';
                    data.forEach(v => {
                        variantsHtml += `<div class="size-box ${v.stock <= 0 ? 'disabled' : ''}" data-id="${v.id}" data-stock="${v.stock}" data-image="${v.image}">${v.size ?? '-'} - ${v.color ?? '-'}</div>`;
                    });

                    $('#sizeContainer').html(variantsHtml);
                    $('#stockText').text('');
                    $('#addToCartBtn').prop('disabled', true).text('SELECT VARIANT');

                    $('.size-box').click(function () {
                        if ($(this).hasClass('disabled')) return;
                        $('.size-box').removeClass('active');
                        $(this).addClass('active');

                        let stock = $(this).data('stock');
                        let variantId = $(this).data('id');
                        let image = $(this).data('image');

                        if (image) $('#modalImage').attr('src', '/storage/' + image);

                        if (stock > 0) {
                            $('#stockText').html('<span class="text-success">In Stock</span>');
                            $('#addToCartBtn').prop('disabled', false).text('ADD TO CART').data('variant', variantId);
                        } else {
                            $('#stockText').html('<span class="text-danger">Out of Stock</span>');
                            $('#addToCartBtn').prop('disabled', true).text('OUT OF STOCK');
                        }
                    });

                    $('#variantModal').modal('show');
                });
            });

            // Add to cart
    $('#addToCartBtn').click(function () {
        let variantId = $(this).data('variant');
        if (!variantId) return alert("Please select a variant");

        $.ajax({
            url: `/microsite/${micrositeSlug}/add-to-cart`,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                variant_id: variantId,
                quantity: 1
            },
            success: function (res) {
                $('#variantModal').modal('hide');

                var cartModal = new bootstrap.Modal(document.getElementById('cartSuccessModal'));
                cartModal.show();

                setTimeout(function () {
                    cartModal.hide(); // ✅ FIXED
                }, 2000);
            },
            error: function (err) {
                console.error(err);
                alert("Error adding to cart: " + (err.responseJSON?.error || err.responseText));
            }
        });
    });

});

// Order success modal
document.addEventListener("DOMContentLoaded", function () {
    @if(session('success'))
        var orderModalEl = document.getElementById('orderSuccessModal');
        var orderModal = new bootstrap.Modal(orderModalEl);

        orderModal.show();

        // ✅ Auto close after 3 seconds
        setTimeout(function () {
            orderModal.hide();

            // OPTIONAL: redirect after close
            window.location.href = "{{ route('microsite.home', $microsite->slug) }}";
        }, 3000);

    @endif
});
    </script>
</body>

</html>