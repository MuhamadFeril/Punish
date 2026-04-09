@extends('layouts.app')

@section('content')
<style>
    .register-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
        animation: gradientShift 8s ease infinite;
    }
    
    @keyframes gradientShift {
        0% { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        50% { background: linear-gradient(135deg, #764ba2 0%, #667eea 100%); }
        100% { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    }
    
    .register-container::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        top: -150px;
        left: -150px;
        animation: float 6s ease-in-out infinite;
    }
    
    .register-container::after {
        content: '';
        position: absolute;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
        bottom: -100px;
        right: -100px;
        animation: float 8s ease-in-out infinite reverse;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(30px); }
    }
    
    .register-form {
        background: white;
        border-radius: 16px;
        padding: 40px;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: slideInUp 0.6s ease-out;
        position: relative;
        z-index: 1;
        max-height: 90vh;
        overflow-y: auto;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .form-group {
        margin-bottom: 20px;
        animation: fadeInLeft 0.5s ease-out backwards;
    }
    
    .form-group:nth-child(1) { animation-delay: 0.2s; }
    .form-group:nth-child(2) { animation-delay: 0.3s; }
    .form-group:nth-child(3) { animation-delay: 0.4s; }
    .form-group:nth-child(4) { animation-delay: 0.5s; }
    .form-group:nth-child(5) { animation-delay: 0.6s; }
    
    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        transition: color 0.3s ease;
    }
    
    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #f9fafb;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        background: white;
    }
    
    .form-error {
        color: #dc2626;
        font-size: 13px;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
        animation: shake 0.3s ease;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    .submit-btn {
        width: 100%;
        padding: 12px 16px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-top: 12px;
    }
    
    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }
    
    .submit-btn:active {
        transform: translateY(0);
    }
    
    .register-footer {
        margin-top: 20px;
        text-align: center;
        font-size: 14px;
        color: #6b7280;
        animation: fadeIn 0.6s ease-out 1s backwards;
    }
    
    .register-footer a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .register-footer a::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transition: width 0.3s ease;
    }
    
    .register-footer a:hover::after {
        width: 100%;
    }
    
    .register-header {
        text-align: center;
        margin-bottom: 32px;
        animation: fadeIn 0.6s ease-out 0.2s backwards;
    }
    
    .register-title {
        font-size: 28px;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 8px;
    }
    
    .register-subtitle {
        font-size: 14px;
        color: #6b7280;
    }
</style>

<div class="register-container">
    <div class="register-form">
        <div class="register-header">
            <h1 class="register-title">Buat Akun</h1>
            <p class="register-subtitle">Daftar di Sistem Manajemen Pelanggaran</p>
        </div>

        @if (session('error'))
            <div class="alert alert-error mb-4">
                ❌ {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">👤 Nama Lengkap</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-input"
                    value="{{ old('name') }}"
                    placeholder="John Doe"
                    required
                >
                @error('name')
                    <div class="form-error">✗ {{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">📧 Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-input"
                    value="{{ old('email') }}"
                    placeholder="your@email.com"
                    required
                >
                @error('email')
                    <div class="form-error">✗ {{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">🔐 Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-input"
                    placeholder="••••••••"
                    required
                >
                @error('password')
                    <div class="form-error">✗ {{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">🔐 Konfirmasi Password</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="form-input"
                    placeholder="••••••••"
                    required
                >
                @error('password_confirmation')
                    <div class="form-error">✗ {{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="submit-btn">
                🚀 Daftar
            </button>
        </form>

        <div class="register-footer">
            Sudah punya akun? 
            <a href="{{ route('login') }}">
                Login di sini →
            </a>
        </div>
    </div>
</div>
@endsection
