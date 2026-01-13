@extends('club.components.app')

@section('content')
 <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            
        }

        .product-list-item {
            transition: all 0.2s ease-in-out;       
            border-radius: 12px;
            background: white;
            border: 1px solid #dee2e6;
            margin-bottom: 1rem;
        }

        .product-list-item:hover {
            border-color: #da7527;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .product-img-wrapper {
            width: 120px;
            height: 120px;
            overflow: hidden;
            border-radius: 8px;
            background: #f8f9fa;
        }

        .product-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .badge-category {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 4px;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .product-list-item {
                text-align: center;
                flex-direction: column !important;
            }
            .product-img-wrapper {
                width: 100%;
                height: 200px;
            }
        }
    </style>
<div class="product-list col-11 m-4">
            
            <!-- Row 1 -->
            @foreach ($products as $product)
            <div class="product-list-item p-3 d-flex flex-row align-items-center gap-4">
                <div class="product-img-wrapper flex-shrink-0">
                    <img src="{{  asset('storage/'.$product->image) }}" width="100" alt="Product Image">
                </div>
                    
                        
                   
                <div class="flex-grow-1 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge bg-primary-subtle text-primary badge-category">Electronics</span>
                            <small class="text-muted">ID: #88219</small>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">{{ $product->name }}</h5>
                        <p class="text-muted small mb-0 d-none d-md-block" style="max-width: 400px;">
                            {{$product->description}}
                        </p>
                    </div>

                    <div class="d-flex align-items-center gap-4">
                        <div class="d-none d-lg-block text-end h6 p-3">
                            <label class="d-block text-uppercase text-muted fw-bold mb-0" style="font-size: 9px; letter-spacing: 1px;">Stock</label>
                            <span class="fw-semibold text-success small">{{$product->stock}} in stock</span>
                        </div>
                        
                        <div class="d-flex gap-1">
                            <form>
                            <button class="btn btn-link text-muted p-1" title="Edit"><i class="bi bi-pencil-square h4"></i></button>
                            </form>
                            <form action="{{route('club.destroy_products', $product->id)}}"  method="POST">
                                @csrf 
                            <button class="btn btn-link text-danger p-1" title="Delete"><i class="bi bi-trash h4"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
 @endforeach
           

        </div>
@endsection

