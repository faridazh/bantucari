@extends('templates.main')

@section('pagecss')
<link href="{{asset('assets/css/post.min.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('content')

<div class="mb-4">
    <h1 class="fw-normal">{{ $pagetitle }}</h1>
    <div class="text-muted">{{ $pagedesc }}</div>
</div>
<div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ asset('assets/images/barang_hilang.png') }}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">Barang Hilang</h5>
                            <p class="card-text">Meminta bantuan untuk mencarikan barang-barang anda yang hilang.</p>
                            <a href="{{ route('post.create.barang') }}" class="btn btn-primary">Buat Laporan</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ asset('assets/images/kendaraan_hilang.png') }}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">Kendaraan Hilang</h5>
                            <p class="card-text">Meminta bantuan untuk mencarikan kendaraan anda yang hilang.</p>
                            <a href="{{ route('post.create.kendaraan') }}" class="btn btn-primary">Buat Laporan</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ asset('assets/images/orang_hilang.png') }}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">Orang Hilang</h5>
                            <p class="card-text">Meminta bantuan untuk mencarikan seseorang yang hilang.</p>
                            <a href="{{ route('post.create.orang') }}" class="btn btn-primary">Buat Laporan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 mt-5 text-center">
            <div class="text-muted">Ilustrasi oleh <a href="https://themeisle.com/illustrations/" class="text-decoration-none" target="_blank">Themeisle - illu·station</a></div>
        </div>
    </div>
</div>

@endsection
