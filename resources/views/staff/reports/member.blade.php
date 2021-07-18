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
                        <th scope="col" width="25%">Nama Member</th>
                        <th scope="col" width="25%">Alasan</th>
                        <th scope="col" width="30%">Detail</th>
                        <th scope="col" width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                    <tr class="text-center">
                        <td> <a class="text-decoration-none" href="{{ route('user_profile', $report->user->username) }}" target="_blank" data-toggle="tooltip" title="{{ '@'.$report->user->username }}">{{ $report->user->name }}</a></td>
                        <td>{{ $report->report_cat->cat_name }}</td>
                        <td>{{ $report->detail ?? '-' }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <form class="mx-1" action="{{ route('staff.report.member.approve') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $report->user_id }}">
                                    <input type="hidden" name="username" value="{{ $report->user->username }}">
                                    <button type="submit" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Hapus Member"><i class="fas fa-user-minus fa-fw"></i></button>
                                </form>
                                <form class="mx-1" action="{{ route('staff.report.member.decline') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $report->id }}">
                                    <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus Report"><i class="fas fa-trash-alt fa-fw"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="text-center">
                        <td colspan="4">Tidak ada laporan yang perlu divalidasi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="block mt-5 text-center">
    @if ($reports->lastPage() > 1)
    <div class="d-flex mt-5">
        <ul class="pagination ms-auto me-auto">
            @if($reports->currentPage() > $reports->onFirstPage()+2)
            <li class="page-item">
                <a class="page-link" href="{{$reports->url($reports->onFirstPage())}}" title="Halaman Awal">&laquo;</a>
            </li>
            @endif
            @if($reports->currentPage() > $reports->onFirstPage())
            <li class="page-item">
                <a class="page-link" href="{{$reports->previousPageUrl()}}" title="Halaman Sebelumnya">&lt;</a>
            </li>
            @endif
            @for ($i = 1; $i <= $reports->lastPage(); $i++)
                <?php
                $half_total_links = floor(7/2);
                $from = $reports->currentPage() - $half_total_links;
                $to = $reports->currentPage() + $half_total_links;
                if ($reports->currentPage() < $half_total_links) {
                   $to += $half_total_links - $reports->currentPage();
                }
                if ($reports->lastPage() - $reports->currentPage() < $half_total_links) {
                    $from -= $half_total_links - ($reports->lastPage() - $reports->currentPage()) - 1;
                }
                ?>
                @if ($from < $i && $i < $to)
                    <li class="page-item @if(($reports->currentPage() == $i)) active @endif">
                        <a href="{{ $reports->url($i) }}" class="page-link" @if($reports->currentPage() == $i)) title="Halaman Sekarang" @endif>{{ $i }}</a>
                    </li>
                @endif
            @endfor
            @if($reports->currentPage() < $reports->lastPage())
            <li class="page-item">
                <a class="page-link" href="{{ $reports->nextPageUrl() }}" title="Halaman Selanjutnya">&gt;</a>
            </li>
            @endif
            @if($reports->currentPage() < $reports->lastPage()-1)
            <li class="page-item">
                <a class="page-link" href="{{ $reports->url($reports->lastPage()) }}" title="Halaman Terakhir">&raquo;</a>
            </li>
            @endif
        </ul>
    </div>
    @endif
</div>

@endsection
