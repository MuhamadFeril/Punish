@extends('layouts.app')

@section('content')
<style>
    .detail-container {
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        color: #1f2937;
        padding: 20px 0;
    }
    .premium-header {
        background: #ffffff;
        padding: 24px;
        border-radius: 16px;
        border: 1px solid #f3f4f6;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }
    .header-title h1 {
        font-size: 28px;
        font-weight: 800;
        color: #111827;
        margin: 4px 0;
    }
    .header-badge {
        font-size: 12px;
        font-weight: 700;
        color: #4f46e5;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .header-actions {
        display: flex;
        gap: 12px;
    }
    .btn-edit-data {
        background: #4f46e5;
        color: white !important;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-edit-data:hover {
        background: #4338ca;
        transform: translateY(-1px);
    }
    .btn-back {
        background: #f3f4f6;
        color: #4b5563 !important;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-back:hover {
        background: #e5e7eb;
    }
    .detail-grid {
        display: grid;
        grid-template-cols: 1fr;
        gap: 24px;
    }
    @media (min-width: 992px) {
        .detail-grid {
            grid-template-cols: 1fr 2fr;
        }
    }
    .premium-card {
        background: #ffffff;
        padding: 24px;
        border-radius: 16px;
        border: 1px solid #f3f4f6;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }
    .card-title {
        font-size: 18px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .info-grid {
        display: grid;
        grid-template-cols: 1fr;
        gap: 16px;
    }
    @media (min-width: 576px) {
        .info-grid {
            grid-template-cols: 1fr 1fr;
        }
    }
    .info-item {
        background: #f9fafb;
        padding: 16px;
        border-radius: 12px;
        border: 1px solid #f3f4f6;
    }
    .info-label {
        font-size: 11px;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .info-value {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
        margin-top: 4px;
    }
    .info-value a {
        color: #4f46e5;
        text-decoration: none;
    }
    .info-value a:hover {
        text-decoration: underline;
    }
    .badge-fatalitas {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 700;
        text-transform: capitalize;
        margin-top: 4px;
    }
    .badge-ringan { background-color: #fef08a; color: #854d0e; border: 1px solid #fef08a; }
    .badge-sedang { background-color: #ffedd5; color: #9a3412; border: 1px solid #ffedd5; }
    .badge-berat { background-color: #fee2e2; color: #991b1b; border: 1px solid #fee2e2; }
    
    .cronology-box {
        background: #f9fafb;
        padding: 16px;
        border-radius: 12px;
        border: 1px solid #f3f4f6;
        color: #4b5563;
        line-height: 1.6;
        font-size: 14px;
        white-space: pre-line;
    }
    .image-wrapper {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        background: #f9fafb;
        text-align: center;
    }
    .image-wrapper img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
    }
    .sanksi-container {
        border-left: 4px solid #ef4444;
        background: #fef2f2;
        padding: 16px;
        border-radius: 12px;
        margin-top: 12px;
    }
</style>

<div class="detail-container">
    <div class="premium-header">
        <div class="header-title">
            <span class="header-badge">Detail Laporan Administrasi</span>
            <h1>Detail Pelanggaran</h1>
            <div style="color: #6b7280; font-size: 14px; display: flex; align-items: center; gap: 6px; margin-top: 4px;">
                📂 Kategori: <strong>{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }}</strong>
            </div>
        </div>
        <div class="header-actions">
            @if(auth()->user()->role !== 'user')
                <a href="{{ route('pelanggaran.edit.web', $pelanggaran->id) }}" class="btn-edit-data">
                    ✏️ Edit Laporan
                </a>
            @endif
            <a href="{{ route('pelanggaran.index.web') }}" class="btn-back">
                ⬅️ Kembali
            </a>
        </div>
    </div>

    <div class="detail-grid">
        <div>
            <div class="premium-card">
                <div class="card-title">📸 Bukti Pelanggaran</div>
                <div class="image-wrapper">
                    @if($pelanggaran->bukti_pelanggaran)
                        <img src="{{ route('display.image', ['path' => $pelanggaran->bukti_pelanggaran]) }}" alt="Bukti Kasus">
                    @else
                        <div style="padding: 40px 20px; color: #9ca3af; text-align: center;">
                            <span style="font-size: 48px; display: block; margin-bottom: 8px;">🖼️</span>
                            <span style="font-size: 13px; font-weight: 500;">Tidak ada berkas gambar yang dilampirkan</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div>
            <div class="premium-card">
                <div class="card-title">ℹ️ Data Konfirmasi Pelanggaran</div>
                
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Nama Karyawan</div>
                        <div class="info-value">
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('karyawan.show.web', $pelanggaran->karyawan->id) }}">
                                    👤 {{ $pelanggaran->karyawan->nama_karyawan }}
                                </a>
                            @else
                                👤 {{ $pelanggaran->karyawan->nama_karyawan }}
                            @endif
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Departemen / Divisi</div>
                        <div class="info-value">🏢 {{ $pelanggaran->karyawan->departemen->nama_departemen }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Jenis Pelanggaran</div>
                        <div class="info-value">⚠️ {{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Tingkat Klasifikasi</div>
                        <div>
                            @if($pelanggaran->jenisPelanggaran->tingkat_pelanggaran === 'ringan')
                                <span class="badge-fatalitas" style="background: #fef08a; color: #854d0e; border: 1px solid #eab308;">🎯 Ringan</span>
                            @elseif($pelanggaran->jenisPelanggaran->tingkat_pelanggaran === 'sedang')
                                <span class="badge-fatalitas" style="background: #ffedd5; color: #9a3412; border: 1px solid #f97316;">🎯 Sedang</span>
                            @else
                                <span class="badge-fatalitas" style="background: #fee2e2; color: #991b1b; border: 1px solid #ef4444;">🎯 Berat</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-item" style="grid-column: span 1;">
                        <div class="info-label">Tanggal Terdata</div>
                        <div class="info-value">📅 {{ \Carbon\Carbon::parse($pelanggaran->tanggal_pelanggaran)->format('d F Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="premium-card">
                <div class="card-title">📝 Deskripsi Kronologi Kejadian</div>
                <div class="cronology-box">
                    {{ $pelanggaran->keterangan_pelanggaran }}
                </div>
            </div>

            <div class="premium-card" style="border: 1px solid #e5e7eb;">
                <div class="card-title">🛑 Status Eksekusi Tindakan / Sanksi</div>
                
                @if($pelanggaran->sanksi && $pelanggaran->sanksi->count() > 0)
                    @foreach($pelanggaran->sanksi as $sanksi)
                        <div class="sanksi-container" style="border-left: 4px solid {{ $sanksi->status === 'aktif' ? '#ef4444' : '#10b981' }}; background: {{ $sanksi->status === 'aktif' ? '#fef2f2' : '#f0fdf4' }};">
                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <div style="font-size: 15px; font-weight: 700; color: #111827;">
                                    📌 Sanksi: {{ ucfirst($sanksi->jenis_sanksi) }}
                                </div>
                                <span style="padding: 2px 10px; border-radius: 9999px; font-size: 11px; font-weight: 700; background: {{ $sanksi->status === 'aktif' ? '#fee2e2' : '#dcfce7' }}; color: {{ $sanksi->status === 'aktif' ? '#991b1b' : '#166534' }};">
                                    {{ strtoupper($sanksi->status) }}
                                </span>
                            </div>
                            <div style="font-size: 13px; color: #6b7280; margin-bottom: 6px;">
                                📆 Tanggal Jatuh Sanksi: <strong>{{ \Carbon\Carbon::parse($sanksi->tanggal_sanksi)->format('d-m-Y') }}</strong>
                            </div>
                            <div style="font-size: 13px; color: #374151; background: rgba(255,255,255,0.6); padding: 10px; border-radius: 8px; margin-top: 8px;">
                                <strong>Catatan Internal:</strong> {{ $sanksi->keterangan_sanksi }}
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="background: #fffbeb; border: 1px solid #fde68a; padding: 16px; border-radius: 12px; display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 24px;">⚠️</span>
                        <div>
                            <div style="font-weight: 700; color: #92400e; font-size: 14px;">Sanksi Belum Diterbitkan</div>
                            <p style="color: #b45309; font-size: 12px; margin-top: 2px; margin-bottom: 0;">Belum ada tindakan disipliner atau sanksi resmi yang dikeluarkan untuk pelanggaran ini.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection