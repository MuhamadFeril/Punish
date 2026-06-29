@extends('layouts.app')

@section('content')
<div class="auth-shell min-h-[calc(100dvh-10rem)] flex items-center justify-center">
    <section class="auth-card max-w-md p-5 sm:p-8">
        <div class="mb-7 text-center">
            <p class="text-sm font-semibold text-indigo-600">Punish Sistem</p>
            <h1 class="mt-2 text-2xl sm:text-3xl font-bold text-slate-950">Selamat Datang</h1>
            <p class="mt-2 text-sm text-slate-500">Masuk ke Sistem Manajemen Pelanggaran</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                <input type="email" id="email" name="email" class="form-control-modern" value="{{ old('email') }}" placeholder="your@email.com" autocomplete="email" required>
                @error('email')
                    <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                <input type="password" id="password" name="password" class="form-control-modern" placeholder="Minimal 8 karakter" autocomplete="current-password" required>
                @error('password')
                    <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="captcha" class="mb-2 block text-sm font-semibold text-slate-700">Verifikasi Captcha</label>
                <div class="mb-3 flex flex-col gap-3 min-[380px]:flex-row min-[380px]:items-center">
                    <img src="{{ route('captcha.image') }}" alt="Captcha" id="captcha-img" class="h-12 w-full min-[380px]:w-52 rounded-lg border border-slate-200 bg-white object-cover">
                    <button type="button" onclick="document.getElementById('captcha-img').src = '{{ route('captcha.refresh') }}?' + Math.random()" class="btn-secondary-modern px-4 text-sm">
                        Refresh
                    </button>
                </div>
                <input type="text" id="captcha" name="captcha" class="form-control-modern" placeholder="Ketik teks dari gambar" required autocomplete="off">
                @error('captcha')
                    <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-primary-modern w-full px-4 text-sm">Login</button>
        </form>

        <div class="my-6 flex items-center gap-3">
            <div class="h-px flex-1 bg-slate-200"></div>
            <span class="text-xs font-semibold uppercase text-slate-400">Atau</span>
            <div class="h-px flex-1 bg-slate-200"></div>
        </div>

        <a href="{{ route('google.login') }}" class="btn-secondary-modern w-full px-4 text-sm">Masuk dengan Google</a>

        <p class="mt-7 text-center text-sm text-slate-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">Daftar di sini</a>
        </p>
    </section>
</div>
@endsection
