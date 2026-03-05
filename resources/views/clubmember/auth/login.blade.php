@extends('clubmember.layouts.app')

@section('content')

<section class="login_box_area position-relative d-flex align-items-center" style="min-height:100vh;">

    <!-- ORANGE + BEIGE GRADIENT BACKGROUND -->
    <div class="login-gradient"></div>

    <div class="container position-relative">
        <div class="row justify-content-center align-items-center" style="min-height: 85vh;">

            <div class="col-lg-5 col-md-7">

                <!-- GLASS LOGIN CARD -->
                <div class="login_form_inner p-5 rounded-4 shadow-lg text-white">

                    <!-- HEADER -->
                    <div class="text-center mb-4">

                        @if(!empty($microsite->logo))
                            <img src="{{ asset('storage/' . $microsite->logo) }}"
                                 alt="Logo"
                                 class="mb-3"
                                 style="max-height:70px;">
                        @endif

                        <h2 class="fw-bold">
                            {{ $microsite->name }} Login Portal
                        </h2>
                    </div>

                    <!-- LOGIN FORM -->
                    <form action="{{ route('clubmember.login.submit', $microsite->slug) }}"
                          method="POST">

                        @csrf

                        <!-- EMAIL -->
                        <div class="mb-3">
                            <input type="email"
                                   class="form-control form-control-lg rounded-pill bg-transparent text-white"
                                   name="email"
                                   placeholder="Enter your email"
                                   required>
                        </div>

                        <!-- PASSWORD -->
                        <div class="mb-4">
                            <input type="password"
                                   class="form-control form-control-lg rounded-pill bg-transparent text-white"
                                   name="password"
                                   placeholder="Enter your password"
                                   required>
                        </div>

                        <!-- LOGIN BUTTON -->
                        <button type="submit"
                                class="btn w-100 rounded-pill fw-semibold login-btn">
                            Log In
                        </button>

                    </form>

                </div>

            </div>

        </div>
    </div>

</section>

@endsection

@push('styles')
<style>

/* ===== ORANGE → BEIGE ANIMATED BACKGROUND ===== */
.login-gradient {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #ff8c00, #f5f5dc);
    background-size: 300% 300%;
    animation: gradientMove 8s ease infinite;
    z-index: 0;
}

@keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Ensure content appears above gradient */
.login_box_area .container {
    z-index: 2;
}

/* ===== GLASS EFFECT CARD ===== */
.login_form_inner {
    backdrop-filter: blur(20px);
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

/* ===== INPUT STYLING ===== */
.form-control {
    border: 1px solid rgba(255, 255, 255, 0.4);
}

.form-control::placeholder {
    color: rgba(255,255,255,0.8);
}

.form-control:focus {
    box-shadow: none;
    border-color: #fff;
    background: rgba(255,255,255,0.2);
    color: #fff;
}

/* ===== BUTTON STYLE ===== */
.login-btn {
    background: #ffffff;
    color: #ff8c00;
    padding: 10px;
    transition: 0.3s ease;
}

.login-btn:hover {
    background: #ffe5cc;
    color: #e67300;
}

</style>
@endpush
