@extends('layouts.app')

@section('content')
<style>
    .page-header {
        margin-bottom: 32px;
        animation: slideInDown 0.5s ease-out;
    }
    
    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
    }
    
    .page-subtitle {
        color: #6b7280;
        font-size: 16px;
    }
    
    .form-card {
        background: white;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        animation: fadeIn 0.5s ease-out 0.2s backwards;
        max-width: 600px;
        margin: 0 auto;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .form-group {
        margin-bottom: 24px;
        animation: slideInUp 0.4s ease-out backwards;
    }
    
    .form-group:nth-child(1) { animation-delay: 0.3s; }
    .form-group:nth-child(2) { animation-delay: 0.4s; }
    
    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        font-size: 14px;
    }
    
    .form-label::after {
        content: ' *';
        color: #ef4444;
    }
    
    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
        background-color: #ffffff;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        transform: translateY(-1px);
    }
    
    .form-input:hover {
        border-color: #d1d5db;
    }
    
    .error-message {
        color: #ef4444;
        font-size: 14px;
        margin-top: 4px;
        animation: shake 0.4s ease;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 32px;
        animation: slideInUp 0.4s ease-out 0.5s backwards;
    }
    
    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        min-width: 120px;
        text-align: center;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }
    
    .btn-secondary {
        background-color: #f3f4f6;
        color: #374151;
        border: 2px solid #e5e7eb;
    }
    
    .btn-secondary:hover {
        background-color: #e5e7eb;
        border-color: #d1d5db;
        transform: translateY(-1px);
    }
</style>

<div class="page-header">
    <h1 class="page-title">{{ isset($departemen) ? '✏️ Edit Departemen' : '➕ Tambah Departemen' }}</h1>
    <p class="page-subtitle">{{ isset($departemen) ? 'Perbarui informasi departemen' : 'Masukkan data departemen baru' }}</p>
</div>

<div class="form-card">
    <form action="{{ isset($departemen) ? route('departemen.update.web', $departemen->id) : route('departemen.store.web') }}" method="POST" id="departemenForm">
        @csrf
        @if(isset($departemen))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="nama_departemen" class="form-label">Nama Departemen</label>
            <input 
                type="text" 
                id="nama_departemen" 
                name="nama_departemen" 
                class="form-input"
                value="{{ old('nama_departemen', $departemen->nama_departemen ?? '') }}"
                placeholder="Masukkan nama departemen"
                required
            >
            @error('nama_departemen')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('departemen.index.web') }}" class="btn btn-secondary">⬅️ Batal</a>
            <button type="submit" class="btn btn-primary">
                {{ isset($departemen) ? '💾 Simpan Perubahan' : '➕ Tambah Departemen' }}
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('departemenForm');
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;

        form.addEventListener('submit', function(e) {
            submitBtn.textContent = '⏳ Menyimpan...';
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.7';
        });

        // Auto-focus first input
        const firstInput = form.querySelector('input');
        if (firstInput) {
            firstInput.focus();
        }
    });
</script>
@endsection
