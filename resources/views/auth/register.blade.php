@extends('layouts.app')

@section('content')
<div class="auth-shell register-auth-page">
    <div class="mx-auto w-full max-w-5xl">
        <div class="register-auth-topbar mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <a href="/" class="text-xl font-bold text-slate-950"><span class="text-indigo-600">Punish</span> Sistem</a>
            <div class="register-auth-login flex flex-col gap-2 text-sm text-slate-500 sm:flex-row sm:items-center">
                <span>Sudah punya akun?</span>
                <a href="{{ route('login') }}" class="btn-secondary-modern px-4 text-sm">Masuk</a>
            </div>
        </div>

        <div class="register-auth-heading mb-8">
            <h1 id="step-title" class="text-xl sm:text-2xl font-bold text-slate-900">Step 1 dari 3: Informasi Akun</h1>
            <p class="mt-2 text-sm text-slate-500">Lengkapi data akun, captcha, lalu verifikasi OTP email.</p>
        </div>

        <div class="register-stepper mx-auto mb-8 w-full max-w-2xl">
            <div class="relative grid grid-cols-3 gap-2">
                <div class="absolute left-[16%] right-[16%] top-5 h-0.5 bg-slate-200"></div>
                <div id="stepper-progress" class="absolute left-[16%] top-5 h-0.5 w-0 bg-indigo-600 transition-all duration-300"></div>
                <div class="step-item active relative z-10 flex flex-col items-center gap-2 text-center" id="indicator-1">
                    <span class="step-circle flex h-10 w-10 items-center justify-center rounded-full bg-indigo-600 text-sm font-bold text-white shadow-sm">1</span>
                    <span class="step-label text-xs font-semibold text-slate-900">Informasi Akun</span>
                </div>
                <div class="step-item relative z-10 flex flex-col items-center gap-2 text-center" id="indicator-2">
                    <span class="step-circle flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-sm font-bold text-slate-400">2</span>
                    <span class="step-label text-xs font-semibold text-slate-400">Captcha</span>
                </div>
                <div class="step-item relative z-10 flex flex-col items-center gap-2 text-center" id="indicator-3">
                    <span class="step-circle flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-sm font-bold text-slate-400">3</span>
                    <span class="step-label text-xs font-semibold text-slate-400">Verifikasi OTP</span>
                </div>
            </div>
        </div>

        <section class="auth-card mx-auto max-w-3xl p-5 sm:p-8">
            @if (session('error'))
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <p class="font-semibold">Mohon periksa kembali form Anda.</p>
                    @if($errors->has('captcha'))
                        <p class="mt-1">Captcha: {{ $errors->first('captcha') }}</p>
                    @endif
                    @if($errors->has('otp'))
                        <p class="mt-1">OTP: {{ $errors->first('otp') }}</p>
                    @endif
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" id="register-form" novalidate>
                @csrf

                <div id="step-1" class="space-y-5">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Pengaturan Akun</h2>
                        <p class="mt-1 text-sm text-slate-500">Gunakan email aktif untuk menerima kode OTP.</p>
                    </div>

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" class="form-control-modern" value="{{ old('name') }}" placeholder="John Doe" autocomplete="name" required>
                            @error('name')<p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email <span class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email" class="form-control-modern" value="{{ old('email') }}" placeholder="your@email.com" autocomplete="email" required>
                            @error('email')<p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="departemen_id" class="mb-2 block text-sm font-semibold text-slate-700">Departemen <span class="text-red-500">*</span></label>
                        <select id="departemen_id" name="departemen_id" class="form-control-modern" required>
                            <option value="" disabled {{ old('departemen_id') ? '' : 'selected' }}>Pilih departemen Anda</option>
                            @foreach($departemens as $departemen)
                                <option value="{{ $departemen->id }}" {{ old('departemen_id') == $departemen->id ? 'selected' : '' }}>{{ $departemen->nama_departemen }}</option>
                            @endforeach
                        </select>
                        @error('departemen_id')<p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password <span class="text-red-500">*</span></label>
                            <input type="password" id="password" name="password" class="form-control-modern" placeholder="Minimal 8 karakter" autocomplete="new-password" required>
                            @error('password')<p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">Konfirmasi Password <span class="text-red-500">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control-modern" placeholder="Ulangi password" autocomplete="new-password" required>
                            @error('password_confirmation')<p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="flex justify-end border-t border-slate-100 pt-5">
                        <button type="button" class="btn-primary-modern w-full px-5 text-sm sm:w-auto" onclick="nextStep()">Selanjutnya</button>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="h-px flex-1 bg-slate-200"></div>
                        <span class="text-xs font-semibold uppercase text-slate-400">Atau</span>
                        <div class="h-px flex-1 bg-slate-200"></div>
                    </div>

                    <a href="{{ route('google.login') }}" class="btn-secondary-modern w-full px-4 text-sm">Daftar dengan Google</a>
                </div>

                <div id="step-2" class="hidden space-y-5">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Verifikasi Keamanan</h2>
                        <p class="mt-1 text-sm text-slate-500">Masukkan teks captcha sebelum OTP dikirim.</p>
                    </div>

                    <div class="mx-auto max-w-md text-center">
                        <label for="captcha" class="mb-3 block text-sm font-semibold text-slate-700">Captcha <span class="text-red-500">*</span></label>
                        <div class="mb-4 flex flex-col items-center gap-3 sm:flex-row sm:justify-center">
                            <img src="{{ route('captcha.image') }}?t={{ time() }}" alt="Captcha" id="captcha-img" class="h-14 w-full max-w-64 rounded-lg border border-slate-200 bg-white object-cover">
                            <button type="button" class="btn-secondary-modern px-4 text-sm" onclick="document.getElementById('captcha-img').src = '{{ route('captcha.refresh') }}?' + Math.random()">Refresh</button>
                        </div>
                        <input type="text" id="captcha" name="captcha" class="form-control-modern text-center" placeholder="Ketik teks dari gambar" required autocomplete="off">
                        @error('captcha')<p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                        <button type="button" class="btn-secondary-modern px-5 text-sm" onclick="prevStep(1)">Kembali</button>
                        <button type="button" class="btn-primary-modern px-5 text-sm" id="btn-send-otp" onclick="sendOtpAndNext()">Verifikasi & Kirim OTP</button>
                    </div>
                </div>

                <div id="step-3" class="hidden space-y-5">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Verifikasi Email</h2>
                        <p class="mt-1 text-sm text-slate-500">Masukkan 6 digit kode OTP yang dikirim ke email Anda.</p>
                    </div>

                    <div class="mx-auto max-w-md text-center">
                        <label for="otp" class="mb-2 block text-sm font-semibold text-slate-700">Kode OTP <span class="text-red-500">*</span></label>
                        <input type="text" id="otp" name="otp" class="form-control-modern text-center text-xl" placeholder="000000" maxlength="6" inputmode="numeric" autocomplete="one-time-code" required>
                        @error('otp')<p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                        <button type="button" class="btn-secondary-modern px-5 text-sm" onclick="prevStep(2)">Kembali</button>
                        <button type="submit" class="btn-primary-modern px-5 text-sm" id="btn-submit-final">Selesaikan Pendaftaran</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>

