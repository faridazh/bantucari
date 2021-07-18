@extends('templates.main')

@section('pagecss')
<link href="{{asset('assets/css/profile.min.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('content')

<div class="mb-4">
    <h1 class="fw-normal">{{ $pagetitle }}</h1>
    <div class="text-muted">{{ $pagedesc }}</div>
</div>
<div class="user-profile">
    <div class="row justify-content-center mb-5">
        <div class="col-lg-4">
            <div class="border border-2 card-box text-center position-relative">
                @if(Auth::check() && $user->id != Auth::user()->id && $user->role != 'Banned')
                <div class="position-absolute top-0 end-0 mt-2 me-2">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#reportModal">
                        <i class="fas fa-exclamation-circle"></i>
                    </button>
                </div>
                @endif
                <div class="pt-2 pb-2">
                    <div class="mx-auto">
                        <img src="{{asset('uploads/avatars'.'/'.$user->avatar)}}" class="border border-5 rounded-circle photo-profile" onerror="this.src='{{ asset('assets/images/default_avatar.png') }}';">
                    </div>
                    <div class="my-3">
                        <h4>{{ $user->name }}</h4>
                        <div class="role-badge {{ 'role-'.Str::lower($user->role) }}">{{ $user->role }}</div>
                    </div>
                    <div class="row justify-content-center align-items-end pt-2">
                        <div class="col-12">
                            <div class="fsw-h2">{{ number_format($post_count) }}</div>
                            <p class="mb-0 text-muted small text-uppercase">Laporan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mb-4">
    <div class="fs-4 fw-normal">Laporan Kehilangan dari {{ '@'.$user->username }}</div>
</div>
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4">
    @forelse($posts as $post)
    <div class="col">
        <div class="card h-100">
            <div class="position-relative">
                <img src="{{asset('uploads/posts/'.$post->case_code.'/'.$post->laporan($post->cat_id)->photo[0])}}" class="card-img-top" onerror="this.src='{{ asset('assets/images/default_avatar.png') }}';">
                @if($post->verify == 'Unapproved')
                <div class="position-absolute top-0 end-0">
                    <div class="spinner-grow text-warning" role="status">
                        <span class="visually-hidden">Proses Validasi...</span>
                    </div>
                </div>
                @endif
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $post->laporan($post->cat_id)->fullname }}</h5>
                <p class="card-text">
                    <div class="small fw-500">Lokasi Terakhir</div>
                    <div >{{ $post->laporan($post->cat_id)->tempatakhir ?? '???' }}</div>
                </p>
                <div class="pt-2 text-center">
                    <a href="{{ route('post.slugorcode', $post->case_code) }}" class="text-decoration-none">Lihat Lengkap</a>
                </div>
            </div>
            <div class="card-footer text-center">
                <small class="text-muted">{{ date_format($post->created_at, 'j F Y h:m:s') }}</small>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center">Tidak ada laporan.</div>
    @endforelse
</div>
<div class="block mt-5 text-center">
    @if ($posts->lastPage() > 1)
    <div class="d-flex mt-5">
        <ul class="pagination ms-auto me-auto">
            @if($posts->currentPage() > $posts->onFirstPage()+2)
            <li class="page-item">
                <a class="page-link" href="{{$posts->url($posts->onFirstPage())}}" title="Halaman Awal">&laquo;</a>
            </li>
            @endif
            @if($posts->currentPage() > $posts->onFirstPage())
            <li class="page-item">
                <a class="page-link" href="{{$posts->previousPageUrl()}}" title="Halaman Sebelumnya">&lt;</a>
            </li>
            @endif
            @for ($i = 1; $i <= $posts->lastPage(); $i++)
                <?php
                $half_total_links = floor(7/2);
                $from = $posts->currentPage() - $half_total_links;
                $to = $posts->currentPage() + $half_total_links;
                if ($posts->currentPage() < $half_total_links) {
                   $to += $half_total_links - $posts->currentPage();
                }
                if ($posts->lastPage() - $posts->currentPage() < $half_total_links) {
                    $from -= $half_total_links - ($posts->lastPage() - $posts->currentPage()) - 1;
                }
                ?>
                @if ($from < $i && $i < $to)
                    <li class="page-item @if(($posts->currentPage() == $i)) active @endif">
                        <a href="{{ $posts->url($i) }}" class="page-link" @if($posts->currentPage() == $i)) title="Halaman Sekarang" @endif>{{ $i }}</a>
                    </li>
                @endif
            @endfor
            @if($posts->currentPage() < $posts->lastPage())
            <li class="page-item">
                <a class="page-link" href="{{ $posts->nextPageUrl() }}" title="Halaman Selanjutnya">&gt;</a>
            </li>
            @endif
            @if($posts->currentPage() < $posts->lastPage()-1)
            <li class="page-item">
                <a class="page-link" href="{{ $posts->url($posts->lastPage()) }}" title="Halaman Terakhir">&raquo;</a>
            </li>
            @endif
        </ul>
    </div>
    @endif
</div>

@if(Auth::check() && $user->id != Auth::user()->id && $user->role != 'Banned')
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModal">Laporkan Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('report.member') }}" method="post">
                @csrf
                <input type="hidden" name="report_user" value="{{ $user->id }}">
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
                        <textarea class="form-control" placeholder="Opsional..." id="textareaReportDetail" name="report_detail" style="height: 100px"></textarea>
                        <label for="textareaReportDetail">Detail (Opsional)</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger"><i class="fas fa-exclamation-circle me-2"></i>Laporkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection
