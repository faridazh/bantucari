        </main>
        <footer class="bg-light pt-5">
            <div class="container">
                <div class="row justify-content-center text-muted mb-4">
                    <div class="col-8">
                        <div class="row g-5 justify-content-center">
                            <div class="col-md-6 col-lg-3">
                                <h6 class="mb-3 text-uppercase fw-bold"><i class="fas fa-globe me-2"></i>Halaman</h6>
                                <ul class="list-unstyled text-small">
                                    <li class="mb-1">
                                        <a href="{{ route('home') }}" class="link-secondary text-decoration-none">Beranda</a>
                                    </li>
                                    <li class="mb-1">
                                        <a href="{{ route('post.category') }}" class="link-secondary text-decoration-none">Laporan</a>
                                    </li>
                                    <li class="mb-1">
                                        <a href="{{ route('donasi') }}" class="link-secondary text-decoration-none">Donasi</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <h6 class="mb-3 text-uppercase fw-bold"><i class="fas fa-file me-2"></i>Laporan</h6>
                                <ul class="list-unstyled text-small">
                                    <li class="mb-1">
                                        <a href="{{ route('post.index.barang') }}" class="link-secondary text-decoration-none">Barang Hilang</a>
                                    </li>
                                    <li class="mb-1">
                                        <a href="{{ route('post.index.kendaraan') }}" class="link-secondary text-decoration-none">Kendaraan Hilang</a>
                                    </li>
                                    <li class="mb-1">
                                        <a href="{{ route('post.index.orang') }}" class="link-secondary text-decoration-none">Orang Hilang</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <h6 class="mb-3 text-uppercase fw-bold"><i class="fas fa-gavel me-2"></i>Ketentuan</h6>
                                <ul class="list-unstyled text-small">
                                    <li class="mb-1">
                                        <a href="#" class="link-secondary text-decoration-none">Kebijakan Privasi</a>
                                    </li>
                                    <li class="mb-1">
                                        <a href="#" class="link-secondary text-decoration-none">Persyaratan Layanan</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <h6 class="mb-3 text-uppercase fw-bold"><i class="fas fa-id-card me-2"></i>Kontak Kami</h6>
                                <ul class="list-unstyled text-small">
                                    <li class="mb-3">
                                        <a href="{{ route('about') }}" class="link-secondary text-decoration-none">Tentang Web</a>
                                    </li>
                                    <li class="mb-1">(+62) 812 3456 7890</li>
                                    <li class="mb-1">
                                        <a href="mailto:support@bantucari.id" class="link-secondary text-decoration-none">support@bantucari.id</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-md-block d-lg-flex border-top small text-muted text-center p-3">
                    <div><i class="far fa-copyright me-1"></i>Bantu Cari, 2021.</div>
                    <div class="ms-auto">Dibuat dengan <i class="fas fa-heart"></i> &amp; <i class="fas fa-coffee"></i> di <a class="text-decoration-none text-reset" href="https://www.google.com/maps/place/Jakarta/" target="_blank">Indonesia</a>.</div>
                    <!-- <div class="ms-auto">Dibuat dengan <a class="text-decoration-none" href="https://laravel.com/" target="_blank"><i class="fab fa-laravel me-1"></i>Laravel</a> dan <a class="text-decoration-none" href="https://getbootstrap.com/" target="_blank"><i class="fab fa-bootstrap me-1"></i>Bootstrap</a></div> -->
                </div>
            </div>
        </footer>
    </body>
    @if(!Request::routeIs('login','register'))
        @notauth
            @include('users.loginmodal')
        @endnotauth
    @endif

    @include('sweetalert::alert')

    <script type="text/javascript">
        $(document).ready(function () {
            $('img').on('dragstart', function () {
               return false;
            });
            $('img').on('contextmenu', function () {
               return false;
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</html>
