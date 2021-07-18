@extends('templates.main')

@section('content')

<div class="mb-4">
    <h1 class="fw-normal">{{ $pagetitle }}</h1>
    <div class="text-muted">{{ $pagedesc }}</div>
</div>
<div class="row g-3">
    @include('templates.admin.sidebar')
    <div class="col-md-10 p-3">
        <form class="row g-3" action="{{ route('admin.setting.laporan.post') }}" method="post">
            @csrf
            <div class="col-12">
                <label for="inputPhotoCount" class="form-label fw-semibold">Jumlah Foto Yang Dapat Diunggah</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="inputPhotoCount" name="laporan_photo_count" value="{{ config('setting.laporan_photo_count') }}" max="10">
                    <span class="input-group-text">Foto</span>
                </div>
            </div>
            <div class="col-12">
                <label for="inputPhotoSize" class="form-label fw-semibold">Ukuran Foto (Maksimal)</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="inputPhotoSize" name="laporan_photo_size" value="{{ config('setting.laporan_photo_size') }}" max="2048">
                    <span class="input-group-text">KB</span>
                </div>
            </div>
            <div class="col-12">
                <label for="inputPhotoWidth" class="form-label fw-semibold">Lebar Foto (Maksimal)</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="inputPhotoWidth" name="laporan_photo_width" value="{{ config('setting.laporan_photo_width') }}" max="1000">
                    <span class="input-group-text">KB</span>
                </div>
            </div>
            <div class="col-12">
                <label for="inputPhotoHeight" class="form-label fw-semibold">Tinggi Foto (Maksimal)</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="inputPhotoHeight" name="laporan_photo_height" value="{{ config('setting.laporan_photo_height') }}" max="1000">
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
