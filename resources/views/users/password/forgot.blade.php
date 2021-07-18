@extends('templates.main')

@section('content')

<div class="mb-4">
    <h1 class="fw-normal">{{ $pagetitle }}</h1>
    <div class="text-muted">{{ $pagedesc }}</div>
</div>
<form class="row justify-content-md-center" action="{{ route('password.email') }}" method="post">
    @csrf
    <div class="col-md-5">
        <label for="inputEmail" class="form-label">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" name="email" value="{{ old('email') }}" required>
        @error('email')<div class="small invalid-feedback">{{ old('email') ?? 'Masukkan email anda!'}}</div>@enderror
    </div>
    <div class="col-12 text-center mt-5">
        <div class="d-grid gap-2 d-md-block">
            <button type="submit" class="btn btn-danger">Reset Password</button>
        </div>
    </div>
</form>

@endsection
