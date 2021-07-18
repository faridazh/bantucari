@extends('templates.main')

@section('content')

<div class="mb-4">
    <h1 class="fw-normal">{{ $pagetitle }}</h1>
    <div class="text-muted">{{ $pagedesc }}</div>
</div>
<div class="row g-3">
    @include('templates.admin.sidebar')
    <div class="col-md-10 p-3">
        <form class="row g-3" action="{{ route('admin.setting.user.post') }}" method="post">
            @csrf
            <div class="col-12">
                <label for="inputAvatarSize" class="form-label fw-semibold">Ukuran Avatar (Maksimal)</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="inputAvatarSize" name="user_avatar_size" value="{{ config('setting.user_avatar_size') }}" max="2048">
                    <span class="input-group-text">KB</span>
                </div>
            </div>
            <div class="col-12">
                <label for="inputAvatarWidth" class="form-label fw-semibold">Lebar Avatar (Maksimal)</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="inputAvatarWidth" name="user_avatar_width" value="{{ config('setting.user_avatar_width') }}" max="1000">
                    <span class="input-group-text">KB</span>
                </div>
            </div>
            <div class="col-12">
                <label for="inputAvatarHeight" class="form-label fw-semibold">Tinggi Avatar (Maksimal)</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="inputAvatarHeight" name="user_avatar_height" value="{{ config('setting.user_avatar_height') }}" max="1000">
                    <span class="input-group-text">KB</span>
                </div>
            </div>
            <div class="col-12 text-center mt-5">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</div>

@endsection
