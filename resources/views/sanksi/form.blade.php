@extends('layouts.app')

@section('content')
<style>
    .form-container {
        max-width: 700px;
        margin: 0 auto;
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
        margin-bottom: 24px;
    }

    .form-title {
        font-size: 30px;
        font-weight: 800;
        color: #1f2937;
    }

    .form-subtitle {
        color: #6b7280;
        margin-top: 8px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #374151;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 14px 16px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        background: #f9fafb;
        font-size: 14px;
        color: #111827;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
        background: white;
    }

    .form-textarea {
        min-height: 140px;
        resize: vertical;
    }

    .form-error {
        margin-top: 8px;
        color: #dc2626;
        font-size: 13px;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 16px;
    }

    .btn-primary,
    .btn-secondary {
        padding: 12px 18px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.18);
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #1f2937;
    }

    .btn-secondary:hover {
        background: #d1d5db;
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h1 class="form-title">{{ isset($sanksi) ? '✏️ Edit Sanksi' : '📝 Tambah Sanksi Baru' }}</h1>
        <p class="form-subtitle">{{ isset($sanksi) ? 'Perbarui detail sanksi karyawan' : 'Tambahkan sanksi untuk pelanggaran yang sudah dilaporkan' }}</p>
    </div>

    <form action="{{ isset($sanksi) ? route('sanksi.update.admin', $sanksi->id) : route('sanksi.store.admin') }}" method="POST">
        @csrf
        @if(isset($sanksi))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="pelanggaran_id" class="form-label">Pelanggaran *</label>
            <select id="pelanggaran_id" name="pelanggaran_id" class="form-select" required>
                <option value="">Pilih pelanggaran</option>
                @foreach($pelanggarans as $pelanggaran)
                    <option value="{{ $pelanggaran->id }}" {{ old('pelanggaran_id', $sanksi->pelanggaran_id ?? '') == $pelanggaran->id ? 'selected' : '' }}>
                        {{ $pelanggaran->karyawan->nama_karyawan }} - {{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }} ({{ \Carbon\Carbon::parse($pelanggaran->tanggal_pelanggaran)->format('d-m-Y') }})
                    </option>
                @endforeach
            </select>
            @error('pelanggaran_id')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="jenis_sanksi" class="form-label">Jenis Sanksi *</label>
            <select id="jenis_sanksi" name="jenis_sanksi" class="form-select" required>
                <option value="">Pilih jenis sanksi</option>
                <option value="peringatan" {{ old('jenis_sanksi', $sanksi->jenis_sanksi ?? '') === 'peringatan' ? 'selected' : '' }}>Peringatan</option>
                <option value="SP1" {{ old('jenis_sanksi', $sanksi->jenis_sanksi ?? '') === 'SP1' ? 'selected' : '' }}>SP1</option>
                <option value="SP2" {{ old('jenis_sanksi', $sanksi->jenis_sanksi ?? '') === 'SP2' ? 'selected' : '' }}>SP2</option>
                <option value="denda" {{ old('jenis_sanksi', $sanksi->jenis_sanksi ?? '') === 'denda' ? 'selected' : '' }}>Denda</option>
                <option value="skorsing" {{ old('jenis_sanksi', $sanksi->jenis_sanksi ?? '') === 'skorsing' ? 'selected' : '' }}>Skorsing</option>
                <option value="pemecatan" {{ old('jenis_sanksi', $sanksi->jenis_sanksi ?? '') === 'pemecatan' ? 'selected' : '' }}>Pemecatan</option>
            </select>
            @error('jenis_sanksi')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="tanggal_sanksi" class="form-label">Tanggal Sanksi *</label>
            <input id="tanggal_sanksi" name="tanggal_sanksi" type="date" class="form-input" value="{{ old('tanggal_sanksi', $sanksi->tanggal_sanksi ?? '') }}" required>
            @error('tanggal_sanksi')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="status" class="form-label">Status *</label>
            <select id="status" name="status" class="form-select" required>
                <option value="">Pilih status</option>
                <option value="aktif" {{ old('status', $sanksi->status ?? '') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="selesai" {{ old('status', $sanksi->status ?? '') === 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
            @error('status')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="keterangan_sanksi" class="form-label">Keterangan Sanksi</label>
            <textarea id="keterangan_sanksi" name="keterangan_sanksi" class="form-textarea">{{ old('keterangan_sanksi', $sanksi->keterangan_sanksi ?? '') }}</textarea>
            @error('keterangan_sanksi')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">{{ isset($sanksi) ? 'Update Sanksi' : 'Simpan Sanksi' }}</button>
            <a href="{{ route('sanksi.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection