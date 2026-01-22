@extends('clubmember.components.app')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4">Available Products</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    {{--<th>ID</th>--}}
                    <th>Name</th>
                    {{-- <th>Stock</th> --}}
                    <th>image</th>
                    <th>Description</th>
                    <th>available</th>
                    <th> </th>
                    {{-- <th>Country Id</th>
                    <th>State Id</th>
                    <th>City</th>
                    <th>Zip Code</th>
                    <th>Status</th> 

                    <th class="text-center">Actions</th>
                </tr>--}}
            </thead>

            <tbody>
                
                @forelse ($product as $product)
                    <tr>
                        @if($product->status !=0)
                        {{-- <td>{{ $product->id }}</td> --}}
                        <td>{{ $product->name }}</td>
                        {{-- <td>{{ $product->stock }}</td> --}}
                        <td><img src="{{ asset('storage/'.$product->image) }}"  alt="{{ $product->name }}"  width="100"></td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->stock ? 'Available' : 'Not Available' }}</td>
                         <td class="text-center">
                            
                             {{-- <a href=' "{{ route('clubmember.product.addcart', $product->id) }}"'' --}}
                                
                            <form action="{{ route('clubmember.addcart', $product->id) }}" 
                                  method="POST">
                                  @csrf
                                  {{-- class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this club?');">
                                
                                @method('DELETE') --}}
                                <button type="submit" class="bd-example-modal btn btn-danger btn-sm ">
                                    <i class="bi bi-cart bd-lead text-orange" style=""></i>
                                </button>
                             
                                
                            </form>

                            
                        </td>
                    </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No products found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- <a href="{{ route('admin.club') }}" class="btn btn-success mt-3"> --}}
        Add New Club
    </a>

</div>
@endsection
