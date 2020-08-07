<title>Masuk BLINFO</title>
@extends('layouts.default')

@section('content')
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
            @include('includes.message')
            <form method="post" action="/users/login" class="login100-form validate-form">
                @csrf
                <span class="login100-form-title p-b-33">
                    Masuk
                </span>

                <input type="hidden" name="device_token" id="device_token">
                <div class="wrap-input100 validate-input" data-validate = "Valid email is required: 1711xxx@budiluhur.ac.id">
                    <input class="input100" type="text" name="email" placeholder="Email">
                    <span class="focus-input100-1"></span>
                    <span class="focus-input100-2"></span>
                </div>

                <div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
                    <input class="input100" type="password" name="password" placeholder="Password">
                    <span class="focus-input100-1"></span>
                    <span class="focus-input100-2"></span>
                </div>

                <div class="container-login100-form-btn m-t-20">
                    <button class="login100-form-btn" type="submit">
                        Masuk
                    </button>
                </div>

                <div class="text-center p-t-45 p-b-4">
                    <span class="txt1">
                        Lupa
                    </span>

                    <a href="#" class="txt2 hov1">
                        email / Password?
                    </a>
                </div>

                <div class="text-center">
                    <span class="txt1">
                        Belum punya akun?
                    </span>

                    <a href="{{'/users/register'}}" class="txt2 hov1">
                        Daftar sekarang!
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
@section('customjs')
<script src="{{asset('js/firebase.js')}}"></script>
@stop