@extends('club.components.app')

@section('content')
<div class="container py-4 d-flex justify-content-center">
  <div class="form-container w-100">
    <!-- Compact Heading -->
    <div class="form-header mb-3">
      <h4 class="fw-bold m-0" style="color: #1a1a1a;">Add Product</h4>
      <p class="text-muted small mb-0">Enter details to list a new item</p>
    </div>
    
    <form class="col-12" action="{{route('club.add_products')}}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="form-group mb-3">
        <label class="form-label">Product Name</label>
        <input class="rounded-2 input-box w-100" type="text" name="name" placeholder="Name" required minlength="2">
      </div>

      <div class="form-group mb-3">
        <label class="form-label">Stock Quantity</label>
        <input class="rounded-2 input-box no-arrow w-100" type="number" name="stock" placeholder="0" minlength="0" required>
      </div>

      <div class="form-group mb-3">
        <label class="form-label">Description</label>
        <textarea class="rounded-2 input-box w-100" rows="3" name="description" placeholder="Description..." required minlength="5"></textarea>
      </div>

      <div class="form-group mb-3">
        <label class="form-label">Product Image</label>
        <div class="file-input-wrapper">
          <input class="form-control form-control-sm" type="file" name="image">
        </div>
      </div>

      <div class="pt-1">
        <button type="submit" class="btn-submit mt-md-2" name="submit">Add Product</button>
      </div>
    </form>
  </div>
</div>


@endsection