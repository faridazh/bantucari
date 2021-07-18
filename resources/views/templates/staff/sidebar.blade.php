@section('pagecss')
<link href="{{asset('assets/css/staffcp.min.css')}}" rel="stylesheet" type="text/css">
@endsection

<div class="col-md-2 p-3">
    <ul class="list-unstyled ps-0">
        <li class="mb-2">
            <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="{{Request::routeIs(['staff.panel']) ? 'true' : 'false'}}">Dashboard</button>
            <div class="collapse my-2 {{Request::routeIs(['staff.panel']) ? 'show' : ''}}" id="dashboard-collapse" style="">
                <ul class="btn-toggle-nav list-unstyled fw-normal">
                    <li><a href="{{ route('staff.panel') }}" class="{{Request::routeIs('staff.panel') ? 'active' : ''}} link-dark rounded">Rincian</a></li>
                </ul>
            </div>
        </li>
        <li class="mb-2">
            <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#laporan-collapse" aria-expanded="{{Request::routeIs(['staff.laporan.validasi.page','staff.report.laporan.page']) ? 'true' : 'false'}}">Laporan</button>
            <div class="collapse my-2 {{Request::routeIs(['staff.laporan.validasi.page','staff.report.laporan.page']) ? 'show' : ''}}" id="laporan-collapse" style="">
                <ul class="btn-toggle-nav list-unstyled fw-normal">
                    <li><a href="{{ route('staff.laporan.validasi.page') }}" class="{{Request::routeIs('staff.laporan.validasi.page') ? 'active' : ''}} link-dark rounded">Validasi</a></li>
                    @moderator
                    <li><a href="{{ route('staff.report.laporan.page') }}" class="{{Request::routeIs('staff.report.laporan.page') ? 'active' : ''}} link-dark rounded">Report</a></li>
                    @endmoderator
                </ul>
            </div>
        </li>
        <li class="mb-2">
            <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#member-collapse" aria-expanded="{{Request::routeIs(['staff.member.validasi.page','staff.report.member.page']) ? 'true' : 'false'}}">Member</button>
            <div class="collapse my-2 {{Request::routeIs(['staff.member.validasi.page','staff.report.member.page']) ? 'show' : ''}}" id="member-collapse" style="">
                <ul class="btn-toggle-nav list-unstyled fw-normal">
                    <li><a href="{{ route('staff.member.validasi.page') }}" class="{{Request::routeIs(['staff.member.validasi.page']) ? 'active' : ''}} link-dark rounded">Aktivasi</a></li>
                    @moderator
                    <li><a href="{{ route('staff.report.member.page') }}" class="{{Request::routeIs('staff.report.member.page') ? 'active' : ''}} link-dark rounded">Report</a></li>
                    @endmoderator
                </ul>
            </div>
        </li>
    </ul>
</div>
