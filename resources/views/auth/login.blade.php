@extends('layouts.masternonauth')

@section('title', 'Login')

@section('headerStyle')
<link rel="stylesheet" media="screen, print" href="{{ url('public/assets/css/fa-brands.css') }}">
<link rel="stylesheet" media="screen, print" href="{{ url('public/assets/css/themes/custom.css') }}">
@stop

@section('content')
<div class="">
    <div class="">
        <div class="">
            {{-- <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient">
                <div class="d-flex align-items-center container p-0">
                    <div
                        class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9">
                        <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                            <img src="{{ url('public/assets//img/logo.png') }}" alt="SmartAdmin Laravel"
                                aria-roledescription="logo">
                            <span class="page-logo-text mr-1">SmartAdmin Laravel</span>
                        </a>
                    </div>
                    <a href="{{url('/register')}}" class="btn-link text-white ml-auto">
                        Create Account
                    </a>
                    <a href="{{url('/password/reset')}}" class="btn-link text-white ml-5">
                        Forget Password ?
                    </a>
                </div>
            </div> --}}

            <div class="flex-1"
                style="background: url(/img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
                <div class="container-fluid" style="background-color: #F9F7F4; min-height: 100vh;">
                    <div class="row">
                        <div class="col col-md-6 col-lg-7 py-3 d-md-block d-none" style="height: 100vh;">
                            <div class="login_left_bg"
                                style="background-image: linear-gradient(to top, rgba(0,0,0,1) 0%, rgba(0,0,0,0) 80%), url('./public/assets/img/backgrounds/left_bg.jpg'); height: 100%; border-radius: 7px;">
                                <h1>CONTENT MANAGEMENT SYSTEM</h1>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-5 col-xl-5 ml-auto d-flex justify-content-center flex-column"
                            style="background: url('./public/assets/img/backgrounds/right_bg.jpg') no-repeat center; background-size: cover;">
                            <div class="login_form">
                                <div class="mb-5">
                                    <img src="./public/assets/img/backgrounds/logo.png" alt="logo.png"
                                        class="login_logo">
                                    <h2 class="mb-3">WELCOME!</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna. Lorem ipsum dolor sit amet, consectetur.
                                    </p>
                                </div>
                                <h3 class="mb-3">LOGIN TO YOUR ACCOUNT</h3>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group mb-2">
                                        {{-- <label class="form-label" for="username">Email</label> --}}
                                        <input id="email" type="email"
                                            class="form-control form-control-md @error('email') is-invalid @enderror"
                                            placeholder="Email" name="email" @if(old('email'))
                                            value="{{ old('email') }}" @else value="" @endif required
                                            autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        {{-- <div class="help-block">Email Address</div> --}}

                                    </div>
                                    <div class="form-group mb-2">
                                        {{-- <label class="form-label" for="password">Password</label> --}}

                                        <input id="password" type="password"
                                            class="form-control form-control-md @error('password') is-invalid @enderror"
                                            placeholder="Password" value="" name="password" required
                                            autocomplete="current-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                        {{-- <div class="help-block">Your password</div> --}}
                                    </div>
                                    {{-- <div class="form-group text-left">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="rememberme">
                                            <label class="custom-control-label" for="rememberme"> Remember me for the
                                                next 30 days</label>
                                        </div>
                                    </div> --}}
                                    <div class="row no-gutters">
                                        {{-- <div class="col-lg-6 pr-lg-1 my-2">
                                            <button type="submit" class="btn btn-info btn-block btn-lg">Sign in with <i
                                                    class="fab fa-google"></i></button>
                                        </div> --}}
                                        <div class="col-lg-6 pr-lg-1 my-2">
                                            <button id="js-login-btn" type="submit"
                                                class="btn yellow_btn">LOGIN</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @include('layouts/partials/footer-sm')
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('footerScript')
<script>
    $("#js-login-btn").click(function (event) {
        // Fetch form to apply custom Bootstrap validation
        var form = $("#js-login")
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
        }
        form.addClass('was-validated');
        // Perform ajax submit here...
    });
</script>
@stop