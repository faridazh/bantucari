@extends('templates.main')

@section('content')

<div class="mb-4" id="web">
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
                        <th scope="col" width="25%">Username</th>
                        <th scope="col" width="25%">Nama</th>
                        <th scope="col" width="25%">Email</th>
                        <th scope="col" width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="text-center">
                        <td>
                            <a class="text-decoration-none font-monospace" href="{{ route('user_profile', $user->username) }}" target="_blank" data-toggle="tooltip" title="Lihat Lengkap">{{ '@' . $user->username }}</a>
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <form class="mx-1" action="{{ route('staff.member.validasi') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <input type="hidden" name="username" value="{{ $user->username }}">
                                    <button type="submit" class="btn btn-sm btn-success" data-toggle="tooltip" title="Aktivasi"><i class="fas fa-check fa-fw"></i></button>
                                </form>
                                <form class="mx-1" action="{{ route('staff.member.hapus') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="username" value="{{ $user->username }}">
                                    <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus"><i class="fas fa-times fa-fw"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="text-center">
                        <td colspan="4">Tidak ada member yang perlu diaktivasi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="block mt-5 text-center">
    @if ($users->lastPage() > 1)
    <div class="d-flex mt-5">
        <ul class="pagination ms-auto me-auto">
            @if($users->currentPage() > $users->onFirstPage()+2)
            <li class="page-item">
                <a class="page-link" href="{{$users->url($users->onFirstPage())}}" title="Halaman Awal">&laquo;</a>
            </li>
            @endif
            @if($users->currentPage() > $users->onFirstPage())
            <li class="page-item">
                <a class="page-link" href="{{$users->previousPageUrl()}}" title="Halaman Sebelumnya">&lt;</a>
            </li>
            @endif
            @for ($i = 1; $i <= $users->lastPage(); $i++)
                <?php
                $half_total_links = floor(7/2);
                $from = $users->currentPage() - $half_total_links;
                $to = $users->currentPage() + $half_total_links;
                if ($users->currentPage() < $half_total_links) {
                   $to += $half_total_links - $users->currentPage();
                }
                if ($users->lastPage() - $users->currentPage() < $half_total_links) {
                    $from -= $half_total_links - ($users->lastPage() - $users->currentPage()) - 1;
                }
                ?>
                @if ($from < $i && $i < $to)
                    <li class="page-item @if(($users->currentPage() == $i)) active @endif">
                        <a href="{{ $users->url($i) }}" class="page-link" @if($users->currentPage() == $i)) title="Halaman Sekarang" @endif>{{ $i }}</a>
                    </li>
                @endif
            @endfor
            @if($users->currentPage() < $users->lastPage())
            <li class="page-item">
                <a class="page-link" href="{{ $users->nextPageUrl() }}" title="Halaman Selanjutnya">&gt;</a>
            </li>
            @endif
            @if($users->currentPage() < $users->lastPage()-1)
            <li class="page-item">
                <a class="page-link" href="{{ $users->url($users->lastPage()) }}" title="Halaman Terakhir">&raquo;</a>
            </li>
            @endif
        </ul>
    </div>
    @endif
</div>

@endsection
