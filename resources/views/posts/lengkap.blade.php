@extends('templates.main')

@section('content')

<div class="mb-4 d-flex">
    <div class="me-auto">
        <h1 class="fw-normal">{{ $pagetitle }}</h1>
        <div class="text-muted">{{ $pagedesc }}</div>
    </div>
    @if($data->verify == 'Unapproved' && $data->status == 'Hilang')
    <div class="spinner-grow text-warning" role="status">
        <span class="visually-hidden">Proses Validasi...</span>
    </div>
    @endif
    @if($data->verify == 'Approved' && $data->status == 'Ditemukan')
    <div class="ms-2">
        <button type="button" class="btn btn-success btn-sm"><i class="fas fa-check-circle me-2"></i>Sudah Ditemukan</button>
    </div>
    @endif
    @if($data->verify == 'Approved' && $data->status == 'Hilang' && Auth::check() && $data->user_id == Auth::user()->id)
    <div class="ms-2">
        <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#ditemukanModal"><i class="far fa-check-circle me-2"></i>Sudah Ditemukan</button>
    </div>
    @endif
    @if($data->verify == 'Approved' && Auth::check() && $data->user_id != Auth::user()->id)
    <div class="ms-2">
        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#reportModal">
            <i class="fas fa-exclamation-circle"></i>
        </button>
    </div>
    @endif
</div>
<div class="row g-5 laporan_lengkap text-break">
    <div class="col-12 col-lg-4 text-center">

        <div id="carouselLaporan" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($data->photo as $photo)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <img src="{{ asset('uploads/posts/'.$data->case_code.'/'.$photo) }}" class="d-block w-100" onerror="this.src='{{ asset('assets/images/default_avatar.png') }}';">
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselLaporan" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselLaporan" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <hr class="my-3">
        <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseQRCode" role="button" aria-expanded="false" aria-controls="collapseQRCode"><i class="fas fa-qrcode me-2"></i>Kode QR</a>
        <div class="collapse" id="collapseQRCode">
            <div class="mt-4">{{ $qrcode }}</div>
        </div>
    </div>
    <div class="col-12 col-lg-8">
        <div class="row g-4">
            <div class="col-12 fs-5 fw-semibold">{{ $legendtitle }}</div>
            <div class="col-12">
                <div class="row g-1">
                    <div class="col-sm-3 fw-semibold">Nama</div>
                    <div class="col-sm-9">{{ $data->fullname }}</div>
                </div>
            </div>
            <div class="col-12">
                <div class="row g-1">
                    <div class="col-sm-3 fw-semibold">{{empty($data->jenis) ? 'Hubungan' : 'Jenis'}}</div>
                    <div class="col-sm-9">{{ $data->jenis ?? $data->hubungan }}</div>
                </div>
            </div>
            <div class="col-12">
                <div class="row g-1">
                    <div class="col-sm-3 fw-semibold">Tanggal Hilang</div>
                    <div class="col-sm-9">{{ date('j F Y', strtotime($data->tanggal) ) }}</div>
                </div>
            </div>
            <div class="col-12">
                <div class="row g-1">
                    <div class="col-sm-3 fw-semibold">Tempat Terakhir</div>
                    <div class="col-sm-9">{{ $data->tempatakhir }}</div>
                </div>
            </div>
            <div class="col-12">
                <div class="row g-1">
                    <div class="col-sm-3 fw-semibold">Ciri-ciri</div>
                    <div class="col-sm-9">{!! nl2br($data->ciri) !!}</div>
                </div>
            </div>
            <div class="col-12">
                <div class="row g-1">
                    <div class="col-sm-3 fw-semibold">Kronologi</div>
                    <div class="col-sm-9">{!! nl2br($data->kronologi) !!}</div>
                </div>
            </div>
        </div>
        <hr class="my-4">
        <div class="row g-4">
            <div class="col-12 fs-5 fw-semibold">Data Pelapor</div>
            @verified
            <div class="col-12">
                <div class="row g-1">
                    <div class="col-sm-3 fw-semibold">Nama</div>
                    <div class="col-sm-9">{{ $data->nama_pelapor }}</div>
                </div>
            </div>
            <div class="col-12">
                <div class="row g-1">
                    <div class="col-sm-3 fw-semibold">No. Telepon</div>
                    <div class="col-sm-9">(+62) {{ $data->hubungi_pelapor }}</div>
                </div>
            </div>
            <div class="col-12">
                <div class="row g-1">
                    <div class="col-sm-3 fw-semibold">Email</div>
                    <div class="col-sm-9">{{ $data->email_pelapor }}</div>
                </div>
            </div>
            <div class="col-12">
                <div class="row g-1">
                    <div class="col-sm-3 fw-semibold">Alamat</div>
                    <div class="col-sm-9">@if(!empty($data->alamat_pelapor)){{ Crypt::decryptString($data->alamat_pelapor) }}@endif</div>
                </div>
            </div>
            @else
            <div class="col-12 text-center">
                <div class="mb-3">Untuk melihat data pelapor, silakan masuk atau daftar terlebih dahulu.</div>
                <div class="d-flex justify-content-center">
                    <a href="{{ route('login') }}" class="btn {{Request::routeIs('login') ? 'btn-primary' : 'btn-outline-primary'}} me-2" @if(!Request::routeIs('login','register')) data-bs-toggle="modal" data-bs-target="#loginModal" @endif><i class="fas fa-sign-in-alt me-2"></i>Masuk</a>
                    <a href="{{ route('register') }}" class="btn {{Request::routeIs('register') ? 'btn-success' : 'btn-outline-success'}}"><i class="fas fa-user-plus me-2"></i>Daftar</a>
                </div>
            </div>
            @endverified
        </div>
    </div>
</div>
@if($data->verify == 'Approved' && $data->status == 'Hilang' && Auth::check() && $data->user_id == Auth::user()->id)
<div class="modal fade" id="ditemukanModal" tabindex="-1" aria-labelledby="ditemukanModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ditemukanModal">Laporan Ditemukan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('post.validasi.ditemukan', $data->case_code) }}" method="post">
                @csrf
                <input type="hidden" name="idSaya" value="{{ $data->user_id }}">
                <input type="hidden" name="kasus" value="{{ $data->case_code }}">
                <div class="modal-body">
                    <p>Apakah anda yakin yang anda cari sudah ditemukan?<br>Jika sudah, maka laporan ini akan menjadi laporan yang sudah ditemukan.<br><br><span class="fw-semibold">Apakah anda yakin?</span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-circle me-2"></i>Sudah Ditemukan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@if($data->verify == 'Approved' && Auth::check() && $data->user_id != Auth::user()->id)
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModal">Laporkan Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('report.laporan') }}" method="post">
                @csrf
                <input type="hidden" name="report_post" value="{{ $data->id }}">
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="selectReportCat" name="report_cat">
                        @foreach($report_cats as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->cat_name }}</option>
                        @endforeach
                        </select>
                        <label for="selectReportCat">Alasan:</label>
                    </div>
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Opsional..." id="textareaReportDetail" name="report_detail" maxlength="255" style="height: 100px"></textarea>
                        <label for="textareaReportDetail">Detail (Opsional)</label>
                    </div>
                    <div class="text-end text-muted small" id="count">
                        <span id="current_count">0</span>
                        <span id="maximum_count">/ 255</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger"><i class="fas fa-exclamation-circle me-2"></i>Laporkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('textarea').keyup(function() {
        var characterCount = $(this).val().length,
            current_count = $('#current_count'),
            maximum_count = $('#maximum_count'),
            count = $('#count');
            current_count.text(characterCount);
    });
</script>
@endif

@endsection
