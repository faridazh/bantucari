@extends('templates.main')

@section('content')

<div class="mb-4">
    <h1 class="fw-normal">{{ $pagetitle }}</h1>
    <div class="text-muted">{{ $pagedesc }}</div>
</div>
<form class="row justify-content-md-center" action="{{ route('password.update') }}" method="post">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ Request::input('email') }}">
    <div class="col-lg-5">
        <div class="row g-3">
            <div class="col-12">
                <label for="inputNewPass" class="form-label">Password Baru</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="inputNewPass" name="password" value="" autocomplete="off" required autofocus>
                @error('password')<div class="small invalid-feedback">{{ old('password') ? 'Password tidak sama!' : 'Masukkan password dengan benar!' }}</div>@enderror
            </div>
            <div class="col-12">
                <label for="inputNewPassConfirm" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="inputNewPassConfirm" name="password_confirmation" value="" autocomplete="off" required>
                @error('password')<div class="small invalid-feedback">{{ old('password') ? 'Password tidak sama!' : 'Masukkan password dengan benar!' }}</div>@enderror
            </div>
        </div>
    </div>
    <div class="col-12 text-center mt-5">
        <div class="d-grid gap-2 d-md-block">
            <button type="submit" class="btn btn-danger">Perbarui Password</button>
        </div>
    </div>
</form>

@endsection
