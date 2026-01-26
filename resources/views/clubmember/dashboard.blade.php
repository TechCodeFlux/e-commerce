@extends('clubmember.components.app')

@section('content')

<div class="content">

    <div class="row g-4">

        <!-- Product 1 -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100">
                <img src="{{ asset('assets/images/products/jersey.jpg') }}" class="card-img-top" alt="Golf Jersey Pro Fit">
                <div class="card-body">
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
                    <p class="mb-0"><strong>Reviews:</strong> 128 Reviews</p>
                </div>
            </div>
        </div>

        <!-- Product 2 -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100">
                <img src="{{ asset('assets/images/products/golf-tshirt.jpg') }}" class="card-img-top" alt="Premium Golf T-Shirt">
                <div class="card-body">
                    <h6 class="card-title">Premium Golf T-Shirt</h6>
                    <div class="mb-2">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star text-muted"></i>
                        <i class="bi bi-star text-muted"></i>
                        <span class="ms-1">(3.0)</span>
                    </div>
                    <p class="mb-1"><strong>Sizes:</strong> S, M, L, XL, XXL</p>
                    <p class="mb-1"><strong>Color:</strong> Red, Grey</p>
                    <p class="mb-1"><strong>Material:</strong> Cotton Blend</p>
                    <p class="mb-0"><strong>Reviews:</strong> 76 Reviews</p>
                </div>
            </div>
        </div>

        <!-- Product 3 -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100">
                <img src="{{ asset('assets/images/products/jacket.jpg') }}" class="card-img-top" alt="Winter Sports Jacket">
                <div class="card-body">
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
                    <p class="mb-0"><strong>Reviews:</strong> 214 Reviews</p>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
