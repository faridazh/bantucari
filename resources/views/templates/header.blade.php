<!DOCTYPE html>
<html lang="id" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/custom.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/fonts/fontawesome/css/all.min.css')}}" rel="stylesheet" type="text/css">
        @yield('pagecss')

        <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/js/jquery.min.js')}}" type="text/javascript"></script>
        @yield('pagejs')

        <title>{{ $pagetitle }} - Bantu Cari</title>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light border bottom-5">
                <div class="container">
                    <a class="navbar-brand text-uppercase fw-bold" href="{{ route('home') }}">Bantu Cari</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarRespon" aria-controls="navbarRespon" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarRespon">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link {{Request::routeIs('home') ? 'active' : ''}}" href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Beranda</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-flag me-1"></i>Laporan</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{ route('post.index.barang') }}"><i class="fas fa-box fa-fw me-1"></i>Barang Hilang</a></li>
                                    <li><a class="dropdown-item" href="{{ route('post.index.kendaraan') }}"><i class="fas fa-car fa-fw me-1"></i>Kendaraan Hilang</a></li>
                                    <li><a class="dropdown-item" href="{{ route('post.index.orang') }}"><i class="fas fa-user-slash fa-fw me-1"></i>Orang Hilang</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('post.index') }}"><i class="fas fa-flag fa-fw me-1"></i>Laporan Kehilangan</a></li>
                                    <li><a class="dropdown-item" href="{{ route('post.index.temu') }}"><i class="fas fa-check-circle fa-fw me-1"></i>Laporan Ditemukan</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{Request::routeIs('donasi') ? 'active' : ''}}" href="{{ route('donasi') }}"><i class="fas fa-donate me-1"></i>Donasi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{Request::routeIs('about') ? 'active' : ''}}" href="{{ route('about') }}"><i class="fas fa-info-circle me-1"></i>Tentang Web</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-danger {{Request::routeIs(['post.category','post.create.barang','post.create.kendaraan','post.create.orang']) ? 'active fw-500' : ''}}" href="{{ route('post.category') }}"><i class="fas fa-flag me-1"></i>Lapor Kehilangan</a>
                            </li>
                        </ul>
                        <hr class="dropdown-divider my-3">
                        @authcheck
                        <div class="d-flex align-items-center">
                            <img src="{{asset('uploads/avatars'.'/'.Auth::user()->avatar)}}" class="border border-2 rounded-circle me-2" width="30" height="30" onerror="this.src='{{ asset('assets/images/default_avatar.png') }}';">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle px-0" href="#" id="userDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ strtok(Auth::user()->name, " ") }}</a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdownMenuLink">
                                        <li><a class="dropdown-item" href="{{ route('user_profile', Auth::user()->username) }}"><i class="fas fa-user-circle fa-fw me-1"></i>Profil Saya</a></li>
                                        <li><a class="dropdown-item" href="{{ route('user_pengaturan') }}"><i class="fas fa-user-cog fa-fw me-1"></i>Pengaturan</a></li>
                                        @staff
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="{{ route('staff.panel') }}"><i class="fas fa-user-tie fa-fw me-1"></i>Staff CP</a></li>
                                        @endstaff
                                        @admin
                                        <li><a class="dropdown-item" href="{{ route('admin.panel') }}"><i class="fas fa-user-secret fa-fw me-1"></i>Admin CP</a></li>
                                        @endadmin
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt fa-fw me-1"></i>Keluar</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        @else
                        <div class="d-flex">
                            <a href="{{ route('login') }}" class="btn {{Request::routeIs('login') ? 'btn-primary' : 'btn-outline-primary'}} me-2" @if(!Request::routeIs('login','register')) data-bs-toggle="modal" data-bs-target="#loginModal" @endif><i class="fas fa-sign-in-alt me-2"></i>Masuk</a>
                            <a href="{{ route('register') }}" class="btn {{Request::routeIs('register') ? 'btn-success' : 'btn-outline-success'}}"><i class="fas fa-user-plus me-2"></i>Daftar</a>
                        </div>
                        @endauthcheck
                    </div>
                </div>
            </nav>
        </header>
        <main class="container p-5" id="{{ $pageid }}">
            @if ($message = Session::get('verify-email'))
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </symbol>
            </svg>
            <div class="alert alert-info d-flex align-items-center py-2" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="20" height="20" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                <div>{{ $message }} <a href="{{ route('verification.send') }}" class="alert-link">Kirim ulang</a> link verifikasi.</div>
            </div>
            @endif
