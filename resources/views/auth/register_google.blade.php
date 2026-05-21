@extends('layouts.app')

@section('content')
<style>
    .register-page {
        min-height: 100vh;
        background-color: #fafafa;
        padding: 40px 20px;
        font-family: 'Poppins', sans-serif;
    }
    
    .register-topbar {
        max-width: 900px;
        margin: 0 auto 30px auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .register-brand {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        text-decoration: none;
    }
    
    .register-brand span {
        color: #4f46e5;
    }
    
    .register-topbar-link {
        font-size: 14px;
        color: #6b7280;
    }
    
    .register-topbar-link a {
        color: #1f2937;
        font-weight: 600;
        text-decoration: none;
        margin-left: 8px;
        padding: 8px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        transition: all 0.2s;
    }
    
    .register-topbar-link a:hover {
        background: #f3f4f6;
    }
    
    .register-header {
        max-width: 900px;
        margin: 0 auto 40px auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .register-title-area h1 {
        font-size: 24px;
        color: #374151;
        margin-bottom: 30px;
        font-weight: 700;
    }
    
    /* Stepper */
    .stepper {
        display: flex;
        align-items: center;
        width: 100%;
        position: relative;
    }
    
    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        position: relative;
        z-index: 2;
    }
    
    .step-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #f3f4f6;
        color: #9ca3af;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 8px;
        transition: all 0.3s;
    }
    
    .step-label {
        font-size: 12px;
        font-weight: 500;
        color: #9ca3af;
        transition: all 0.3s;
    }
    
    .step-item.active .step-circle {
        background: #503d42;
        color: white;
        box-shadow: 0 4px 10px rgba(80, 61, 66, 0.2);
    }
    
    .step-item.active .step-label {
        color: #503d42;
        font-weight: 600;
    }
    
    .step-item.completed .step-circle {
        background: #10b981;
        color: white;
    }
    
    .step-item.completed .step-label {
        color: #10b981;
    }
    
    .stepper-line {
        position: absolute;
        top: 18px;
        left: 25%;
        right: 25%;
        height: 2px;
        background: #e5e7eb;
        z-index: 1;
    }
    
    .stepper-line-progress {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        background: #503d42;
        transition: width 0.3s ease;
    }
    
    /* Form Card */
    .register-card {
        background: white;
        border-radius: 16px;
        padding: 40px;
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        border: 1px solid #f3f4f6;
    }
    
    .form-section-title {
        font-size: 18px;
        font-weight: 600;
        color: #503d42;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }
    
    .form-label span.req {
        color: #ef4444;
    }
    
    .form-input-wrapper {
        position: relative;
    }

    .form-input-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px 12px 42px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s;
        background: #ffffff;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #503d42;
        box-shadow: 0 0 0 3px rgba(80, 61, 66, 0.1);
    }

    .form-input[readonly] {
        background: #f9fafb;
        color: #6b7280;
        cursor: not-allowed;
    }
    
    select.form-input {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 16px center;
        background-size: 16px;
        padding-right: 40px;
    }
    
    .form-error {
        color: #ef4444;
        font-size: 12px;
        margin-top: 6px;
    }
    
    .btn-action {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .btn-primary {
        background: #503d42;
        color: white;
    }
    
    .btn-primary:hover {
        background: #3d2f33;
    }
    
    .btn-secondary {
        background: white;
        color: #4b5563;
        border: 1px solid #d1d5db;
    }
    
    .btn-secondary:hover {
        background: #f9fafb;
    }
    
    .step-actions {
        display: flex;
        justify-content: flex-end;
        gap: 16px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #f3f4f6;
    }
    
    .text-center { text-align: center; }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>

<div class="register-page container-fluid px-2 px-md-0" style="min-height:100vh; background:#fafafa;">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-6">
            <div class="register-topbar d-flex flex-column flex-md-row justify-content-between align-items-center py-3">
                <a href="/" class="register-brand mb-2 mb-md-0"><span>Punish</span> Sistem</a>
                <div class="register-topbar-link">
                    Ganti Akun? <a href="{{ route('login') }}">&rarr; Masuk</a>
                </div>
            </div>
            <div class="register-header mb-3">
                <div class="register-title-area">
                    <h1 id="step-title" style="color: #503d42; font-size:1.2rem; font-weight:700;">Step 1 dari 3 : Informasi Akun Google</h1>
                </div>
            </div>
            <div class="mb-4">
                <div class="stepper d-flex flex-row justify-content-between align-items-center position-relative" style="width:100%;max-width:500px;margin:0 auto;">
                    <div class="stepper-line w-100 position-absolute" style="top:18px;left:0;right:0;height:2px;background:#e5e7eb;z-index:1;"></div>
                    <div class="step-item active text-center flex-fill position-relative" id="indicator-1">
                        <div class="step-circle">1</div>
                        <div class="step-label">Informasi Akun</div>
                    </div>
                    <div class="step-item text-center flex-fill position-relative" id="indicator-2">
                        <div class="step-circle">2</div>
                        <div class="step-label">Captcha</div>
                    </div>
                    <div class="step-item text-center flex-fill position-relative" id="indicator-3">
                        <div class="step-circle">3</div>
                        <div class="step-label">Verifikasi OTP</div>
                    </div>
                </div>
            </div>
            <div class="register-card bg-white rounded-4 p-3 p-md-5 shadow-sm border mx-auto" style="max-width:600px;">
        @if (session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                ❌ {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                ❌ Mohon periksa kembali form Anda.
                @if($errors->has('captcha'))
                    <br><strong>Captcha:</strong> {{ $errors->first('captcha') }}
                @endif
            </div>
        @endif

        <form action="{{ url('register/google') }}" method="POST" id="register-form">
            @csrf

            <!-- STEP 1 -->
            <div id="step-1">
                <div class="form-section-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    Data Akun Google Anda
                </div>
                
                <div class="grid-2">
                    <div class="form-group">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <div class="form-input-wrapper">
                            <span class="form-input-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></span>
                            <input type="text" id="name" name="name" class="form-input" value="{{ $googleInfo['name'] }}" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="form-input-wrapper">
                            <span class="form-input-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg></span>
                            <input type="email" id="email" name="email" class="form-input" value="{{ $googleInfo['email'] }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="departemen_id" class="form-label">Departemen <span class="req">*</span></label>
                    <div class="form-input-wrapper">
                        <span class="form-input-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path><path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M16 10h.01"></path><path d="M16 14h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path></svg></span>
                        <select id="departemen_id" name="departemen_id" class="form-input" required>
                            <option value="" disabled {{ old('departemen_id') ? '' : 'selected' }}>Pilih departemen Anda</option>
                            @foreach($departemens as $departemen)
                                <option value="{{ $departemen->id }}" {{ old('departemen_id') == $departemen->id ? 'selected' : '' }}>
                                    {{ $departemen->nama_departemen }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('departemen_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="step-actions">
                    <button type="button" class="btn-action btn-primary" onclick="nextStep()">
                        Selanjutnya &rarr;
                    </button>
                </div>
            </div>

            <!-- STEP 2 -->
            <div id="step-2" style="display: none;">
                <div class="form-section-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    Verifikasi Keamanan
                </div>

                <div class="form-group" style="max-width: 400px; margin: 0 auto; text-align: center;">
                    <label class="form-label text-center">Captcha <span class="req">*</span></label>
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 10px; margin-bottom: 16px;">
                        <img src="{{ route('captcha.image') }}?t={{ time() }}" alt="Captcha" id="captcha-img" style="border: 1px solid #e5e7eb; border-radius: 8px; height: 60px;">
                        <button type="button" class="btn-action btn-secondary" style="padding: 6px 16px; font-size: 12px;" onclick="document.getElementById('captcha-img').src = '{{ route('captcha.refresh') }}?' + Math.random()">
                            &#x21bb; Refresh Captcha
                        </button>
                    </div>
                    <div class="form-input-wrapper">
                        <span class="form-input-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></span>
                        <input type="text" id="captcha" name="captcha" class="form-input" style="text-align: center; padding-left: 16px;" placeholder="Ketik teks dari gambar" required autocomplete="off">
                    </div>
                    @error('captcha')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="step-actions">
                    <button type="button" class="btn-action btn-secondary" onclick="prevStep(1)">
                        &larr; Kembali
                    </button>
                    <button type="button" class="btn-action btn-primary" id="btn-send-otp" onclick="sendOtpAndNext()">
                        Verifikasi & Kirim OTP &rarr;
                    </button>
                </div>
            </div>

            <!-- STEP 3 -->
            <div id="step-3" style="display: none;">
                <div class="form-section-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    Verifikasi Email (OTP)
                </div>

                <div class="form-group" style="max-width: 400px; margin: 0 auto; text-align: center;">
                    <p style="font-size: 14px; color: #6b7280; margin-bottom: 20px;">Kami telah mengirimkan 6 digit kode OTP ke email Anda. Silakan periksa kotak masuk atau folder spam.</p>
                    
                    <label class="form-label text-center">Kode OTP <span class="req">*</span></label>
                    <div class="form-input-wrapper">
                        <span class="form-input-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg></span>
                        <input type="text" id="otp" name="otp" class="form-input" style="text-align: center; padding-left: 16px; font-size: 20px; letter-spacing: 4px;" placeholder="000000" maxlength="6" autocomplete="off" required>
                    </div>
                    @error('otp')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="step-actions">
                    <button type="button" class="btn-action btn-secondary" onclick="prevStep(2)">
                        &larr; Kembali
                    </button>
                    <button type="submit" class="btn-action btn-primary" id="btn-submit-final">
                        Selesaikan Pendaftaran &check;
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function updateStepper(step) {
        const title = document.getElementById('step-title');
        const ind1 = document.getElementById('indicator-1');
        const ind2 = document.getElementById('indicator-2');
        const ind3 = document.getElementById('indicator-3');
        const progress = document.getElementById('stepper-progress'); // We don't have this element, but it won't crash
        
        if (step === 1) {
            title.innerText = 'Step 1 dari 3 : Informasi Akun Google';
            ind1.className = 'step-item active';
            ind2.className = 'step-item';
            ind3.className = 'step-item';
        } else if (step === 2) {
            title.innerText = 'Step 2 dari 3 : Verifikasi Keamanan';
            ind1.className = 'step-item completed';
            ind2.className = 'step-item active';
            ind3.className = 'step-item';
        } else {
            title.innerText = 'Step 3 dari 3 : Verifikasi OTP';
            ind1.className = 'step-item completed';
            ind2.className = 'step-item completed';
            ind3.className = 'step-item active';
        }
    }

    function nextStep() {
        const step1Inputs = document.querySelectorAll('#step-1 input, #step-1 select');
        let isValid = true;
        
        for (let input of step1Inputs) {
            if (!input.checkValidity()) {
                input.reportValidity();
                isValid = false;
                break;
            }
        }
        
        if (isValid) {
            document.getElementById('step-1').style.display = 'none';
            document.getElementById('step-2').style.display = 'block';
            document.getElementById('step-3').style.display = 'none';
            updateStepper(2);
        }
    }
    
    function prevStep(toStep) {
        if (toStep === 1) {
            document.getElementById('step-2').style.display = 'none';
            document.getElementById('step-3').style.display = 'none';
            document.getElementById('step-1').style.display = 'block';
            updateStepper(1);
        } else if (toStep === 2) {
            document.getElementById('step-3').style.display = 'none';
            document.getElementById('step-1').style.display = 'none';
            document.getElementById('step-2').style.display = 'block';
            updateStepper(2);
        }
    }

    function sendOtpAndNext() {
        const email = document.getElementById('email').value;
        const captcha = document.getElementById('captcha').value;
        const btn = document.getElementById('btn-send-otp');
        const token = document.querySelector('input[name="_token"]').value;

        if (!captcha) {
            document.getElementById('captcha').reportValidity();
            return;
        }

        const originalText = btn.innerHTML;
        btn.innerHTML = '<span style="display:inline-block; animation: spin 1s linear infinite;">⏳</span> Mengirim OTP...';
        btn.disabled = true;

        fetch('{{ route("register.send-otp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email: email, captcha: captcha })
        })
        .then(response => response.json())
        .then(data => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            if (data.success) {
                // Berhasil, pindah ke step 3
                document.getElementById('step-2').style.display = 'none';
                document.getElementById('step-3').style.display = 'block';
                updateStepper(3);
                
                // Show a small toast or message
                alert('Kode OTP berhasil dikirim ke ' + email + '. Silakan periksa email Anda.');
            } else {
                // Gagal, biasanya karena captcha salah atau email bermasalah
                alert(data.message || 'Gagal mengirim OTP. Pastikan email belum terdaftar dan Captcha benar.');
                if (data.errors && data.errors.captcha) {
                    // refresh captcha
                    document.getElementById('captcha-img').src = '{{ route("captcha.refresh") }}?' + Math.random();
                    document.getElementById('captcha').value = '';
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            btn.innerHTML = originalText;
            btn.disabled = false;
            alert('Terjadi kesalahan sistem. Pastikan koneksi internet Anda stabil.');
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const submitBtn = document.getElementById('btn-submit-final');
        const form = document.getElementById('register-form');
        
        // Prevent silent failure when hidden fields are invalid
        submitBtn.addEventListener('click', function(e) {
            const step1Inputs = document.querySelectorAll('#step-1 input, #step-1 select');
            let step1Valid = true;
            for (let input of step1Inputs) {
                if (!input.checkValidity()) {
                    step1Valid = false;
                    break;
                }
            }
            
            if (!step1Valid) {
                e.preventDefault();
                prevStep(1); // switch to step 1
                setTimeout(() => {
                    form.reportValidity(); // show validation message
                }, 50);
            }
        });
    });
</script>
@endsection
