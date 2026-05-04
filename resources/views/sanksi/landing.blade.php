@extends('layouts.app')

@section('content')
    <div class="hero-card" style="background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); color: #ffffff; border-radius: 24px; padding: 48px 32px; box-shadow: 0 28px 60px rgba(99, 102, 241, 0.18);">
        <div style="max-width: 860px; margin: 0 auto;">
            <p style="font-size: 14px; text-transform: uppercase; letter-spacing: 0.18em; color: rgba(255,255,255,0.85); margin-bottom: 16px;">Sistem pelanggaran karyawan</p>
            <h1 style="font-size: clamp(2.25rem, 3.2vw, 4rem); line-height: 1.05; margin-bottom: 24px; font-weight: 700;">Punish — kelola pelanggaran, sanksi, dan tim dengan mudah.</h1>
            <p style="max-width: 680px; font-size: 1rem; line-height: 1.8; color: rgba(255,255,255,0.92); margin-bottom: 32px;">Dashboard manajemen pelanggaran karyawan yang sederhana untuk HR, admin, dan karyawan. Kelola data karyawan, departemen, jenis pelanggaran, serta buat dan unduh sanksi secara cepat.</p>

            <div style="display: flex; flex-wrap: wrap; gap: 12px; align-items: center;">
                <a href="{{ route('login') }}" class="btn-login" style="display: inline-flex; align-items: center; justify-content: center; min-width: 160px; padding: 12px 22px; border-radius: 12px; background: #ffffff; color: #4f46e5; font-weight: 600; text-decoration: none;">Masuk</a>
                <a href="{{ route('register') }}" class="btn-register" style="display: inline-flex; align-items: center; justify-content: center; min-width: 160px; padding: 12px 22px; border-radius: 12px; background: rgba(255,255,255,0.16); color: #ffffff; font-weight: 600; text-decoration: none;">Daftar</a>
            </div>
        </div>
    </div>

    <section style="margin-top: 36px; display: grid; gap: 22px;">
        <div style="display: grid; gap: 20px; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));">
            <article style="background: #ffffff; border-radius: 20px; padding: 28px; box-shadow: 0 18px 40px rgba(15, 23, 42, 0.05);">
                <h2 style="font-size: 1.1rem; margin-bottom: 12px; color: #111827;">Kelola Karyawan</h2>
                <p style="font-size: 0.95rem; color: #4b5563; line-height: 1.7;">Daftar karyawan terpusat dengan akses untuk mengelola profil, jabatan, dan statistik pelanggaran.</p>
            </article>
            <article style="background: #ffffff; border-radius: 20px; padding: 28px; box-shadow: 0 18px 40px rgba(15, 23, 42, 0.05);">
                <h2 style="font-size: 1.1rem; margin-bottom: 12px; color: #111827;">Jenis & Kategori</h2>
                <p style="font-size: 0.95rem; color: #4b5563; line-height: 1.7;">Atur jenis pelanggaran dan sanksi agar setiap pelanggaran tercatat dengan aturan yang konsisten.</p>
            </article>
            <article style="background: #ffffff; border-radius: 20px; padding: 28px; box-shadow: 0 18px 40px rgba(15, 23, 42, 0.05);">
                <h2 style="font-size: 1.1rem; margin-bottom: 12px; color: #111827;">Sanksi Otomatis</h2>
                <p style="font-size: 0.95rem; color: #4b5563; line-height: 1.7;">Buat dan kirimkan sanksi dengan cepat, lalu unduh laporan PDF untuk dokumentasi.</p>
            </article>
        </div>

        <div style="background: #ffffff; border-radius: 24px; padding: 32px; box-shadow: 0 18px 40px rgba(15, 23, 42, 0.05);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 14px; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 260px;">
                    <h3 style="font-size: 1.25rem; margin-bottom: 12px; color: #111827;">Kenapa pilih Punish?</h3>
                    <ul style="display: grid; gap: 12px; list-style: none; padding-left: 0; color: #4b5563; font-size: 0.96rem; line-height: 1.8;">
                        <li>• Tampilan dashboard ringkas dan bisa langsung digunakan oleh tim HR.</li>
                        <li>• Akses login untuk karyawan, admin, dan manajemen.</li>
                        <li>• Integrasi form pelanggaran, data departemen, dan laporan sanksi.</li>
                    </ul>
                </div>
                <div style="min-width: 200px; background: linear-gradient(180deg, #eef2ff 0%, #fdf2f8 100%); border-radius: 18px; padding: 20px;">
                    <p style="font-size: 0.9rem; color: #6b7280; margin-bottom: 14px;">Akses cepat</p>
                    <div style="display: grid; gap: 10px;">
                        <span style="display:block; background:#ffffff; border-radius:14px; padding:14px 16px; color:#1f2937; font-weight:600;">Dashboard</span>
                        <span style="display:block; background:#ffffff; border-radius:14px; padding:14px 16px; color:#1f2937; font-weight:600;">Pelanggaran</span>
                        <span style="display:block; background:#ffffff; border-radius:14px; padding:14px 16px; color:#1f2937; font-weight:600;">Sanksi</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section style="margin-top: 36px; display: grid; gap: 16px;">
        <div style="background: #eef2ff; border-radius: 22px; padding: 28px; display: grid; gap: 14px;">
            <h4 style="font-size: 1rem; color: #1d4ed8; margin-bottom: 8px;">Siap mulai?</h4>
            <p style="color: #334155; line-height: 1.75;">Buat akun sekarang dan kelola pelanggaran karyawan dengan sistem yang terstruktur dan mudah dipakai.</p>
            <div style="display: inline-flex; gap: 12px; flex-wrap: wrap;">
                <a href="{{ route('register') }}" style="background: #1d4ed8; color: #ffffff; padding: 12px 20px; border-radius: 12px; text-decoration: none; font-weight: 600;">Daftar Sekarang</a>
                <a href="{{ route('login') }}" style="background: transparent; border: 1px solid #1d4ed8; color: #1d4ed8; padding: 12px 20px; border-radius: 12px; text-decoration: none; font-weight: 600;">Masuk</a>
            </div>
        </div>
    </section>
@endsection
