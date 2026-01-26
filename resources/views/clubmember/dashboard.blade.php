@extends('clubmember.components.app')

@section('content')

<div class="content">
    <div class="row g-4">

        <!-- Product 1 -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100">
                <img
                    src="{{ asset('assets/images/products/jersey.jpg') }}"
                    class="card-img-top product-card-img"
                    alt="Golf Jersey Pro Fit"
                >
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title">Golf Jersey Pro Fit</h6>
                    <div class="mb-2">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star text-muted"></i>
                        <span class="ms-1">(4.0)</span>
                    </div>
                    <p class="mb-1"><strong>Sizes:</strong> XS, S, M, L, XL, XXL, XXXL</p>
                    <p class="mb-1"><strong>Color:</strong> Black, White, Navy Blue</p>
                    <p class="mb-1"><strong>Material:</strong> Polyester</p>
                    <p class="mb-2"><strong>Description:</strong> Lightweight golf jersey perfect for warm weather. Breathable polyester fabric keeps you cool. Sleek design with a comfortable fit for all-day wear.</p>
                    <a href="#" class="btn btn-primary btn-sm mt-auto">Add to Cart</a>
                </div>
            </div>
        </div>

        <!-- Product 3 -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100">
                <img
                    src="{{ asset('assets/images/products/jack.jpg') }}"
                    class="card-img-top product-card-img"
                    alt="Winter Sports Jacket"
                >
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title">Winter Sports Jacket</h6>
                    <div class="mb-2">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <span class="ms-1">(5.0)</span>
                    </div>
                    <p class="mb-1"><strong>Sizes:</strong> M, L, XL, XXL</p>
                    <p class="mb-1"><strong>Color:</strong> Black, Olive Green</p>
                    <p class="mb-1"><strong>Material:</strong> Nylon</p>
                    <p class="mb-2"><strong>Description:</strong> Durable winter jacket designed for outdoor sports. Keeps you warm in cold weather. Features a water-resistant finish and comfortable fit.</p>
                    <a href="#" class="btn btn-primary btn-sm mt-auto">Add to Cart</a>
                </div>
            </div>
        </div>

        <!-- Product 4: Golf Shoes -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100">
                <img
                    src="{{ asset('assets/images/products/shoes.jpg') }}"
                    class="card-img-top product-card-img"
                    alt="Pro Golf Shoes"
                >
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title">Pro Golf Shoes</h6>
                    <div class="mb-2">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star text-muted"></i>
                        <i class="bi bi-star text-muted"></i>
                        <span class="ms-1">(3.5)</span>
                    </div>
                    <p class="mb-1"><strong>Sizes:</strong> 6, 7, 8, 9, 10, 11</p>
                    <p class="mb-1"><strong>Color:</strong> White, Black</p>
                    <p class="mb-1"><strong>Material:</strong> Leather</p>
                    <p class="mb-2"><strong>Description:</strong> High-performance golf shoes with excellent grip. Premium leather for durability and comfort. Perfect for long hours on the course.</p>
                    <a href="#" class="btn btn-primary btn-sm mt-auto">Add to Cart</a>
                </div>
            </div>
        </div>

        <!-- Product 5: Sports Bag -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100">
                <img
                    src="{{ asset('assets/images/products/bag.jpg') }}"
                    class="card-img-top product-card-img"
                    alt="Golf Sports Bag"
                >
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title">Golf Sports Bag</h6>
                    <div class="mb-2">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star text-muted"></i>
                        <span class="ms-1">(4.0)</span>
                    </div>
                    <p class="mb-1"><strong>Color:</strong> Black, Navy Blue</p>
                    <p class="mb-1"><strong>Material:</strong> Nylon</p>
                    <p class="mb-2"><strong>Description:</strong> Spacious sports bag for all your golf gear. Multiple compartments for easy organization. Durable nylon material ensures long-lasting use.</p>
                    <a href="#" class="btn btn-primary btn-sm mt-auto">Add to Cart</a>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
