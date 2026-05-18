<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Punish') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ============================================
           NAVBAR ADMIN - Dark Professional
        ============================================ */
        .navbar-admin {
            background: #1a1d2e;
            padding: 0 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 60px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.3);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-admin .brand {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .navbar-admin .brand span {
            color: #7c6fff;
        }

        .navbar-admin .nav-links {
            display: flex;
            align-items: center;
            gap: 2px;
        }

        .navbar-admin .nav-links a {
            color: #9aa0b8;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            padding: 6px 14px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .navbar-admin .nav-links a:hover,
        .navbar-admin .nav-links a.active {
            color: #fff;
            background: rgba(124, 111, 255, 0.18);
        }

        .navbar-admin .nav-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .navbar-admin .badge-role {
            background: rgba(124, 111, 255, 0.15);
            color: #a99fff;
            font-size: 10px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            border: 1px solid rgba(124, 111, 255, 0.35);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .navbar-admin .user-name {
            color: #d0d4e8;
            font-size: 13px;
            font-weight: 500;
        }

        .navbar-admin .avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 2px solid rgba(124, 111, 255, 0.5);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #7c6fff 0%, #4f46e5 100%);
        }

        .navbar-admin .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .navbar-admin .btn-profile {
            background: rgba(255,255,255,0.07);
            color: #d0d4e8;
            border: 1px solid rgba(255,255,255,0.12);
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            font-weight: 500;
            padding: 5px 14px;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .navbar-admin .btn-profile:hover {
            background: rgba(255,255,255,0.12);
            color: #fff;
        }

        .navbar-admin .btn-logout {
            background: rgba(220, 53, 69, 0.12);
            color: #ff6b7a;
            border: 1px solid rgba(220, 53, 69, 0.25);
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            font-weight: 500;
            padding: 5px 14px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .navbar-admin .btn-logout:hover {
            background: rgba(220, 53, 69, 0.22);
            color: #ff8a95;
        }

        .navbar-admin .profile-dropdown,
        .navbar-user .profile-dropdown {
            position: relative;
        }

        .navbar-admin .profile-button,
        .navbar-user .profile-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.14);
            color: inherit;
            padding: 6px 10px;
            border-radius: 999px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: background 0.2s, transform 0.2s;
            text-decoration: none;
        }

        .navbar-admin .profile-button:hover,
        .navbar-user .profile-button:hover {
            background: rgba(255,255,255,0.14);
            transform: translateY(-1px);
        }

        .navbar-admin .profile-button .dropdown-icon,
        .navbar-user .profile-button .dropdown-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .navbar-admin .profile-menu,
        .navbar-user .profile-menu {
            position: absolute;
            right: 0;
            top: calc(100% + 12px);
            min-width: 180px;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 14px;
            box-shadow: 0 24px 58px rgba(15, 23, 42, 0.14);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: opacity 0.18s ease, transform 0.18s ease, visibility 0.18s;
            z-index: 10;
        }

        .navbar-admin .profile-dropdown:hover .profile-menu,
        .navbar-user .profile-dropdown:hover .profile-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .navbar-admin .menu-item,
        .navbar-user .menu-item {
            width: 100%;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            color: #1f2937;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            background: transparent;
            border: none;
            text-align: left;
            cursor: pointer;
        }

        .navbar-admin .menu-item:hover,
        .navbar-user .menu-item:hover {
            background: #f8fafc;
        }

        .navbar-admin .menu-divider,
        .navbar-user .menu-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 4px 0;
        }

        .navbar-admin .profile-dropdown form,
        .navbar-user .profile-dropdown form {
            margin: 0;
        }

        /* ============================================
           NAVBAR USER - Light & Clean
        ============================================ */
        .navbar-user {
            background: #ffffff;
            padding: 0 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 60px;
            box-shadow: 0 1px 0 #e5e7eb, 0 2px 8px rgba(0,0,0,0.06);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-user .brand {
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .navbar-user .brand span {
            color: #6366f1;
        }

        .navbar-user .nav-links {
            display: flex;
            align-items: center;
            gap: 2px;
        }

        .navbar-user .nav-links a {
            color: #6b7280;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            padding: 6px 14px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .navbar-user .nav-links a:hover,
        .navbar-user .nav-links a.active {
            color: #6366f1;
            background: #f0f0ff;
        }

        .navbar-user .nav-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .navbar-user .badge-role {
            background: #f0fdf4;
            color: #16a34a;
            font-size: 10px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            border: 1px solid #bbf7d0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .navbar-user .user-name {
            color: #374151;
            font-size: 13px;
            font-weight: 500;
        }

        .navbar-user .avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 2px solid #e0e0ff;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #6366f1 0%, #3b82f6 100%);
        }

        .navbar-user .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .navbar-user .btn-profile {
            background: #f5f5ff;
            color: #6366f1;
            border: 1px solid #c7d2fe;
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            font-weight: 500;
            padding: 5px 14px;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .navbar-user .btn-profile:hover {
            background: #ede9fe;
            border-color: #a5b4fc;
        }

        .navbar-user .btn-logout {
            background: #fff1f2;
            color: #e11d48;
            border: 1px solid #fecdd3;
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            font-weight: 500;
            padding: 5px 14px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .navbar-user .btn-logout:hover {
            background: #ffe4e6;
        }

        /* ============================================
           NAVBAR GUEST - Minimal
        ============================================ */
        .navbar-guest {
            background: #ffffff;
            padding: 0 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 60px;
            box-shadow: 0 1px 0 #e5e7eb;
        }

        .navbar-guest .brand {
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
            text-decoration: none;
        }

        .navbar-guest .brand span {
            color: #6366f1;
        }

        .navbar-guest .btn-login {
            background: #6366f1;
            color: #fff;
            border: none;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 500;
            padding: 7px 20px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            margin-left: 10px;
            transition: background 0.2s;
        }

        .navbar-guest .btn-login:hover {
            background: #4f46e5;
        }

        .navbar-guest .btn-register {
            background: transparent;
            color: #6366f1;
            border: 1.5px solid #6366f1;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 500;
            padding: 6px 18px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .navbar-guest .btn-register:hover {
            background: #f5f5ff;
        }

        /* ============================================
           CONTENT & FOOTER
        ============================================ */
        .main-content {
            flex: 1;
            padding: 28px;
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
            padding: 24px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            color: #ffffff;
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #1f2937;
        }

        .btn-sm {
            padding: 8px 14px;
            font-size: 13px;
        }

        .text-muted {
            color: #6b7280;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
        }

        th,
        td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        th {
            font-size: 13px;
            font-weight: 700;
            color: #4b5563;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .site-footer {
            background: #fff;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            padding: 16px;
            font-size: 12px;
            color: #9ca3af;
        }

        .site-footer strong {
            color: #6366f1;
        }
    </style>
</head>
<body>

    {{-- ===== NAVBAR ADMIN ===== --}}
    @auth
        @if(!auth()->user()->otp_verified_at)
        <nav class="navbar-user">
            <a href="{{ route('otp.verify.form') }}" class="brand"><span>Punish</span></a>

            <div class="nav-right">
                <span class="badge-role">OTP Pending</span>
                <span class="user-name">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">Keluar</button>
                </form>
            </div>
        </nav>
        @elseif(auth()->user()->role === 'admin')
        <nav class="navbar-admin">
            {{-- Brand --}}
            <a href="{{ route('dashboard') }}" class="brand"><span>Punish</span> Admin</a>

            {{-- Menu Admin: akses penuh semua fitur --}}
            <div class="nav-links">
                <a href="{{ route('dashboard') }}"
                   class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('karyawan.index.web') }}"
                   class="{{ request()->routeIs('karyawan.*') ? 'active' : '' }}">
                    Karyawan
                </a>
                <a href="{{ route('departemen.index.web') }}"
                   class="{{ request()->routeIs('departemen.*') ? 'active' : '' }}">
                    Departemen
                </a>
                <a href="{{ route('jenis-pelanggaran.index.web') }}"
                   class="{{ request()->routeIs('jenis-pelanggaran.*') ? 'active' : '' }}">
                    Jenis Pelanggaran
                </a>
                <a href="{{ route('pelanggaran.index.web') }}"
                   class="{{ request()->routeIs('pelanggaran.*') ? 'active' : '' }}">
                    Pelanggaran
                </a>
                <a href="{{ route('sanksi.index.web') }}"
                   class="{{ request()->routeIs('sanksi.*') ? 'active' : '' }}">
                    Sanksi
                </a>
            </div>

            {{-- Right: badge, nama, avatar, tombol --}}
            <div class="nav-right">
                <span class="badge-role">Admin</span>
                <span class="user-name">{{ auth()->user()->name }}</span>
                <div class="profile-dropdown">
                    <button type="button" class="profile-button">
                        <div class="avatar" aria-label="Avatar">
                            @if(auth()->user()->profile_photo_url)
                                <img src="{{ auth()->user()->profile_photo_url }}" alt="Avatar">
                            @else
                                {{ auth()->user()->initials }}
                            @endif
                        </div>
                        <span>{{ auth()->user()->name }}</span>
                        <span class="dropdown-icon">▾</span>
                    </button>
                    <div class="profile-menu">
                        <a href="{{ route('profile.edit') }}" class="menu-item">Profile</a>
                        <div class="menu-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="menu-item">Sign out</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        {{-- ===== NAVBAR USER ===== --}}
        @else
        <nav class="navbar-user">
            {{-- Brand --}}
            <a href="{{ route('dashboard') }}" class="brand"><span>Punish</span></a>

            {{-- Menu User: hanya fitur yang diizinkan --}}
            <div class="nav-links">
                <a href="{{ route('dashboard') }}"
                   class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('pelanggaran.index.web') }}"
                   class="{{ request()->routeIs('pelanggaran.*') ? 'active' : '' }}">
                    Pelanggaran
                </a>
                <a href="{{ route('departemen.index.web') }}"
                   class="{{ request()->routeIs('departemen.*') ? 'active' : '' }}">
                    Departemen
                </a>
                <a href="{{ route('jenis-pelanggaran.index.web') }}"
                   class="{{ request()->routeIs('jenis-pelanggaran.*') ? 'active' : '' }}">
                    Jenis Pelanggaran
                </a>
                <a href="{{ route('sanksi.index.web') }}"
                   class="{{ request()->routeIs('sanksi.*') ? 'active' : '' }}">
                    Sanksi
                </a>
            </div>

            {{-- Right --}}
            <div class="nav-right">
                <span class="badge-role">Karyawan</span>
                <span class="user-name">{{ auth()->user()->name }}</span>
                <div class="profile-dropdown">
                    <button type="button" class="profile-button">
                        <div class="avatar" aria-label="Avatar">
                            @if(auth()->user()->profile_photo_url)
                                <img src="{{ auth()->user()->profile_photo_url }}" alt="Avatar">
                            @else
                                {{ auth()->user()->initials }}
                            @endif
                        </div>
                        <span>{{ auth()->user()->name }}</span>
                        <span class="dropdown-icon">▾</span>
                    </button>
                    <div class="profile-menu">
                        <a href="{{ route('profile.edit') }}" class="menu-item">Profile</a>
                        <div class="menu-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="menu-item">Sign out</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        @endif

    {{-- ===== NAVBAR GUEST ===== --}}
    @else
        <nav class="navbar-guest">
            <a href="/" class="brand"><span>Punish</span></a>
            <div>
                <a href="{{ route('register') }}" class="btn-register">Daftar</a>
                <a href="{{ route('login') }}" class="btn-login">Masuk</a>
            </div>
        </nav>
    @endauth

    {{-- ===== FLASH MESSAGES ===== --}}
    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                ✕ {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

    {{-- ===== FOOTER ===== --}}
    <footer class="site-footer">
        &copy; {{ date('Y') }} <strong>Punish</strong> &mdash; Sistem Manajemen Pelanggaran Karyawan. All rights reserved.
    </footer>

</body>
</html>
