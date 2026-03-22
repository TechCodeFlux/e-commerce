<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta charset="UTF-8">

	<title>{{ $microsite->name }}</title>

	<link rel="stylesheet" href="{{url('assets/micro/css/bootstrap.css')}}">
	<link rel="stylesheet" href="{{url('assets/micro/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{url('assets/micro/css/main.css')}}">
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
.size-box:hover { border-color: black; }
.size-box.active { background: black; color: white; border-color: black; }
.size-box.disabled { background: #eee; color: #999; cursor: not-allowed; }

/* FIXED MODAL IMAGE */
.modal-img {
    width: 100%;
    height: 320px;
    object-fit: cover;
    border-radius: 6px;
}
@keyframes pop {
    0% { transform: scale(0.5); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}
</style>
</head>

<body>

	<!-- Start Header Area -->
	<header class="header_area sticky-header">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light main_box">
				<div class="container">
					<a class="navbar-brand logo_h" href="index.html">
						<img src="img/logo.png" alt="">
						<span class="ms-2 fw-bold">
							<!-- After -->
							<img src="{{ Storage::url($club->image) }}" alt="{{ $club->name }}" class="ms-2" 
							style="height:40px; width:auto; border-radius:50%;">
							{{ $microsite->name }}
						</span>
					</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
						aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
						<ul class="nav navbar-nav menu_nav ml-auto">
							<li class="nav-item active"><a class="nav-link" href="#">Home</a></li>						
							<li class="nav-item"><a class="nav-link" href="{{ route('clubmember.microsite.carts') }}">Cart</a></li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
		
	</header>
	<!-- End Header Area -->

	<!-- start banner Area -->
	<section class="banner-area">
    <div class="banner-img">
        @if($microsite->image)
            <img class="img-fluid w-100" src="{{ Storage::url($microsite->image) }}" alt="Banner Image" style="object-fit:cover; height:400px;">
        @else
            <img class="img-fluid w-100" src="img/banner/banner-img.png" alt="Default Banner" style="object-fit:cover; height:400px;">
        @endif
    </div>
</section>
	<!-- End banner Area -->

	<!-- Start Products Area -->
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
			{{-- // --}}
			@php
			$variant = DB::table('varients')->where('product_id',$product->id)->first();
			@endphp

			{{-- // --}}

			<div class="col-lg-3 col-md-4 col-sm-6 mb-4 product-card" data-category="{{ $product->category_id }}">

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
							<a href="#" class="social-info">
								<span class="fas fa-shopping-bag"></span>
								<p class="hover-text">Add to cart</p>
							</a>

							<a href="javascript:void(0)" class="social-info viewProductBtn" data-product="{{ $product->id }}">
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
<!-- End Products Area -->

 <!-- ================= MODAL FIXED ================= -->
<div class="modal fade" id="variantModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <!-- HEADER ADDED -->
            <div class="modal-header">
                <h5 class="modal-title">Product Details</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="row">

                    <!-- IMAGE -->
                    <div class="col-md-6">
                        <img id="modalImage" class="modal-img">
                    </div>

                    <!-- DETAILS -->
                    <div class="col-md-6 d-flex flex-column justify-content-center">

                        <h4 id="modalName" class="mb-2"></h4>

                        <p class="text-muted" id="modalDesc"></p>

                        <h6 class="mt-3">Select Varient</h6>
                        <div id="sizeContainer"></div>

                        <!-- STOCK TEXT ADDED -->
                        <p id="stockText" class="mt-2"></p>

                        <div class="mt-3">
                            <button id="addToCartBtn"
                                class="btn btn-dark w-100"
                                disabled>
                                SELECT VARIENT
                            </button>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- ================= END MODAL ================= -->

{{-- start message modal --}}
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-body text-center p-5">

                <!-- ICON -->
                <div class="mb-3">
                    <div style="
                        width:70px;
                        height:70px;
                        margin:auto;
                        border-radius:50%;
                        background:#28a745;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        animation: pop 0.3s ease;
                    ">
                        <i class="fa fa-check text-white" style="font-size:28px;"></i>
                    </div>
                </div>

                <!-- TEXT -->
                <h4 class="mb-2 font-weight-bold">Added to Cart</h4>
                <p class="text-muted mb-4">
                    Your item has been successfully added.
                </p>

                <!-- ACTION BUTTONS -->
                <div class="d-flex justify-content-center gap-2">
                    {{-- <button class="btn btn-outline-dark btn-sm mr-2" data-dismiss="modal">
                        Continue Shopping
                    </button> --}}
					<h4>Continue Shopping</h4>
                    {{-- <a href="{{ url('cart') }}" class="btn btn-dark btn-sm">
                        View Cart
                    </a> --}}
                </div>

            </div>

        </div>
    </div>
</div>
{{-- end message modal --}}
	<!-- start footer Area -->
	<footer class="footer-area section_gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-3  col-md-6 col-sm-6">
					<div class="single-footer-widget">
						<h6>About Us</h6>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore dolore
							magna aliqua.
						</p>
					</div>
				</div>
				<div class="col-lg-4  col-md-6 col-sm-6">
					<div class="single-footer-widget">
						<h6>Newsletter</h6>
						<p>Stay update with our latest</p>
						<div class="" id="mc_embed_signup">

							<form target="_blank" novalidate="true" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
							 method="get" class="form-inline">

								<div class="d-flex flex-row">

									<input class="form-control" name="EMAIL" placeholder="Enter Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Email '"
									 required="" type="email">


									<button class="click-btn btn btn-default"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
									<div style="position: absolute; left: -5000px;">
										<input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
									</div>
								</div>
								<div class="info"></div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-lg-3  col-md-6 col-sm-6">
					<div class="single-footer-widget mail-chimp">
						<h6 class="mb-20">Instragram Feed</h6>
						<ul class="instafeed d-flex flex-wrap">
							<li><img src="img/i1.jpg" alt=""></li>
							<li><img src="img/i2.jpg" alt=""></li>
							<li><img src="img/i3.jpg" alt=""></li>
							<li><img src="img/i4.jpg" alt=""></li>
							<li><img src="img/i5.jpg" alt=""></li>
							<li><img src="img/i6.jpg" alt=""></li>
							<li><img src="img/i7.jpg" alt=""></li>
							<li><img src="img/i8.jpg" alt=""></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-2 col-md-6 col-sm-6">
					<div class="single-footer-widget">
						<h6>Follow Us</h6>
						<p>Let us be social</p>
						<div class="footer-social d-flex align-items-center">
							<a href="#"><i class="fa fa-facebook"></i></a>
							<a href="#"><i class="fa fa-twitter"></i></a>
							<a href="#"><i class="fa fa-dribbble"></i></a>
							<a href="#"><i class="fa fa-behance"></i></a>
						</div>
					</div>
				</div>
			</div>
			<div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
				<p class="footer-text m-0"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">AARJAY</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
</p>
			</div>
		</div>
	</footer>
	<!-- End footer Area -->

	<script src="{{url('assets/micro/js/vendor/jquery-2.2.4.min.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
	 crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="{{url('assets/micro/js/jquery.ajaxchimp.min.js')}}"></script>
	{{-- <script src="{{url('assets/micro/js/jquery.nice-select.min.js')}}"></script> --}}
	<script src="{{url('assets/micro/js/jquery.sticky.js')}}"></script>
	<script src="{{url('assets/micro/js/nouislider.min.js')}}"></script>
	<script src="{{url('assets/micro/js/countdown.js')}}"></script>
	<script src="{{url('assets/micro/js/jquery.magnific-popup.min.js')}}"></script>
	<script src="{{url('assets/micro/js/owl.carousel.min.js')}}"></script>
	<!--gmaps Js-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
	<script src="{{url('assets/micro/js/gmaps.min.js')}}"></script>
	<script src="{{url('assets/micro/js/main.js')}}"></script>
	<script>
document.addEventListener("DOMContentLoaded", function(){

	const filter = document.getElementById("categoryFilter");

	filter.addEventListener("change", function(){

		const selected = this.value;
		const products = document.querySelectorAll(".product-card");

		products.forEach(function(product){

			const category = product.getAttribute("data-category");

			if(selected === "all" || selected === category){
				product.style.display = "block";
			}else{
				product.style.display = "none";
			}

		});

	});

});

$(document).ready(function(){
	$('#categoryFilter').niceSelect();
});
/// VIEW PRODUCT AND VARIANTS IN MODAL
$(document).on('click', '.viewProductBtn', function (e) {

    e.preventDefault();

    let productId = $(this).data('product');

    $.ajax({
        url: "{{ url('microsite-product-variants') }}/" + productId,
        type: 'GET',

        success: function (data) {

            if (!data || data.length === 0) {
                alert("No variants found");
                return;
            }

            let selectedVariant = null;

            // SET BASIC DATA
            $('#modalName').text(data[0].product_name || 'Product');
            $('#modalDesc').text(data[0].description || '');

            let defaultImage = data[0].image 
                ? '/storage/' + data[0].image 
                : '/img/product/p1.jpg';

            $('#modalImage').attr('src', defaultImage);

            let variantsHtml = '';

            data.forEach(v => {

                let disabledClass = v.stock <= 0 ? 'disabled' : '';

                let label = `${v.size ?? '-'} - ${v.color ?? '-'}`;

                variantsHtml += `
                    <div class="size-box ${disabledClass}" 
                        data-id="${v.id}" 
                        data-stock="${v.stock}"
                        data-image="${v.image}">
                        ${label}
                    </div>
                `;
            });

            $('#sizeContainer').html(variantsHtml);

            // RESET STATE
            $('#stockText').text('');
            $('#addToCartBtn')
                .prop('disabled', true)
                .text('SELECT VARIANT');

            // CLICK VARIANT
            $('.size-box').click(function () {

                if ($(this).hasClass('disabled')) return;

                $('.size-box').removeClass('active');
                $(this).addClass('active');

                let stock = $(this).data('stock');
                selectedVariant = $(this).data('id');
                let image = $(this).data('image');

                // ✅ CHANGE IMAGE ON SELECT
                if (image) {
                    $('#modalImage').attr('src', '/storage/' + image);
                }

                if (stock > 0) {
                    $('#stockText').html('<span class="text-success">In Stock</span>');
                    $('#addToCartBtn')
                        .prop('disabled', false)
                        .text('ADD TO CART')
                        .data('variant', selectedVariant);
                } else {
                    $('#stockText').html('<span class="text-danger">Out of Stock</span>');
                    $('#addToCartBtn')
                        .prop('disabled', true)
                        .text('OUT OF STOCK');
                }
            });

            // ✅ Bootstrap 4 modal open
            $('#variantModal').modal('show');
        },

        error: function (xhr) {
            console.error(xhr.responseText);
            alert("Something went wrong while fetching variants");
        }
    });

});

///add to cart table
$('#addToCartBtn').click(function () {

    let variantId = $(this).data('variant');

    if (!variantId) {
        alert("Please select a variant");
        return;
    }

    $.ajax({
        url: "{{ url('add-to-cart') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            variant_id: variantId,
            quantity: 1
        },

        success: function (res) {

    // Close product modal
    $('#variantModal').modal('hide');

    // Show success modal
    $('#successModal').modal('show');

    // Wait → hide → reload
    setTimeout(function () {
        $('#successModal').modal('hide');

        // Reload page
        location.reload();

    }, 2000);
},
    

        error: function (err) {
            console.error(err.responseText);
            alert("Error adding to cart");
        }
    });

});
</script>
</body>

</html>