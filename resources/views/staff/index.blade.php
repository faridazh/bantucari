@extends('templates.main')

@section('content')

<div class="mb-4">
    <h1 class="fw-normal">{{ $pagetitle }}</h1>
    <div class="text-muted">{{ $pagedesc }}</div>
</div>
<div class="row g-3">
    @include('templates.staff.sidebar')
    <div class="col-md-10 p-3">
        <div class="row g-3">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    <div class="text-center mx-auto">
                        <div class="fs-4 fw-semibold">{{ $post_count }}</div>
                        <p class="mb-0 text-muted small text-uppercase">Laporan</p>
                    </div>
                    <div class="text-center mx-auto">
                        <div class="fs-4 fw-semibold">{{ $user_count }}</div>
                        <p class="mb-0 text-muted small text-uppercase">Member</p>
                    </div>
                    <div class="text-center mx-auto">
                        <div class="fs-4 fw-semibold">{{ $report_count }}</div>
                        <p class="mb-0 text-muted small text-uppercase">Report</p>
                    </div>
                </div>
                <hr>
            </div>
            <div class="col-12">
                <div class="fs-4 fw-semibold">Laporan Terbaru</div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" width="20%">Nomor Kasus</th>
                                <th scope="col" width="20%">Kategori</th>
                                <th scope="col" width="35%">Nama</th>
                                <th scope="col" width="20%">Jenis</th>
                                <th scope="col" width="5%">Validasi</th>
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
                                    @if($post->verify == 'Unapproved')
                                    <div class="spinner-grow spinner-grow-sm text-warning" role="status">
                                        <span class="visually-hidden">Proses Validasi...</span>
                                    </div>
                                    @elseif($post->verify == 'Approved')
                                    <div class="spinner-grow spinner-grow-sm text-success" role="status">
                                        <span class="visually-hidden">Tervalidasi...</span>
                                    </div>
                                    @endif
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
            <div class="col-12">
                <div class="fs-4 fw-semibold">Member Terbaru</div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" width="30%">Username</th>
                                <th scope="col" width="30%">Nama</th>
                                <th scope="col" width="35%">Email</th>
                                <th scope="col" width="5%">Validasi</th>
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
                                    @if(empty($user->email_verified_at))
                                    <div class="spinner-grow spinner-grow-sm text-warning" role="status">
                                        <span class="visually-hidden">Proses Validasi...</span>
                                    </div>
                                    @else
                                    <div class="spinner-grow spinner-grow-sm text-success" role="status">
                                        <span class="visually-hidden">Tervalidasi...</span>
                                    </div>
                                    @endif
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
            <div class="col-12">
                <div class="fs-4 fw-semibold">Report Laporan Terbaru</div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" width="25%">Nomor Kasus</th>
                                <th scope="col" width="25%">Alasan</th>
                                <th scope="col" width="45%">Detail</th>
                                <th scope="col" width="5%">Validasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports_laporan as $report)
                            <tr class="text-center">
                                <td> <a class="text-decoration-none font-monospace" href="{{ route('post.slugorcode', $report->laporan->case_code) }}" target="_blank" data-toggle="tooltip" title="Lihat Lengkap">{{ $report->laporan->case_code }}</a></td>
                                <td>{{ $report->report_cat->cat_name }}</td>
                                <td>{{ Str::limit($report->detail, 40) ?? '-' }}</td>
                                <td>
                                    <div class="spinner-grow spinner-grow-sm text-warning" role="status">
                                        <span class="visually-hidden">Proses Validasi...</span>
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
            <div class="col-12">
                <div class="fs-4 fw-semibold">Report Member Terbaru</div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" width="25%">Nomor Kasus</th>
                                <th scope="col" width="25%">Alasan</th>
                                <th scope="col" width="45%">Detail</th>
                                <th scope="col" width="5%">Validasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports_member as $report)
                            <tr class="text-center">
                                <td> <a class="text-decoration-none font-monospace" href="{{ route('user_profile', $report->user->username) }}" target="_blank" data-toggle="tooltip" title="{{ '@'.$report->user->username }}">{{ $report->user->name }}</a></td>
                                <td>{{ $report->report_cat->cat_name }}</td>
                                <td>{{ Str::limit($report->detail, 40) ?? '-' }}</td>
                                <td>
                                    <div class="spinner-grow spinner-grow-sm text-warning" role="status">
                                        <span class="visually-hidden">Proses Validasi...</span>
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
    </div>
</div>

@endsection
