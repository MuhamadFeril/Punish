@extends('layouts.app')

@section('content')
<div class="landing-hero">
    <div class="hero-content">
        <h1 class="hero-title">🎯 Sistem Manajemen Sanksi Karyawan</h1>
        <p class="hero-subtitle">Kelola pelanggaran dan sanksi karyawan dengan mudah dan transparan</p>
        
        <div class="hero-features">
            <div class="feature-item">
                <div class="feature-icon">📋</div>
                <div class="feature-text">
                    <h3>Manajemen Pelanggaran</h3>
                    <p>Catat dan kelola semua pelanggaran karyawan secara terpusat</p>
                </div>
            </div>
            
            <div class="feature-item">
                <div class="feature-icon">⚖️</div>
                <div class="feature-text">
                    <h3>Sistem Sanksi</h3>
                    <p>Berikan sanksi yang adil dan terukur untuk setiap pelanggaran</p>
                </div>
            </div>
            
            <div class="feature-item">
                <div class="feature-icon">👥</div>
                <div class="feature-text">
                    <h3>Data Karyawan</h3>
                    <p>Kelola profil dan histori karyawan dengan lengkap</p>
                </div>
            </div>
            
            <div class="feature-item">
                <div class="feature-icon">📊</div>
                <div class="feature-text">
                    <h3>Dashboard Analitik</h3>
                    <p>Pantau statistik pelanggaran dan sanksi secara real-time</p>
                </div>
            </div>
        </div>
        
        @auth
            <div class="hero-actions">
                <a href="{{ route('dashboard') }}" class="btn-primary">
                    ➜ Ke Dashboard
                </a>
            </div>
        @else
            <div class="hero-actions">
                <a href="{{ route('login') }}" class="btn-primary">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="btn-secondary">
                    Daftar
                </a>
            </div>
        @endauth
    </div>
</div>

<style>
    .landing-hero {
        max-width: 900px;
        margin: 60px auto;
        padding: 40px 28px;
    }

    .hero-content {
        text-align: center;
    }

    .hero-title {
        font-size: 48px;
        font-weight: 800;
        background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 16px;
        line-height: 1.2;
    }

    .hero-subtitle {
        font-size: 18px;
        color: #6b7280;
        margin-bottom: 48px;
        line-height: 1.6;
    }

    .hero-features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 48px;
    }

    .feature-item {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06);
        text-align: left;
        transition: all 0.3s ease;
    }

    .feature-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(15, 23, 42, 0.12);
    }

    .feature-icon {
        font-size: 32px;
        margin-bottom: 12px;
    }

    .feature-item h3 {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .feature-item p {
        font-size: 14px;
        color: #6b7280;
        line-height: 1.5;
    }

    .hero-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-primary,
    .btn-secondary {
        padding: 14px 32px;
        border-radius: 12px;
        border: none;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
        color: #ffffff;
        font-size: 15px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #1f2937;
        border: 1px solid #e5e7eb;
        font-size: 15px;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
        transform: translateY(-2px);
    }

    @media (max-width: 640px) {
        .landing-hero {
            margin: 40px auto;
            padding: 24px 16px;
        }

        .hero-title {
            font-size: 32px;
        }

        .hero-subtitle {
            font-size: 16px;
            margin-bottom: 32px;
        }

        .hero-features {
            grid-template-columns: 1fr;
            gap: 16px;
            margin-bottom: 32px;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection
