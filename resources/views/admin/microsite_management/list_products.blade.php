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
            <li class="breadcrumb-item active" aria-current="page">
                <i class="bi bi-box-seam small me-2"></i> Products of {{ $microsite->name }}
            </li>
        </ol>
    </nav>
</div>

<div class="row">
    {{-- Sidebar --}}
    @include('admin.club.side_bar')

    {{-- Main content: products list --}}
    <div class="col-md-9">
        <div class="row g-3">
            <h3>Add Products</h3>
            @forelse($micrositeProducts  as $product)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ Storage::url($product->image) }}" 
                             class="card-img-top" 
                             alt="{{ $product->name }}" 
                             style="height:200px; object-fit:cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 60) }}</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="fw-bold">₹{{ $product->price }}</span>
                                <a href="{{ route('admin.product_management.edit_products_index', $product->id) }}" 
                                   class="btn btn-sm btn-outline-secondary">
                                   <i class="fas fa-trash"></i> Remove
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        No products found for this microsite.
                    </div>
                </div>
            @endforelse
        </div>


        {{-- Products List --}}
<div class="row g-3 mt-3">
    <h3>Available Products</h3>
    @forelse($products as $product)
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ Storage::url($product->image) }}" 
                     class="card-img-top" 
                     alt="{{ $product->name }}" 
                     style="height:200px; object-fit:cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ Str::limit($product->description, 60) }}</p>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <span class="fw-bold">₹{{ $product->price }}</span>
                        <a href="{{ route('admin.product_management.edit_products_index', $product->id) }}" 
                           class="btn btn-sm btn-outline-secondary">
                           <i class="fas fa-plus"></i> Add
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-warning text-center">
                No products have been added for this microsite yet.
            </div>
        </div>
    @endforelse
</div>
    </div>
</div>

@endsection