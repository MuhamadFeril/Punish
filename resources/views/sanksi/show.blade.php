@extends('layouts.app')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .page-subtitle {
        font-size: 16px;
        color: #6b7280;
        margin-top: 4px;
    }
    
    .back-btn {
        background-color: #e5e7eb;
        color: #374151;
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .back-btn:hover {
        background-color: #d1d5db;
        transform: translateY(-2px);
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 24px;
    }
    
    .info-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: 1px solid #e5e7eb;
        animation: fadeIn 0.5s ease-out backwards;
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
    
    .info-card:nth-child(1) { animation-delay: 0.2s; }
    .info-card:nth-child(2) { animation-delay: 0.4s; }
    
    .card-title {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #e5e7eb;
    }
    
    .info-item {
        margin-bottom: 16px;
        animation: fadeInLeft 0.5s ease-out backwards;
    }
    
    .info-item:nth-child(1) { animation-delay: 0.6s; }
    .info-item:nth-child(2) { animation-delay: 0.7s; }
    .info-item:nth-child(3) { animation-delay: 0.8s; }
    .info-item:nth-child(4) { animation-delay: 0.9s; }
    .info-item:nth-child(5) { animation-delay: 1s; }
    
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
    
    .info-label {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .info-value {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
    }
    
    .info-link {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .info-link:hover {
        color: #5a67d8;
        text-decoration: underline;
    }
    
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
    }
    
    .status-aktif {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .status-selesai {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .action-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        display: inline-block;
        transition: all 0.3s ease;
        margin-top: 16px;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }
    
    .description-text {
        color: #4b5563;
        line-height: 1.6;
        font-size: 14px;
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">⚖️ Detail Sanksi</h1>
        <p class="page-subtitle">{{ ucfirst($sanksi->jenis_sanksi) }}</p>
    </div>
    <div style="display:flex;gap:12px;align-items:center;">
        <a href="{{ route('sanksi.index') }}" class="back-btn">⬅️ Kembali</a>
        <a href="{{ route('sanksi.download', $sanksi->id) }}" class="action-btn" style="background:#2563eb;">📥 Download PDF</a>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('sanksi.edit', $sanksi->id) }}" class="action-btn" style="background:#f59e0b;">✏️ Edit Sanksi</a>
        @endif
    </div>
</div>

<div class="info-grid">
    <div class="info-card">
        <h2 class="card-title">⚖️ Informasi Sanksi</h2>
        <div class="info-item">
            <div class="info-label">Jenis Sanksi</div>
            <div class="info-value">{{ ucfirst($sanksi->jenis_sanksi) }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Tanggal Sanksi</div>
            <div class="info-value">{{ \Carbon\Carbon::parse($sanksi->tanggal_sanksi)->format('d-m-Y') }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Status</div>
            <div class="info-value">
                <span class="status-badge {{ $sanksi->status === 'aktif' ? 'status-aktif' : 'status-selesai' }}">
                    {{ $sanksi->status === 'aktif' ? '⏳ Aktif' : '✅ Selesai' }}
                </span>
            </div>
        </div>
        <div class="info-item">
            <div class="info-label">Keterangan</div>
            <div class="info-value description-text">{{ $sanksi->keterangan_sanksi }}</div>
        </div>
    </div>

    <div class="info-card">
        <h2 class="card-title">⚠️ Informasi Pelanggaran</h2>
        <div class="info-item">
            <div class="info-label">Karyawan</div>
            <div class="info-value">
                <a href="{{ route('karyawan.show', $sanksi->pelanggaran->karyawan->id) }}" class="info-link">
                    {{ $sanksi->pelanggaran->karyawan->nama_karyawan }}
                </a>
            </div>
        </div>
        <div class="info-item">
            <div class="info-label">Departemen</div>
            <div class="info-value">{{ $sanksi->pelanggaran->karyawan->departemen->nama_departemen }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Jenis Pelanggaran</div>
            <div class="info-value">{{ $sanksi->pelanggaran->jenisPelanggaran->nama_pelanggaran }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Tanggal Pelanggaran</div>
            <div class="info-value">{{ \Carbon\Carbon::parse($sanksi->pelanggaran->tanggal_pelanggaran)->format('d-m-Y') }}</div>
        </div>
        <div class="info-item">
            <a href="{{ route('pelanggaran.show', $sanksi->pelanggaran->id) }}" class="action-btn">
                📄 Lihat Laporan Pelanggaran Lengkap
            </a>
        </div>
    </div>
</div>
@endsection
