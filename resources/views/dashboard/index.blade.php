@extends('layouts.app')

@section('content')
<style>
    .dashboard-header {
        animation: slideInDown 0.5s ease-out;
        margin-bottom: 40px;
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
    
    .dashboard-title {
        font-size: 36px;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 8px;
    }
    
    .dashboard-subtitle {
        font-size: 15px;
        color: #6b7280;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }
    
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: 1px solid #e5e7eb;
        animation: cardFadeIn 0.5s ease-out backwards;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    @keyframes cardFadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }
    .stat-card:nth-child(5) { animation-delay: 0.5s; }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.12);
        border-color: #d1d5db;
    }
    
    .stat-card:hover::before {
        opacity: 1;
    }
    
    .stat-value {
        font-size: 32px;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 8px;
        animation: countUp 2s ease-out forwards;
    }
    
    @keyframes countUp {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    .stat-label {
        font-size: 14px;
        color: #6b7280;
        font-weight: 500;
    }
    
    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 2px solid #e5e7eb;
        animation: fadeIn 0.5s ease-out 0.6s backwards;
    }
    
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }
    
    .menu-btn {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        text-decoration: none;
        color: #1f2937;
        font-weight: 500;
        font-size: 14px;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        animation: fadeIn 0.5s ease-out backwards;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .menu-btn:nth-child(1) { animation-delay: 0.7s; }
    .menu-btn:nth-child(2) { animation-delay: 0.8s; }
    .menu-btn:nth-child(3) { animation-delay: 0.9s; }
    .menu-btn:nth-child(4) { animation-delay: 1s; }
    .menu-btn:nth-child(5) { animation-delay: 1.1s; }
    .menu-btn:nth-child(6) { animation-delay: 1.2s; }
    
    .menu-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: -1;
    }
    
    .menu-btn:hover {
        transform: translateY(-4px);
        border-color: #667eea;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.2);
        color: white;
    }
    
    .menu-icon {
        font-size: 24px;
    }
    
    .info-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: 1px solid #e5e7eb;
        animation: fadeIn 0.5s ease-out 1.3s backwards;
    }
    
    .info-card h3 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 16px;
        color: #1f2937;
    }
    
    .info-list {
        list-style: none;
        space-y: 8px;
    }
    
    .info-list li {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 8px;
        padding-left: 24px;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .info-list li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: #667eea;
        font-weight: bold;
    }
    
    .info-list li:hover {
        color: #1f2937;
        transform: translateX(4px);
    }
    
    .two-column {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    @media (max-width: 768px) {
        .two-column {
            grid-template-columns: 1fr;
        }
        
        .dashboard-title {
            font-size: 28px;
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
    }
</style>

<div class="dashboard-header">
    <h1 class="dashboard-title">🎯 Dashboard</h1>
    <p class="dashboard-subtitle">Selamat datang di Sistem Manajemen Pelanggaran Karyawan</p>
</div>

@auth
    <div class="stats-grid">
        @if($isAdmin)
            <div class="stat-card">
                <div class="stat-value">{{ $totalKaryawan ?? 0 }}</div>
                <div class="stat-label">👥 Total Karyawan</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $totalDepartemen ?? 0 }}</div>
                <div class="stat-label">🏢 Total Departemen</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $totalJenisPelanggaran ?? 0 }}</div>
                <div class="stat-label">⚠️ Jenis Pelanggaran</div>
            </div>
        @endif

        <div class="stat-card">
            <div class="stat-value">{{ $totalPelanggaran ?? 0 }}</div>
            <div class="stat-label">📋 {{ $isAdmin ? 'Total Pelanggaran' : 'Pelanggaran Saya' }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $totalSanksi ?? 0 }}</div>
            <div class="stat-label">⚖️ {{ $isAdmin ? 'Total Sanksi' : 'Sanksi Saya' }}</div>
        </div>
    </div>

    @if($isAdmin)
        <div class="two-column">
            <div class="info-card">
                <h3 class="section-title">📌 Menu Utama</h3>
                <div class="menu-grid">
                    <a href="{{ route('karyawan.index.web') }}" class="menu-btn">
                        <span class="menu-icon">👥</span>
                        Karyawan
                    </a>
                    <a href="{{ route('departemen.index.web') }}" class="menu-btn">
                        <span class="menu-icon">🏢</span>
                        Departemen
                    </a>
                    <a href="{{ route('jenis-pelanggaran.index.web') }}" class="menu-btn">
                        <span class="menu-icon">⚠️</span>
                        Jenis Pelanggaran
                    </a>
                    <a href="{{ route('pelanggaran.index.web') }}" class="menu-btn">
                        <span class="menu-icon">📋</span>
                        Pelanggaran
                    </a>
                    <a href="{{ route('sanksi.index.web') }}" class="menu-btn">
                        <span class="menu-icon">⚖️</span>
                        Sanksi
                    </a>
                </div>
            </div>

            <div class="info-card">
                <h3 class="section-title">ℹ️ Informasi Sistem</h3>
                <ul class="info-list">
                    <li><strong>Versi:</strong> 1.0.0</li>
                    <li><strong>Sistem:</strong> Manajemen Pelanggaran Karyawan</li>
                    <li>Manajemen Data Karyawan</li>
                    <li>Manajemen Departemen</li>
                    <li>Pencatatan Pelanggaran</li>
                    <li>Pengelolaan Sanksi</li>
                    <li>Sistem Keamanan Berbasis Role</li>
                    <li>Laporan & Statistik</li>
                </ul>
            </div>
        </div>
    @else
        <div class="two-column">
            <div class="info-card">
                <h3 class="section-title">📌 Menu Utama</h3>
                <div class="menu-grid">
                    <a href="{{ route('pelanggaran.index.web') }}" class="menu-btn">
                        <span class="menu-icon">📋</span>
                        Pelanggaran
                    </a>
                    <a href="{{ route('sanksi.index.web') }}" class="menu-btn">
                        <span class="menu-icon">⚖️</span>
                        Sanksi
                    </a>
                </div>
            </div>

            <div class="info-card">
                <h3 class="section-title">🔔 Notifikasi Anda</h3>
                @if($notifications->isEmpty())
                    <p>Tidak ada notifikasi baru.</p>
                @else
                    <ul class="info-list">
                        @foreach($notifications as $notification)
                            <li>
                                <a href="{{ $notification->data['link'] ?? '#' }}" style="color: inherit; text-decoration: none;">
                                    {{ $notification->data['title'] ?? 'Notifikasi' }} - {{ $notification->data['message'] ?? '' }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <p style="margin-top: 16px; color: #6b7280;">
                    {{ $unreadNotificationCount ?? 0 }} notifikasi belum dibaca.
                </p>
            </div>
        </div>

        <div class="info-card">
            <h3 class="section-title">📄 Pelanggaran Terbaru</h3>
            @if($recentPelanggaran->isEmpty())
                <p>Tidak ada pelanggaran yang ditemukan untuk akun Anda.</p>
            @else
                <ul class="info-list">
                    @foreach($recentPelanggaran as $item)
                        <li>
                            {{ $item->jenisPelanggaran->nama_jenis_pelanggaran ?? 'Pelanggaran' }} pada {{ date('d M Y', strtotime($item->tanggal_pelanggaran)) }}
                            @if($item->sanksi->count() > 0)
                                - Sanksi: {{ $item->sanksi->first()->jenis_sanksi }}
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif
@else
    <div class="info-card" style="text-align: center; padding: 40px;">
        <p style="font-size: 16px; color: #6b7280; margin-bottom: 20px;">
            Silakan login untuk mengakses dashboard dan menu utama sistem
        </p>
        <a href="{{ route('login') }}" class="btn btn-primary">
            🚀 Login Sekarang
        </a>
    </div>
@endauth
@endsection
