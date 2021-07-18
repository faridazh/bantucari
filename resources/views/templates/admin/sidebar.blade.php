@section('pagecss')
<link href="{{asset('assets/css/staffcp.min.css')}}" rel="stylesheet" type="text/css">
@endsection

<div class="col-md-2 p-3">
    <ul class="list-unstyled ps-0">
        <li class="mb-2">
            <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="{{Request::routeIs(['admin.panel']) ? 'true' : 'false'}}">Dashboard</button>
            <div class="collapse my-2 {{Request::routeIs(['admin.panel']) ? 'show' : ''}}" id="dashboard-collapse" style="">
                <ul class="btn-toggle-nav list-unstyled fw-normal">
                    <li><a href="{{ route('admin.panel') }}" class="{{Request::routeIs('admin.panel') ? 'active' : ''}} link-dark rounded">Rincian</a></li>
                </ul>
            </div>
        </li>
        <li class="mb-2">
            <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#setting-collapse" aria-expanded="{{Request::routeIs(['admin.setting.user','admin.setting.laporan']) ? 'true' : 'false'}}">Pengaturan</button>
            <div class="collapse my-2 {{Request::routeIs(['admin.setting.user','admin.setting.laporan']) ? 'show' : ''}}" id="setting-collapse" style="">
                <ul class="btn-toggle-nav list-unstyled fw-normal">
                    <li><a href="{{ route('admin.setting.laporan') }}" class="{{Request::routeIs('admin.setting.laporan') ? 'active' : ''}} link-dark rounded">Laporan</a></li>
                    <li><a href="{{ route('admin.setting.user') }}" class="{{Request::routeIs('admin.setting.user') ? 'active' : ''}} link-dark rounded">User</a></li>
                </ul>
            </div>
        </li>
    </ul>
</div>
