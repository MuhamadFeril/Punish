@extends('layouts.app')

@section('content')
<style>
    .otp-shell {
        min-height: calc(100vh - 240px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 32px 16px 56px;
    }

    .otp-card {
        width: 100%;
        max-width: 460px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
    }

    .otp-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: #eefbf3;
        color: #0f9f57;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 18px;
    }

    .otp-title {
        font-size: 30px;
        line-height: 1.2;
        font-weight: 700;
        color: #111827;
        margin-bottom: 10px;
    }

    .otp-copy {
        color: #6b7280;
        font-size: 15px;
        line-height: 1.7;
        margin-bottom: 24px;
    }

    .otp-field {
        margin-bottom: 18px;
    }

    .otp-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 10px;
    }

    .otp-input {
        width: 100%;
        height: 64px;
        border: 1px solid #d1d5db;
        border-radius: 18px;
        padding: 0 18px;
        font-size: 28px;
        font-weight: 700;
        letter-spacing: 10px;
        text-align: center;
        color: #111827;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .otp-input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
    }

    .otp-input.is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
    }

    .otp-error {
        display: block;
        margin-top: 10px;
        color: #dc2626;
        font-size: 13px;
        font-weight: 500;
    }

    .otp-actions {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-top: 22px;
        flex-direction: column;
    }

    .otp-button {
        width: 100%;
        border: none;
        border-radius: 18px;
        background: linear-gradient(135deg, #4f46e5 0%, #2563eb 100%);
        color: #ffffff;
        font-size: 16px;
        font-weight: 700;
        padding: 16px 22px;
        cursor: pointer;
        box-shadow: 0 16px 30px rgba(37, 99, 235, 0.24);
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .otp-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 18px 34px rgba(37, 99, 235, 0.3);
    }

    .otp-button-secondary {
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 18px;
        background: #ffffff;
        color: #374151;
        font-size: 15px;
        font-weight: 600;
        padding: 14px 18px;
        cursor: pointer;
        transition: border-color 0.18s ease, background 0.18s ease;
    }

    .otp-button-secondary:hover {
        border-color: #9ca3af;
        background: #f9fafb;
    }

    .otp-note {
        margin-top: 16px;
        font-size: 13px;
        color: #6b7280;
        text-align: center;
    }

    @media (max-width: 640px) {
        .otp-card {
            padding: 24px 18px;
            border-radius: 20px;
        }

        .otp-title {
            font-size: 24px;
        }

        .otp-input {
            height: 58px;
            font-size: 24px;
            letter-spacing: 6px;
        }
    }
</style>

<div class="otp-shell">
    <div class="otp-card">
        <div class="otp-kicker">Verifikasi tahap akhir</div>
        <h1 class="otp-title">Masukkan kode OTP</h1>
        <p class="otp-copy">
            Kode verifikasi 6 digit sudah dikirim ke email Anda. Masukkan kodenya untuk menyelesaikan proses login dan membuka akses ke dashboard.
        </p>

        <form method="POST" action="{{ route('otp.verify') }}">
            @csrf

            <div class="otp-field">
                <label for="otp" class="otp-label">Kode OTP</label>
                <input
                    type="text"
                    name="otp"
                    id="otp"
                    class="otp-input @error('otp') is-invalid @enderror"
                    value="{{ old('otp') }}"
                    inputmode="numeric"
                    pattern="[0-9]{6}"
                    maxlength="6"
                    autocomplete="one-time-code"
                    placeholder="000000"
                    required
                    autofocus
                >
                @error('otp')
                    <span class="otp-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="otp-actions">
                <button type="submit" class="otp-button">Verifikasi dan lanjut</button>
            </div>
        </form>

        <form method="POST" action="{{ route('otp.resend') }}" style="margin-top: 12px;">
            @csrf
            <button type="submit" class="otp-button-secondary">Kirim ulang OTP</button>
        </form>

        <p class="otp-note">Belum menerima email? Periksa folder spam atau ulangi proses login untuk mengirim kode baru.</p>
    </div>
</div>

<script>
    const otpInput = document.getElementById('otp');

    if (otpInput) {
        otpInput.addEventListener('input', function () {
            this.value = this.value.replace(/\D+/g, '').slice(0, 6);
        });

        otpInput.addEventListener('paste', function () {
            requestAnimationFrame(() => {
                this.value = this.value.replace(/\D+/g, '').slice(0, 6);
            });
        });
    }
</script>
@endsection
