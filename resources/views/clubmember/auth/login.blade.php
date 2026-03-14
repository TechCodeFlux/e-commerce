@extends('clubmember.components.app')

@section('content')

<div class="login-page">

    <!-- Animated Gradient -->
    <div class="login-bg"></div>

    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center">

            <div class="col-lg-5 col-md-7">

                <div class="login-card">
    @if ($errors->any())
<div class="login-error-box" id="loginErrorBox">
    
    <div class="login-error-header">
        <i class="fas fa-exclamation-circle"></i>
        <span>Login Error</span>
    </div>

    <ul class="login-error-list">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>

</div>
@endif

                    <!-- Logo -->
                    @if(!empty($microsite->logo))
                        <div class="text-center mb-3">
                            <img src="{{ asset('storage/'.$microsite->logo) }}"
                                 style="max-height:70px">
                        </div>
                    @endif

                    <h3 class="text-center mb-4">
                        {{ $microsite->name }} Login Portal
                    </h3>

                    <form action="{{ route('microsite.login.submit',$microsite->slug) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <input type="email"
                                   name="email"
                                   class="form-control login-input"
                                   placeholder="Enter your email"
                                   required>
                        </div>
                        <br>

                        <div class="mb-4">
                            <input type="password"
                                   name="password"
                                   class="form-control login-input"
                                   placeholder="Enter your password"
                                   required>
                        </div>
                        <br>

                        <button class="btn login-btn w-100">
                            Login
                        </button>

                    </form>

                </div>

            </div>

        </div>
    </div>

</div>

@endsection


@push('styles')
<style>

/* Page Wrapper */
.login-page{
    height:100vh;
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
}

/* Gradient Background */
.login-bg{
    position:fixed;
    width:100%;
    height:100%;
    top:0;
    left:0;
    background:linear-gradient(135deg,#ff8c00,#f5f5dc);
    background-size:300% 300%;
    animation:gradientMove 8s ease infinite;
}

@keyframes gradientMove{
    0%{background-position:0% 50%;}
    50%{background-position:100% 50%;}
    100%{background-position:0% 50%;}
}

/* Login Card */
.login-card{
    position:relative;
    z-index:2;
    padding:100px;
    border-radius:16px;
    background:rgba(255,255,255,0.15);
    backdrop-filter:blur(18px);
    box-shadow:0 15px 40px rgba(0,0,0,0.2);
    color:#000000;
    border:none;
}

/* Inputs */
.login-input{
    height:48px;
    width:300px;
    border-radius:20px;
    border:1px solid rgba(255,255,255,0.5);
    background:rgba(255,255,255,0.2);
    color:#000000;
    padding-left:15px;
}

.login-input::placeholder{
    color:#000000;
}

.login-input:focus{
    background:rgba(255,255,255,0.3);
    border-color:#fff;
    box-shadow:none;
}

/* Button */
.login-btn{
    height:45px;
    width:300px;
    border-radius:30px;
    background:#f49c6c;
    color:#000000;
    font-weight:600;
    transition:0.3s;
    border:none; 
}

.login-btn:hover{
    background:#ffe4c7;
}
/**/
/* Error Box */
.login-error-box{
    background:rgba(255,255,255,0.65);
    border:1px solid #ff9a9a;
    border-radius:12px;
    padding:16px 18px;
    margin-bottom:20px;
    backdrop-filter:blur(10px);
    animation:fadeSlide 0.5s ease;
}

/* Header */
.login-error-header{
    font-weight:600;
    color:#b30000;
    display:flex;
    align-items:center;
    margin-bottom:8px;
}

.login-error-header i{
    margin-right:8px;
    font-size:16px;
}

/* List */
.login-error-list{
    margin:0;
    padding-left:20px;
    color:#5a0000;
    font-size:14px;
}

.login-error-list li{
    margin-bottom:4px;
}

/* Entry animation */
@keyframes fadeSlide{
    from{
        opacity:0;
        transform:translateY(-10px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/**/

/* ================= RESPONSIVE FIX ================= */

/* Make inputs and button flexible */
.login-input,
.login-btn{
    max-width:100%;
}

/* Tablet */
@media (max-width:992px){

    .login-card{
        padding:60px;
    }

}

/* Mobile */
@media (max-width:768px){

    .login-card{
        padding:40px;
    }

    .login-input,
    .login-btn{
        width:100%;
    }

}

/* Small mobile */
@media (max-width:480px){

    .login-card{
        padding:30px 20px;
    }

    h3{
        font-size:20px;
    }

}

</style>
@endpush
@push('styles')
<script>
document.addEventListener("DOMContentLoaded", function(){

    const errorBox = document.getElementById("loginErrorBox");

    if(errorBox){
        setTimeout(function(){
            errorBox.style.transition = "opacity 0.6s ease";
            errorBox.style.opacity = "0";

            setTimeout(function(){
                errorBox.remove();
            },600);

        },4000); // disappears after 4 seconds
    }

});
</script>

@endpush