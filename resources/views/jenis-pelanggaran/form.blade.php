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
        max-width: 800px;
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
    .form-group:nth-child(3) { animation-delay: 0.5s; }
    
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
    
    .form-input, .form-textarea, .form-select {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
        background-color: #ffffff;
    }
    
    .form-textarea {
        resize: vertical;
        min-height: 120px;
    }
    
    .form-select {
        cursor: pointer;
    }
    
    .form-input:focus, .form-textarea:focus, .form-select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        transform: translateY(-1px);
    }
    
    .form-input:hover, .form-textarea:hover, .form-select:hover {
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
    
    .severity-preview {
        display: inline-block;
        margin-top: 8px;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    
    .severity-ringan {
        background-color: #fef3c7;
        color: #b45309;
    }
    
    .severity-sedang {
        background-color: #fed7aa;
        color: #c2410c;
    }
    
    .severity-berat {
        background-color: #fecaca;
        color: #dc2626;
    }
    
    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 32px;
        animation: slideInUp 0.4s ease-out 0.6s backwards;
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
    <h1 class="page-title">{{ isset($jenisPelanggaran) ? '✏️ Edit Jenis Pelanggaran' : '➕ Tambah Jenis Pelanggaran' }}</h1>
    <p class="page-subtitle">{{ isset($jenisPelanggaran) ? 'Perbarui informasi jenis pelanggaran' : 'Masukkan data jenis pelanggaran baru' }}</p>
</div>

<div class="form-card">
    <form action="{{ isset($jenisPelanggaran) ? route('jenis-pelanggaran.update.web', $jenisPelanggaran->id) : route('jenis-pelanggaran.store.web') }}" method="POST" id="jenisPelanggaranForm">
        @csrf
        @if(isset($jenisPelanggaran))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="nama_pelanggaran" class="form-label">Nama Pelanggaran</label>
            <input 
                type="text" 
                id="nama_pelanggaran" 
                name="nama_pelanggaran" 
                class="form-input"
                value="{{ old('nama_pelanggaran', $jenisPelanggaran->nama_pelanggaran ?? '') }}"
                placeholder="Masukkan nama pelanggaran"
                required
            >
            @error('nama_pelanggaran')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="deskripsi_pelanggaran" class="form-label">Deskripsi Pelanggaran</label>
            <textarea 
                id="deskripsi_pelanggaran" 
                name="deskripsi_pelanggaran" 
                class="form-textarea"
                placeholder="Jelaskan detail pelanggaran ini"
                required
            >{{ old('deskripsi_pelanggaran', $jenisPelanggaran->deskripsi_pelanggaran ?? '') }}</textarea>
            @error('deskripsi_pelanggaran')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="tingkat_pelanggaran" class="form-label">Tingkat Pelanggaran</label>
            <select id="tingkat_pelanggaran" name="tingkat_pelanggaran" class="form-select" required>
                <option value="">-- Pilih Tingkat Pelanggaran --</option>
                <option value="ringan" {{ old('tingkat_pelanggaran', $jenisPelanggaran->tingkat_pelanggaran ?? '') === 'ringan' ? 'selected' : '' }}>🟡 Ringan</option>
                <option value="sedang" {{ old('tingkat_pelanggaran', $jenisPelanggaran->tingkat_pelanggaran ?? '') === 'sedang' ? 'selected' : '' }}>🟠 Sedang</option>
                <option value="berat" {{ old('tingkat_pelanggaran', $jenisPelanggaran->tingkat_pelanggaran ?? '') === 'berat' ? 'selected' : '' }}>🔴 Berat</option>
            </select>
            @error('tingkat_pelanggaran')
                <div class="error-message">{{ $message }}</div>
            @enderror
            
            <div id="severityPreview" class="severity-preview" style="display: none;"></div>
        </div>

        <div class="form-actions">
            <a href="{{ route('jenis-pelanggaran.index.web') }}" class="btn btn-secondary">⬅️ Batal</a>
            <button type="submit" class="btn btn-primary">
                {{ isset($jenisPelanggaran) ? '💾 Simpan Perubahan' : '➕ Tambah Jenis Pelanggaran' }}
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('jenisPelanggaranForm');
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        const select = document.getElementById('tingkat_pelanggaran');
        const preview = document.getElementById('severityPreview');

        // Severity preview
        select.addEventListener('change', function() {
            if (this.value) {
                preview.className = `severity-preview severity-${this.value}`;
                preview.textContent = `${this.value === 'ringan' ? '🟡' : (this.value === 'sedang' ? '🟠' : '🔴')} ${this.value.charAt(0).toUpperCase() + this.value.slice(1)}`;
                preview.style.display = 'inline-block';
            } else {
                preview.style.display = 'none';
            }
        });

        // Trigger initial preview if value exists
        if (select.value) {
            select.dispatchEvent(new Event('change'));
        }

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
