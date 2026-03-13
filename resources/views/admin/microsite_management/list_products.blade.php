@extends('admin.components.app')
@section('page-title', 'Products of ' . $microsite->name)

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
                    <i class="bi bi-people-fill small me-2"></i> {{ $microsite->club->name }}
                </a>
            </li>
            <li class="breadcrumb-item active">
                <i class="bi bi-box-seam small me-2"></i> Products of {{ $microsite->name }}
            </li>
        </ol>
    </nav>
</div>

<div class="row">
    {{-- Sidebar --}}
    @include('admin.club.side_bar')

    <div class="col-md-9">

        {{-- Microsite Products --}}
        <div class="row g-3 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Products Added to Microsite</h4>
                <select id="micrositeCategoryFilter" class="form-select w-auto">
                    <option value="all">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="micrositeProductsContainer" class="row g-3">
                @foreach($micrositeProducts as $product)
                    <div class="col-md-4 microsite-product" data-category="{{ $product->category_id }}">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ $product->variant_image ? Storage::url($product->variant_image) : asset('images/no-image.png') }}"
                                 class="card-img-top" alt="{{ $product->name }}" style="height:200px; object-fit:cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ Str::limit($product->description,60) }}</p>
                                <div class="mt-auto d-flex justify-content-end">
                                    <form action="{{ route('admin.microsite.remove_product') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="microsite_product_id" value="{{ $product->microsite_product_id }}">
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-4 shadow-sm">
                                            <i class="fas fa-trash-alt me-2"></i> Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Empty message always present --}}
                <div class="col-12 microsite-empty-message" style="display:none">
                    <div class="alert alert-warning text-center">No products found in this category.</div>
                </div>
            </div>
        </div>

        {{-- Available Products --}}
        <div class="row g-3 mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Available Products</h4>
                <select id="availableCategoryFilter" class="form-select w-auto">
                    <option value="all">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="availableProductsContainer" class="row g-3">
                @foreach($products as $product)
                    <div class="col-md-4 product-card" data-category="{{ $product->category_id }}">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ $product->variant_image ? Storage::url($product->variant_image) : asset('sample/1000129303.png') }}"
                                 class="card-img-top" alt="{{ $product->name }}" style="height:200px; object-fit:cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ Str::limit($product->description,60) }}</p>
                                <div class="mt-auto d-flex justify-content-end">
                                    <form action="{{ route('admin.microsite.add_product') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="microsite_id" value="{{ $microsite->id }}">
                                        <input type="hidden" name="club_id" value="{{ $club->id }}">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="btn btn-outline-success btn-sm rounded-pill px-4">
                                            <i class="fas fa-plus me-1"></i> Add
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Empty message always present --}}
                <div class="col-12 available-empty-message" style="display:none">
                    <div class="alert alert-warning text-center">No products found in this category.</div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('script')
<script>
document.addEventListener("DOMContentLoaded", function () {

    function applyFilter(filterEl, productSelector, emptyMessageSelector) {
        const selected = filterEl.value.trim();
        const products = document.querySelectorAll(productSelector);
        let visibleCount = 0;

        products.forEach(product => {
            const category = product.dataset.category?.trim();
            if(selected === "all" || selected == category) {
                product.style.display = "block";
                visibleCount++;
            } else {
                product.style.display = "none";
            }
        });

        // Show or hide "No products found" message dynamically
        const emptyMsg = document.querySelector(emptyMessageSelector);
        if(emptyMsg) {
            emptyMsg.style.display = visibleCount === 0 ? "block" : "none";
        }
    }

    // Microsite Products Filter
    const micrositeFilter = document.getElementById("micrositeCategoryFilter");
    if (micrositeFilter) {
        micrositeFilter.addEventListener("change", function () {
            applyFilter(this, ".microsite-product", ".microsite-empty-message");
        });
    }

    // Available Products Filter
    const availableFilter = document.getElementById("availableCategoryFilter");
    if (availableFilter) {
        availableFilter.addEventListener("change", function () {
            applyFilter(this, ".product-card", ".available-empty-message");
        });
    }

});
</script>
@endsection