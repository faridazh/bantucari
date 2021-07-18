@extends('templates.main')

@section('content')

<div class="mb-4">
    <h1 class="fw-normal">{{ $pagetitle }}</h1>
    <div class="text-muted">{{ $pagedesc }}</div>
</div>
<div class="row g-3">
    @include('templates.staff.sidebar')
    <div class="col-md-10 p-3">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr class="text-center">
                        <th scope="col" width="20%">Nomor Kasus</th>
                        <th scope="col" width="20%">Kategori</th>
                        <th scope="col" width="35%">Nama</th>
                        <th scope="col" width="20%">Jenis</th>
                        <th scope="col" width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr class="text-center">
                        <td>
                            <a class="text-decoration-none font-monospace" href="{{ route('post.slugorcode', $post->case_code) }}" target="_blank" data-toggle="tooltip" title="{{ $post->laporan($post->cat_id)->fullname }}">{{ $post->case_code }}</a>
                        </td>
                        <td>{{ $post->kategori->cat_name }}</td>
                        <td>{{ $post->laporan($post->cat_id)->fullname }}</td>
                        <td>{{ $post->laporan($post->cat_id)->jenis ?? $post->laporan($post->cat_id)->hubungan }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <form class="mx-1" action="{{ route('staff.laporan.validasi') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <input type="hidden" name="case_code" value="{{ $post->case_code }}">
                                    <button type="submit" class="btn btn-sm btn-success" data-toggle="tooltip" title="Validasi"><i class="fas fa-check fa-fw"></i></button>
                                </form>
                                <form class="mx-1" action="{{ route('staff.laporan.hapus') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <input type="hidden" name="case_code" value="{{ $post->case_code }}">
                                    <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus"><i class="fas fa-times fa-fw"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="text-center">
                        <td colspan="5">Tidak ada laporan yang perlu divalidasi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
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

@endsection
