@extends('templates.main')

@section('content')

<div class="mb-4">
    <h1 class="fw-normal">{{ $pagetitle }}</h1>
</div>
<div class="mb-5">
    <form class="row g-3 justify-content-center" action="{{ route('donasi_proses') }}" method="post" id="donation_form">
        @csrf
        <div class="col-lg-8">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="donor_name" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('donor_name') is-invalid @enderror" id="donor_name" name="donor_name" value="{{ Auth::user()->name ?? old('donor_name') ?? '' }}" required>
                    @error('donor_name')<div class="small invalid-feedback">Wajib isi!</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="donor_mail" class="form-label">Email</label>
                    <input type="email" class="form-control @error('donor_mail') is-invalid @enderror" id="donor_mail" name="donor_mail" value="{{ Auth::user()->email ?? old('donor_mail') ?? '' }}" required>
                    @error('donor_mail')<div class="small invalid-feedback">Wajib isi!</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="donation_type" class="form-label">Tipe Donasi</label>
                    <select id="donation_type" class="form-select @error('donation_type') is-invalid @enderror" name="donation_type" required>
                        <option value="Domain">Domain</option>
                        <option value="Server" selected>Server</option>
                    </select>
                    @error('donation_type')<div class="small invalid-feedback">Wajib pilih satu!</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="donor_amount" class="form-label">Jumlah</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                        <input type="number" class="form-control @error('donor_amount') is-invalid @enderror" id="donor_amount" name="donor_amount" value="{{ old('donor_amount') ?? '10000' }}" required>
                    </div>
                    @error('donor_amount')<div class="small invalid-feedback">Minimal Rp. 9000!</div>@enderror
                </div>
                <div class="col-12">
                    <label for="donor_note" class="form-label">Catatan (Opsional)</label>
                    <textarea class="form-control" id="donor_note" rows="3" name="donor_note">{{ old('donor_note') ?? '' }}</textarea>
                </div>
                <div class="col-12 text-center">
                    <button class="btn btn-success" type="submit">Donasi</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="mb-4">
    <div class="fs-4 fw-normal" id="list-donasi">Donatur</div>
</div>
<table class="table table-hover">
    <thead>
        <tr class="text-center">
            <th scope="col">Nama</th>
            <th scope="col">Tipe Donasi</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($donators as $donator)
        <tr class="text-center">
            <td width="30%">{{ $donator->donor_name }}</td>
            <td width="20%">{{ $donator->donation_type }}</td>
            <td width="20%">Rp. {{ number_format($donator->donor_amount) }}</td>
            <td width="30%">{{ date_format($donator->updated_at, 'l, j F Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="block mt-5 text-center">
    <div class="text-muted">Menampilkan {{ $donators->firstItem() ?? '0' }} sampai {{ $donators->lastItem() ?? '0' }} dari {{ $donators->total() }} data.</div>
    @if ($donators->lastPage() > 1)
    <div class="d-flex mt-5">
        <ul class="pagination ms-auto me-auto">
            @if($donators->currentPage() > $donators->onFirstPage()+2)
            <li class="page-item">
                <a class="page-link" href="{{$donators->url($donators->onFirstPage())}}" title="Halaman Awal">&laquo;</a>
            </li>
            @endif
            @if($donators->currentPage() > $donators->onFirstPage())
            <li class="page-item">
                <a class="page-link" href="{{$donators->previousPageUrl()}}" title="Halaman Sebelumnya">&lt;</a>
            </li>
            @endif
            @for ($i = 1; $i <= $donators->lastPage(); $i++)
                <?php
                $half_total_links = floor(7/2);
                $from = $donators->currentPage() - $half_total_links;
                $to = $donators->currentPage() + $half_total_links;
                if ($donators->currentPage() < $half_total_links) {
                   $to += $half_total_links - $donators->currentPage();
                }
                if ($donators->lastPage() - $donators->currentPage() < $half_total_links) {
                    $from -= $half_total_links - ($donators->lastPage() - $donators->currentPage()) - 1;
                }
                ?>
                @if ($from < $i && $i < $to)
                    <li class="page-item @if(($donators->currentPage() == $i)) active @endif">
                        <a href="{{ $donators->url($i) }}" class="page-link" @if($donators->currentPage() == $i)) title="Halaman Sekarang" @endif>{{ $i }}</a>
                    </li>
                @endif
            @endfor
            @if($donators->currentPage() < $donators->lastPage())
            <li class="page-item">
                <a class="page-link" href="{{ $donators->nextPageUrl() }}" title="Halaman Selanjutnya">&gt;</a>
            </li>
            @endif
            @if($donators->currentPage() < $donators->lastPage()-1)
            <li class="page-item">
                <a class="page-link" href="{{ $donators->url($donators->lastPage()) }}" title="Halaman Terakhir">&raquo;</a>
            </li>
            @endif
        </ul>
    </div>
    @endif
</div>

@endsection
