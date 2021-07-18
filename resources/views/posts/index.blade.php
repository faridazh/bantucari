@extends('templates.main')

@section('content')

<div class="mb-4 d-block d-md-flex align-items-center">
    <div class="me-auto">
        <h1 class="fw-normal">{{ $pagetitle }}</h1>
        <div class="text-muted">Kategori: {{ !empty(Request::input('tags')) ? ucfirst(Request::input('tags')) : 'Semua Laporan' }} - <a href="#" class="text-primary text-decoration-none pe-auto" data-bs-toggle="modal" data-bs-target="#filterModal">Filter</a></div>
    </div>
    <form action="{{ route('post.index') }}" method="get">
        <input class="form-control me-2" type="search" name="cari" placeholder="Cari laporan...">
        @if(!empty(Request::input('status')))
        <input type="hidden" name="status" value="{{ Request::input('status') }}">
        @endif
        @if(!empty(Request::input('tags')))
        <input type="hidden" name="tags" value="{{ Request::input('tags') }}">
        @endif
        @if(!empty(Request::input('order')))
        <input type="hidden" name="order" value="{{ Request::input('order') }}">
        @endif
        @if(!empty(Request::input('sort')))
        <input type="hidden" name="sort" value="{{ Request::input('sort') }}">
        @endif
    </form>
</div>
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4">
    @forelse($posts as $post)
    <div class="col">
        <div class="card h-100">
            <div class="position-relative">
                <img src="{{ asset('uploads/posts/'.$post->case_code.'/'.$post->laporan($post->cat_id)->photo[0]) }}" class="card-img-top" onerror="this.src='{{ asset('assets/images/default_avatar.png') }}';">
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
    <div class="text-muted">Menampilkan {{ $posts->firstItem() ?? '0' }} sampai {{ $posts->lastItem() ?? '0' }} dari {{ $posts->total() }} data.</div>
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

@include('posts.modal.index')

@endsection
