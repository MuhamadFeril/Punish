@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 400px; margin: 40px auto;">
    <h2 style="margin-bottom: 20px; font-size: 18px; color: #1f2937; font-weight: 600;">Test Captcha</h2>

    <form action="{{ route('captcha.validate') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-size: 13px; font-weight: 500; color: #4b5563;">Gambar Captcha</label>
            <div style="display: flex; align-items: center; gap: 10px;">
                <img src="{{ route('captcha.image') }}" alt="Captcha" id="captcha-img" style="border: 1px solid #e5e7eb; border-radius: 8px; height: 40px;">
                <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('captcha-img').src = '{{ route('captcha.refresh') }}?' + Math.random()">
                    ↻ Refresh
                </button>
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <label for="captcha" style="display: block; margin-bottom: 8px; font-size: 13px; font-weight: 500; color: #4b5563;">Masukkan Teks di Atas</label>
            <input type="text" name="captcha" id="captcha" required autocomplete="off"
                   style="width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; outline: none; transition: all 0.2s;"
                   onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99, 102, 241, 0.1)'"
                   onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'"
                   placeholder="Ketik teks...">
            @error('captcha')
                <span style="color: #ef4444; font-size: 12px; margin-top: 6px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%;">Validasi Captcha</button>
    </form>
</div>
@endsection
