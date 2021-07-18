@extends('templates.main')

@section('content')

<div class="mb-4">
    <h1 class="fw-normal">{{ $pagetitle }}</h1>
    <div class="text-muted">{{ $pagedesc }}</div>
</div>
<div class="d-block d-md-flex mb-3">
    <h4 class="fw-normal">Laporan Terbaru</h4>
    <div class="ms-auto">
        <a href="{{ route('post.index') }}" class="text-decoration-none">Lihat lainnya</a>
    </div>
</div>
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4">
    @forelse($posts as $post)
    <div class="col">
        <div class="card h-100">
            <div class="position-relative">
                <img src="{{asset('uploads/posts/'.$post->case_code.'/'.$post->laporan($post->cat_id)->photo[0])}}" class="card-img-top" onerror="this.src='{{ asset('assets/images/default_avatar.png') }}';">
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

@endsection
