@extends('layouts.app')

@section('content')
<style>
    .form-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 24px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 16px rgba(15, 23, 42, 0.08);
        animation: fadeIn 0.45s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-header {
        margin-bottom: 28px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e5e7eb;
    }

    .form-title {
        font-size: 28px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .form-subtitle {
        color: #6b7280;
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #374151;
        font-size: 14px;
    }

    .form-input {
        width: 100%;
        padding: 14px 16px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        background: #f9fafb;
        font-size: 14px;
        color: #111827;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        font-family: inherit;
    }

    .form-input:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
        background: white;
    }

    .form-error {
        margin-top: 6px;
        color: #dc2626;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
        color: white;
        flex: 1;
        min-width: 150px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.2);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #1f2937;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }

    .form-divider {
        height: 1px;
        background: #e5e7eb;
        margin: 24px 0;
    }

    .help-text {
        font-size: 12px;
        color: #6b7280;
        margin-top: 4px;
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h1 class="form-title">✏️ Edit Profil</h1>
        <p class="form-subtitle">Perbarui informasi akun Anda</p>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name" class="form-label">👤 Nama Lengkap *</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                class="form-input @error('name') border-red-500 @enderror" 
                value="{{ old('name', $user->name) }}"
                required
            >
            @error('name')
                <div class="form-error">❌ {{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="photo" class="form-label">📸 Foto Profil</label>
            @if($user->photo)
                <div style="margin-bottom: 12px;">
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" style="width: 100px; height: 100px; border-radius: 10px; object-fit: cover;">
                </div>
            @endif
            <input 
                type="file" 
                id="photo" 
                name="photo" 
                class="form-input @error('photo') border-red-500 @enderror"
                accept="image/*"
            >
            @error('photo')
                <div class="form-error">❌ {{ $message }}</div>
            @enderror
            <p class="help-text">Format: JPEG, PNG, JPG, GIF | Ukuran maksimal: 2MB</p>
        </div>

        <div class="form-group">
            <label for="email" class="form-label">📧 Email *</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                class="form-input @error('email') border-red-500 @enderror" 
                value="{{ old('email', $user->email) }}"
                required
            >
            @error('email')
                <div class="form-error">❌ {{ $message }}</div>
            @enderror
            <p class="help-text">Gunakan email yang valid dan belum terdaftar oleh pengguna lain</p>
        </div>

        <div class="form-divider"></div>

        <div class="form-group">
            <label class="form-label">🏢 Role</label>
            <div class="form-input" style="background: #f3f4f6; color: #6b7280; cursor: not-allowed;">
                {{ ucfirst($user->role) }}
            </div>
            <p class="help-text">Role Anda tidak dapat diubah. Hubungi administrator jika ada pertanyaan</p>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                ✅ Simpan Perubahan
            </button>
            <a href="{{ route('profile.show') }}" class="btn btn-secondary">
                ⬅️ Batal
            </a>
        </div>
    </form>
</div>
@endsection
