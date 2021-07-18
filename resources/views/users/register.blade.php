@extends('templates.main')

@section('content')

<div class="mb-4">
    <h1 class="fw-normal">{{ $pagetitle }}</h1>
    <div class="text-muted">{{ $pagedesc }}</div>
</div>
<form class="row justify-content-md-center" action="{{ route('postregister') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="col-lg-8">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="uploadAvatar" class="form-label">Avatar</label>
                <input class="form-control @error('avatar') is-invalid @enderror" type="file" id="uploadAvatar" name="avatar" accept="image/x-png,image/gif,image/jpeg">
                <div class="small @error('avatar') invalid-feedback @else text-muted @enderror">*Maksimal {{ $maxsize }} & {{ $maxdimensions }}</div>
            </div>
            <div class="col-md-6">
                <label for="inputUsername" class="form-label">Username</label>
                <div class="input-group has-validation">
                    <div class="input-group-text">@</div>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="inputUsername" pattern="[a-zA-Z0-9]+" name="username" value="{{ old('username') }}" minlength="5" required>
                    @error('username')<div class="small invalid-feedback">{{ old('username') ? 'Username sudah ada!' : 'Masukkan username anda!' }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputFullname" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control @error('fullname') is-invalid @enderror" id="inputFullname" name="fullname" value="{{ old('fullname') }}" required>
                @error('fullname')<div class="small invalid-feedback">Wajib isi!</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="inputBirth" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="inputBirth" name="birthdate" value="{{ old('birthdate') }}" required>
                @error('birthdate')<div class="small invalid-feedback">Wajib isi!</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="inputPhone" class="form-label">Telepon</label>
                <div class="input-group has-validation">
                    <div class="input-group-text">+62</div>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="inputPhone" name="phone" value="{{ old('phone') }}" pattern="[0-9]{8,}" required>
                    @error('phone')<div class="small invalid-feedback">Masukkan nomor telepon dengan benar!</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" name="email" value="{{ old('email') }}" required>
                @error('email')<div class="small invalid-feedback">{{ old('email') ? 'Email sudah ada!' : 'Masukkan email anda!' }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="inputPass" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="inputPass" name="password" value="" minlength="5" required>
                @error('password')<div class="small invalid-feedback">Masukkan password dengan benar!</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="inputPassConfirm" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="inputPassConfirm" name="password_confirmation" value="" minlength="5" required>
                @error('password')<div class="small invalid-feedback">Masukkan password dengan benar!</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="inputAddress" class="form-label">Alamat</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="inputAddress" name="address" value="{{ old('address') }}">
                @error('address')<div class="small invalid-feedback">Masukkan alamat dengan benar!</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="inputState" class="form-label">Provinsi</label>
                <select id="inputState" class="form-select @error('states') is-invalid @enderror" name="states">
                    <option value="{{ old('states') }}" selected>{{ old('states') ?? 'Pilih salah satu...' }}</option>
                    <option disabled>──────────</option>
                    <option value="Aceh">Aceh</option>
                    <option value="Bali">Bali</option>
                    <option value="Banten">Banten</option>
                    <option value="Bengkulu">Bengkulu</option>
                    <option value="Gorontalo">Gorontalo</option>
                    <option value="Jakarta">Jakarta</option>
                    <option value="Jambi">Jambi</option>
                    <option value="Jawa Barat">Jawa Barat</option>
                    <option value="Jawa Tengah">Jawa Tengah</option>
                    <option value="Jawa Timur">Jawa Timur</option>
                    <option value="Kalimantan Barat">Kalimantan Barat</option>
                    <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                    <option value="Kalimantan Timur">Kalimantan Timur</option>
                    <option value="Kalimantan Utara">Kalimantan Utara</option>
                    <option value="Kepulauan Bangka Belitung">Kepulauan Bangka Belitung</option>
                    <option value="Kepulauan Riau">Kepulauan Riau</option>
                    <option value="Lampung">Lampung</option>
                    <option value="Maluku Utara">Maluku Utara</option>
                    <option value="Maluku">Maluku</option>
                    <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                    <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                    <option value="Papua Barat">Papua Barat</option>
                    <option value="Papua">Papua</option>
                    <option value="Provinsi Kalimantan Selatan">Provinsi Kalimantan Selatan</option>
                    <option value="Provinsi Sulawesi Selatan">Provinsi Sulawesi Selatan</option>
                    <option value="Riau">Riau</option>
                    <option value="Sulawesi Barat">Sulawesi Barat</option>
                    <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                    <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                    <option value="Sulawesi Utara">Sulawesi Utara</option>
                    <option value="Sumatera Barat">Sumatera Barat</option>
                    <option value="Sumatera Selatan">Sumatera Selatan</option>
                    <option value="Sumatera Utara">Sumatera Utara</option>
                    <option value="Yogyakarta">Yogyakarta</option>
                </select>
                @error('states')<div class="small invalid-feedback">Pilih provinsi yang tersedia!</div>@enderror
            </div>
            <div class="col-md-2">
                <label for="inputZip" class="form-label">Kode Pos</label>
                <input type="number" class="form-control @error('zipcode') is-invalid @enderror" id="inputZip" name="zipcode" value="{{ old('zipcode') }}">
                @error('zipcode')<div class="small invalid-feedback">Masukkan kode pos dengan benar!</div>@enderror
            </div>
            <div class="col-12 text-center mt-5">
                <div class="captcha">
                    <span>{!! captcha_img() !!}</span>
                    <button type="button" class="btn btn-danger" class="reload" id="reload">&#x21bb;</button>
                </div>
            </div>
            <div class="col-12">
                <div class="row g-3 justify-content-center">
                    <div class="col-md-5 text-center">
                        <input id="captcha" type="text" class="form-control text-center @error('captcha') is-invalid @enderror" placeholder="Captcha" name="captcha" autocomplete="off" required>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center mt-5">
                <div class="d-grid gap-2 d-md-block">
                    <button type="submit" class="btn btn-primary">Daftar</button>
                </div>
            </div>
        </div>
    </div>
</form>

@include('templates.captcha')

@endsection
