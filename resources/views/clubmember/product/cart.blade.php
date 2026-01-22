<h6 class="m-0 px-4 py-3 border-bottom">Shopping Cart</h6>
<div class="dropdown-menu-body">
                        {{-- <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex align-items-center">
                                <a href="#" class="text-danger me-3" title="Remove">
                                    <i class="bi bi-trash"></i>
                                </a>
                                <a href="#" class="me-3 flex-shrink-0 ">
                                    <img src="{{url('assets/images/products/3.jpg')}}" class="rounded" width="60"
                                         alt="...">
                                </a>
                                <div>
                                    <h6>Digital clock</h6>
                                    <div>1 x $1.190,90</div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex align-items-center">
                                <a href="#" class="text-danger me-3" title="Remove">
                                    <i class="bi bi-trash"></i>
                                </a>
                                <a href="#" class="me-3 flex-shrink-0 ">
                                    <img src="{{url('assets/images/products/4.jpg')}}" class="rounded" width="60"
                                         alt="...">
                                </a>
                                <div>
                                    <h6>Toy Car</h6>
                                    <div>1 x $139.58</div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex align-items-center">
                                <a href="#" class="text-danger me-3" title="Remove">
                                    <i class="bi bi-trash"></i>
                                </a>
                                <a href="#" class="me-3 flex-shrink-0 ">
                                    <img src="{{url('assets/images/products/5.jpg')}}" class="rounded" width="60"
                                         alt="...">
                                </a>
                                <div>
                                    <h6>Sunglasses</h6>
                                    <div>2 x $50,90</div>
                                </div>
                            </div>
                        </div>
                    <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex align-items-center">
                                <a href="#" class="text-danger me-3" title="Remove">
                                    <i class="bi bi-trash"></i>
                                </a>
                                <a href="#" class="me-3 flex-shrink-0 ">
                                    <img src="{{url('assets/images/products/6.jpg')}}" class="rounded" width="60"
                                         alt="...">
                                </a>
                                <div>
                                    <h6>Cake</h6>
                                    <div>1 x $10,50</div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <h6 class="m-0 px-4 py-3 border-top small">Sub Total : <strong
                            class="text-primary">$1.442,78</strong></h6>
                </div>  --}}

                 @forelse($cartItems as $item)
        <div class="list-group list-group-flush">
            <div class="list-group-item d-flex align-items-center">

                <!-- Remove -->
                {{-- <a href="{{ route('cart.remove', $item->id) }}"
                   class="text-danger me-3" title="Remove">
                    <i class="bi bi-trash"></i>
                </a>   --}}

                <!-- Image --> 
                <a href="#" class="me-3 flex-shrink-0">
                    <img src="{{ url('assets/images/products/' . $item->image) }}"
                         class="rounded" width="60" alt="">
                </a>

                <!-- Details -->
                <div>
                    <h6 class="mb-1">{{ $item->name }}</h6>
                    <div>
                        Stock: {{ $item->stock }}
                    </div>
                </div>

            </div>
        </div>
    @empty
        <p class="text-center text-muted py-3">
            Cart is empty
        </p>
    @endforelse

                    </div> 