<script>
    const stepTitles = {
        1: 'Step 1 dari 3: Informasi Akun',
        2: 'Step 2 dari 3: Verifikasi Keamanan',
        3: 'Step 3 dari 3: Verifikasi OTP'
    };

    function setStepVisibility(step) {
        [1, 2, 3].forEach((item) => {
            document.getElementById(`step-${item}`).classList.toggle('hidden', item !== step);
        });
    }

    function updateStepper(step) {
        document.getElementById('step-title').innerText = stepTitles[step];
        document.getElementById('stepper-progress').style.width = step === 1 ? '0%' : step === 2 ? '34%' : '68%';

        [1, 2, 3].forEach((item) => {
            const indicator = document.getElementById(`indicator-${item}`);
            const circle = indicator.querySelector('.step-circle');
            const label = indicator.querySelector('.step-label');
            const isActive = item === step;
            const isDone = item < step;

            circle.className = 'step-circle flex h-10 w-10 items-center justify-center rounded-full text-sm font-bold shadow-sm ' + (isActive || isDone ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-400');
            label.className = 'step-label text-xs font-semibold ' + (isActive || isDone ? 'text-slate-900' : 'text-slate-400');
        });
    }

    function validateStep(step) {
        const fields = document.querySelectorAll(`#step-${step} input, #step-${step} select`);
        for (const field of fields) {
            if (!field.checkValidity()) {
                field.reportValidity();
                return false;
            }
        }
        return true;
    }

    function nextStep() {
        if (!validateStep(1)) return;
        setStepVisibility(2);
        updateStepper(2);
    }

    function prevStep(step) {
        setStepVisibility(step);
        updateStepper(step);
    }

    function sendOtpAndNext() {
        if (!validateStep(2)) return;

        const email = document.getElementById('email').value;
        const captcha = document.getElementById('captcha').value;
        const button = document.getElementById('btn-send-otp');
        const token = document.querySelector('input[name="_token"]').value;
        const originalText = button.innerHTML;

        button.innerHTML = 'Mengirim OTP...';
        button.disabled = true;
        button.style.opacity = '0.7';

        fetch('{{ route("register.send-otp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email, captcha })
        })
        .then(response => response.json())
        .then(data => {
            button.innerHTML = originalText;
            button.disabled = false;
            button.style.opacity = '1';

            if (data.success) {
                setStepVisibility(3);
                updateStepper(3);
                return;
            }

            alert(data.message || 'Gagal mengirim OTP. Pastikan email belum terdaftar dan captcha benar.');
            document.getElementById('captcha-img').src = '{{ route("captcha.refresh") }}?' + Math.random();
            document.getElementById('captcha').value = '';
        })
        .catch(() => {
            button.innerHTML = originalText;
            button.disabled = false;
            button.style.opacity = '1';
            alert('Terjadi kesalahan sistem. Coba lagi beberapa saat.');
        });
    }

    document.getElementById('register-form').addEventListener('submit', function (event) {
        if (!validateStep(1)) {
            event.preventDefault();
            prevStep(1);
            return;
        }

        if (!validateStep(2)) {
            event.preventDefault();
            prevStep(2);
        }
    });
</script>
@endsection
