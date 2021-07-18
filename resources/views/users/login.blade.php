@extends('templates.main')

@section('pagecss')
    <link href="{{asset('assets/css/login.min.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('content')

<div class="form-signin text-center">
    <h1 class="h3 fw-normal text-uppercase">{{ $pagetitle }}</h1>
    <div class="text-muted mb-3">
        <a href="{{ route('password.request') }}" class="text-decoration-none">Lupa Password</a>
    </div>
    <form action="{{ route('postlogin') }}" method="post">
        @csrf
        <div class="form-floating">
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" name="email" value="{{ old('email') }}" placeholder="Email">
            <label for="inputEmail">Email</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="inputPassword" name="password" value="{{ old('password') }}" placeholder="Password">
            <label for="inputPassword">Password</label>
        </div>
        <div class="d-flex justify-content-center mb-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="inputRememberMe" name="rememberMe" checked>
                <label class="form-check-label" for="inputRememberMe">Ingat Saya</label>
            </div>
        </div>
        <div class="mb-2">
            <div class="captcha">
                <span>{!! captcha_img() !!}</span>
                <button type="button" class="btn btn-danger" class="reload" id="reload">&#x21bb;</button>
            </div>
        </div>
        <div class="form-floating mb-5">
            <input type="captcha" class="form-control text-center @error('captcha') is-invalid @enderror" id="inputCaptcha" placeholder="Captcha" name="captcha" autocomplete="off">
            <label for="inputCaptcha">Captcha</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Masuk</button>
        <a href="{{ route('register') }}" class="w-100 btn btn btn-success mt-2">Daftar</a>
    </form>
</div>

@include('templates.captcha')

@endsection
