@extends('layouts.app')

@section('content')
<style>
    .form-container {
        max-width: 600px;
        animation: slideInUp 0.6s ease-out;
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
    
    .form-header {
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
    
    .form-title {
        font-size: 28px;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 8px;
    }
    
    .form-subtitle {
        font-size: 14px;
        color: #6b7280;
    }
    
    .form-card {
        background: white;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: 1px solid #e5e7eb;
        animation: fadeIn 0.5s ease-out 0.2s backwards;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .form-group {
        margin-bottom: 24px;
        animation: fadeInLeft 0.5s ease-out backwards;
    }
    
    .form-group:nth-child(1) { animation-delay: 0.3s; }
    .form-group:nth-child(2) { animation-delay: 0.4s; }
    .form-group:nth-child(3) { animation-delay: 0.5s; }
    .form-group:nth-child(4) { animation-delay: 0.6s; }
    .form-group:nth-child(5) { animation-delay: 0.7s; }
    
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
    
    .form-label span {
        color: #ef4444;
    }
    
    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #f9fafb;
    }
    
    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        background: white;
    }
    
    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }
    
    .form-help {
        font-size: 12px;
        color: #9ca3af;
        margin-top: 6px;
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
    
    .file-input-wrapper {
        position: relative;
    }
    
    .file-input-wrapper input[type="file"] {
        display: none;
    }
    
    .file-input-label {
        display: inline-block;
        padding: 12px 16px;
        background: #f9fafb;
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        text-align: center;
        font-size: 14px;
        color: #6b7280;
    }
    
    .file-input-label:hover {
        border-color: #667eea;
        background: #f0f4ff;
        color: #667eea;
    }
    
    .current-file {
        font-size: 13px;
        color: #6b7280;
        margin-top: 8px;
        padding: 8px 12px;
        background: #f3f4f6;
        border-radius: 6px;
    }
    
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
    }
    
    .btn {
        flex: 1;
        padding: 12px 16px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        animation: fadeIn 0.5s ease-out 1s backwards;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }
    
    .btn-cancel {
        background-color: #e5e7eb;
        color: #374151;
        animation: fadeIn 0.5s ease-out 1.1s backwards;
    }
    
    .btn-cancel:hover {
        background-color: #d1d5db;
        transform: translateY(-2px);
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h1 class="form-title">{{ isset($pelanggaran) ? '✏️ Edit Pelanggaran' : '📝 Lapor Pelanggaran' }}</h1>
        <p class="form-subtitle">{{ isset($pelanggaran) ? 'Perbarui data pelanggaran existing' : 'Masukkan laporan pelanggaran baru ke sistem' }}</p>
    </div>

    <div class="form-card">
        <form action="{{ isset($pelanggaran) ? route('pelanggaran.update.web', $pelanggaran->id) : route('pelanggaran.store.web') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($pelanggaran))
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="karyawan_id" class="form-label">
                    👤 Karyawan <span>*</span>
                </label>
                <select id="karyawan_id" name="karyawan_id" class="form-select" required>
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach($karyawans as $karyawan)
                        <option value="{{ $karyawan->id }}" {{ old('karyawan_id', $pelanggaran->karyawan_id ?? '') == $karyawan->id ? 'selected' : '' }}>
                            {{ $karyawan->nama_karyawan }} ({{ $karyawan->departemen->nama_departemen }})
                        </option>
                    @endforeach
                </select>
                <div class="form-help">Pilih karyawan yang melakukan pelanggaran</div>
                @error('karyawan_id')
                    <div class="form-error">✗ {{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="jenis_pelanggaran_id" class="form-label">
                    ⚠️ Jenis Pelanggaran <span>*</span>
                </label>
                <select id="jenis_pelanggaran_id" name="jenis_pelanggaran_id" class="form-select" required>
                    <option value="">-- Pilih Jenis Pelanggaran --</option>
                    @foreach($jenisPelanggaran as $jenis)
                        <option value="{{ $jenis->id }}" {{ old('jenis_pelanggaran_id', $pelanggaran->jenis_pelanggaran_id ?? '') == $jenis->id ? 'selected' : '' }}>
                            {{ $jenis->nama_pelanggaran }} ({{ ucfirst($jenis->tingkat_pelanggaran) }})
                        </option>
                    @endforeach
                </select>
                <div class="form-help">Pilih jenis pelanggaran yang sesuai</div>
                @error('jenis_pelanggaran_id')
                    <div class="form-error">✗ {{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tanggal_pelanggaran" class="form-label">
                    📅 Tanggal Pelanggaran <span>*</span>
                </label>
                <input 
                    type="date" 
                    id="tanggal_pelanggaran" 
                    name="tanggal_pelanggaran" 
                    class="form-input"
                    value="{{ old('tanggal_pelanggaran', $pelanggaran->tanggal_pelanggaran ?? '') }}"
                    required
                >
                <div class="form-help">Tanggal kejadian pelanggaran</div>
                @error('tanggal_pelanggaran')
                    <div class="form-error">✗ {{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="keterangan_pelanggaran" class="form-label">
                    📝 Keterangan Pelanggaran <span>*</span>
                </label>
                <textarea 
                    id="keterangan_pelanggaran" 
                    name="keterangan_pelanggaran" 
                    class="form-textarea"
                    placeholder="Jelaskan detail pelanggaran yang terjadi..."
                    required
                >{{ old('keterangan_pelanggaran', $pelanggaran->keterangan_pelanggaran ?? '') }}</textarea>
                <div class="form-help">Berikan penjelasan detail tentang pelanggaran</div>
                @error('keterangan_pelanggaran')
                    <div class="form-error">✗ {{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="bukti_pelanggaran" class="form-label">
                    📷 Bukti Pelanggaran
                </label>
                <div class="file-input-wrapper">
                    <input 
                        type="file" 
                        id="bukti_pelanggaran" 
                        name="bukti_pelanggaran" 
                        accept="image/*"
                    >
                    <label for="bukti_pelanggaran" class="file-input-label">
                        📁 Klik untuk memilih bukti atau drag & drop
                    </label>
                </div>
                @if(isset($pelanggaran) && $pelanggaran->bukti_pelanggaran)
                    <div class="current-file">
                        ✓ File saat ini: {{ basename($pelanggaran->bukti_pelanggaran) }}
                    </div>
                @endif
                <div class="form-help">Format: JPG, PNG, GIF | Ukuran maksimal: 2MB</div>
                @error('bukti_pelanggaran')
                    <div class="form-error">✗ {{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-submit">
                    🚀 {{ isset($pelanggaran) ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('pelanggaran.index.web') }}" class="btn btn-cancel">
                    ❌ Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Drag and drop for file input
    const fileInput = document.getElementById('bukti_pelanggaran');
    const fileLabel = document.querySelector('.file-input-label');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        fileLabel.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        fileLabel.addEventListener(eventName, () => {
            fileLabel.style.borderColor = '#667eea';
            fileLabel.style.background = '#f0f4ff';
        });
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        fileLabel.addEventListener(eventName, () => {
            fileLabel.style.borderColor = '#d1d5db';
            fileLabel.style.background = '#f9fafb';
        });
    });
    
    fileLabel.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
    });
</script>
@endsection
