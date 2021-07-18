@extends('templates.main')

@section('content')

<div class="mb-4">
    <h1 class="fw-normal">{{ $pagetitle }}</h1>
    <div class="text-muted mb-3">{{ $pagedesc }}</div>
</div>
<form action="{{ route('post.store.barang') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="category" value="BarangHilang">
    <div class="row g-3">
        <fieldset class="col-12 col-lg-6 p-3">
            <legend>Data Barang Hilang</legend>
            <div class="row g-2">
                <div class="col-12 mb-3">
                    <label for="uploadFoto" class="form-label">Upload Foto</label>
                    <div class="input-group control-group increment">
                        <input class="form-control @error('photo') is-invalid @enderror" type="file" id="uploadFoto" name="photo[]">
                        <div class="input-group-btn">
                            <button class="btn btn-success" type="button"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="clone d-none">
                        <div class="input-group control-group mt-1">
                            <input class="form-control @error('photo') is-invalid @enderror" type="file" name="photo[]">
                            <div class="input-group-btn">
                                <button class="btn btn-danger" type="button"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                    </div>
                    @error('photo')<div class="invalid-feedback">Wajib unggah</div>@enderror
                    <div class="small text-muted">* {{ $max_size }}</div>
                    <div class="small text-muted">* Foto terbaru yang bisa mengidentifikasi orang tersebut.</div>
                </div>
                <div class="col-12 mb-3">
                    <label for="inputNamaHilang" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control @error('fullname') is-invalid @enderror" id="inputNamaHilang" name="fullname" value="{{ old('fullname') }}">
                    @error('fullname')<div class="invalid-feedback">Wajib isi</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="dateHilang" class="form-label">Tanggal Hilang</label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="dateHilang" name="tanggal" value="{{ old('tanggal') ?? date('Y-m-d', time()) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="selectHubungan" class="form-label">Jenis</label>
                    <select class="form-select @error('jenis') is-invalid @enderror" id="selectHubungan" name="jenis">
                        <option value="{{ old('jenis') }}" selected @if(old('jenis') == null) disabled @endif>{{ old('jenis') ?? '--Pilih Satu--' }}</option>
                        <option value="Barang Pribadi">Barang Pribadi</option>
                        <option value="Dokumen">Dokumen</option>
                        <option value="Smartphone">Smartphone</option>
                        <option disabled>──────────</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    @error('jenis')<div class="invalid-feedback">Wajib pilih</div>@enderror
                </div>
                <div class="col-12 mb-3">
                    <label for="inputTerakhir" class="form-label">Tempat Terakhir</label>
                    <input type="text" class="form-control @error('tempatakhir') is-invalid @enderror" id="inputTerakhir" name="tempatakhir" value="{{ old('tempatakhir') }}">
                </div>
                <div class="col-12">
                    <label for="inputCiri" class="form-label">Ciri-ciri</label>
                    <textarea class="form-control @error('ciri') is-invalid @enderror" id="inputCiri" rows="3" name="ciri" maxlength="500">{{ old('ciri') }}</textarea>
                    <div class="float-end text-muted small" id="countCiri">
                        <span id="current_count_ciri">0</span>
                        <span id="maximum_count_ciri">/ 255</span>
                    </div>
                    <div class="small text-muted">* Keterangan lebih lengkap tentang orang yang hilang.</div>
                </div>
                <div class="col-12">
                    <label for="inputKronologi" class="form-label">Kronologi</label>
                    <textarea class="form-control @error('kronologi') is-invalid @enderror" id="inputKronologi" rows="3" name="kronologi" maxlength="500">{{ old('kronologi') }}</textarea>
                    <div class="text-end text-muted small" id="countKronologi">
                        <span id="current_count_kronologi">0</span>
                        <span id="maximum_count_kronologi">/ 255</span>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="col-12 col-lg-6 p-3">
            <legend>Data Pelapor</legend>
            <div class="row g-2">
                <div class="col-12 mb-3">
                    <div class="form-check me-auto">
                        <input class="form-check-input" type="checkbox" id="checkIsiAddress" name="isiAddress">
                        <label class="form-check-label" for="checkIsiAddress">Ganti Alamat</label>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <label for="inputNamaPelapor" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control @error('nama_pelapor') is-invalid @enderror" id="inputNamaPelapor" name="nama_pelapor" value="{{ Auth::user()->name ?? old('nama_pelapor') }}" disabled>
                    @error('nama_pelapor')<div class="invalid-feedback">Wajib isi</div>@enderror
                </div>
                <div class="col-12 mb-3">
                    <label for="inputTlpPelapor" class="form-label">Nomor Telepon</label>
                    <div class="input-group has-validation">
                        <div class="input-group-text">+62</div>
                        <input type="number" class="form-control @error('hubungi_pelapor') is-invalid @enderror" id="inputTlpPelapor" name="hubungi_pelapor" value="{{ Auth::user()->phone ?? old('hubungi_pelapor') }}" disabled>
                        @error('hubungi_pelapor')<div class="invalid-feedback">Wajib isi</div>@enderror
                    </div>
                    <div class="small text-muted">* Nomor aktif yang dapat dihubungi oleh publik.</div>
                </div>
                <div class="col-12 mb-3">
                    <label for="inputEmail" class="form-label">Email</label>
                    <input type="email" class="form-control @error('inputEmail') is-invalid @enderror" id="inputEmail" name="email_pelapor" value="{{ Auth::user()->email ?? old('email_pelapor') }}" disabled>
                </div>
                <div class="col-12">
                    <label for="inputAlamat" class="form-label">Alamat</label>
                    <textarea class="form-control @error('alamat_pelapor') is-invalid @enderror" id="inputAlamat" rows="3" name="alamat_pelapor" maxlength="500" disabled>@if(!Auth::user()->address == null){{ Crypt::decryptString(Auth::user()->address) . ', ' . Auth::user()->states . ', ' . Auth::user()->zipcode }}@else{{ old('alamat_pelapor') }}@endif</textarea>
                    <div class="text-end text-muted small" id="countAlamat">
                        <span id="current_count_alamat">0</span>
                        <span id="maximum_count_alamat">/ 500</span>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="d-flex justify-content-center align-items-center mt-4">
        <button type="submit" class="btn btn-danger">Tambah Laporan</button>
    </div>
</form>

@include('posts.js.addPhotoInput')
@include('posts.js.textareaCount')
@include('posts.js.gantiAlamat')

@endsection
