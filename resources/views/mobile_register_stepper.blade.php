@extends('layouts.mobile')
@section('content')
<div class="container mt-4 mb-5">
    <!-- Stepper -->
    <div class="d-flex justify-content-center mb-4">
        <div class="stepper d-flex flex-row justify-content-between w-75">
            <div class="step active text-center">
                <div class="circle">1</div>
                <div class="label small">Informasi Akun</div>
            </div>
            <div class="step text-center">
                <div class="circle">2</div>
                <div class="label small">Captcha</div>
            </div>
            <div class="step text-center">
                <div class="circle">3</div>
                <div class="label small">Verifikasi OTP</div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Pengaturan Akun</h5>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="name" name="name" required autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="departemen" class="form-label">Departemen</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-building"></i></span>
                        <select class="form-select" id="departemen" name="departemen">
                            <option selected disabled>Pilih departemen</option>
                            <!-- @foreach($departemen as $d)
                                <option value="{{ $d->id }}">{{ $d->nama }}</option>
                            @endforeach -->
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-dark w-100 mb-3">Selanjutnya &rarr;</button>
            </form>
            <div class="text-center mb-2 text-muted">ATAU</div>
            <a href="{{ route('google.login') }}" class="btn btn-primary w-100" style="background: #4285F4; border:none;">
                <i class="bi bi-google me-2"></i> Daftar dengan Google
            </a>
        </div>
    </div>
</div>
<!-- Stepper CSS -->
<style>
    .stepper .step .circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #6c757d;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 4px auto;
        font-weight: bold;
    }
    .stepper .step.active .circle {
        background: #3d2c23;
        color: #fff;
        border-color: #3d2c23;
    }
    .stepper .step .label {
        font-size: 0.8rem;
        color: #6c757d;
    }
    .stepper .step.active .label {
        color: #3d2c23;
        font-weight: bold;
    }
</style>
<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
