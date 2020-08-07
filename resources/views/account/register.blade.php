<title>Daftar Akun</title>
@extends('layouts.default')

@section('content')
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
            @include('includes.message')
            <form method="post" action="/users/register" class="login100-form validate-form">
                @csrf
                <span class="login100-form-title p-b-33">
                    Sign in Akun
                </span>
                
                Nama
                <div class="wrap-input100 validate-input">
                    <input class="input100" type="text" name="name" placeholder="Nama anda">
                    <span class="focus-input100-1"></span>
                    <span class="focus-input100-2"></span>
                </div>

                Email
                <div class="wrap-input100 validate-input" data-validate = "Valid email is required: 1711xxx@budiluhur.ac.id">
                    <input class="input100" type="text" name="email" placeholder="Email">
                    <span class="focus-input100-1"></span>
                    <span class="focus-input100-2"></span>
                </div>

                Password
                <div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
                    <input class="input100" type="password" name="password" placeholder="Password">
                    <span class="focus-input100-1"></span>
                    <span class="focus-input100-2"></span>
                </div>

                Status anda
                <div class="form-group">
                    <select class="custom-select" name="role_id" required>
                      <option value="2">Dosen</option>
                      <option value="3">Mahasiswa</option>
                    </select>
                  </div>

                <div class="container-login100-form-btn m-t-20">
                    <button class="login100-form-btn" type="submit">
                        Daftar!
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
                        Sudah punya akun?
                    </span>

                    <a href="{{'/users/login'}}" class="txt2 hov1">
                        Login sekarang!
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop