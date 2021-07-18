<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase fw-bold" id="loginModalLabel">Masuk</h5>
                <a href="{{ route('password.request') }}" class="ms-auto text-decoration-none">Lupa Password</a>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('postlogin') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="imputEmailModal" class="col-form-label fw-bold">Email</label>
                        <input type="email" class="form-control" id="imputEmailModal" name="email" value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                        <label for="imputPassModal" class="col-form-label fw-bold">Password</label>
                        <input type="password" class="form-control" id="imputPassModal" name="password" value="{{ old('password') }}">
                    </div>
                    <div class="mb-3 text-center">
                        <div class="captcha">
                            <span>{!! captcha_img() !!}</span>
                            <button type="button" class="btn btn-danger" class="reload" id="reload">&#x21bb;</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input id="captcha" type="text" class="form-control text-center @error('captcha') is-invalid @enderror" placeholder="Captcha" name="captcha" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-check me-auto">
                        <input class="form-check-input" type="checkbox" id="rememberCheckModal" name="rememberMe" checked>
                        <label class="form-check-label" for="rememberCheckModal">Ingat Saya</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Masuk</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('templates.captcha')
