<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>PunishApp Mobile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #020617 !important;
            color: #f8fafc !important;
            padding-top: env(safe-area-inset-top);
            padding-bottom: env(safe-area-inset-bottom);
            min-height: 100vh;
            min-height: 100dvh;
        }
        .card { 
            background-color: #0f172a !important;
            border-color: #1e293b !important;
            color: #f8fafc !important;
            margin-bottom: 1rem; 
        }
        .navbar-brand { font-weight: bold; color: #f8fafc !important; }
        nav.navbar {
            background-color: #020617 !important;
            border-bottom: 1px solid #1e293b !important;
            padding-top: max(0.5rem, env(safe-area-inset-top));
            padding-bottom: max(0.5rem, env(safe-area-inset-top));
        }
        .navbar-nav .nav-link {
            color: #cbd5e1 !important;
        }
        .navbar-nav .nav-link:hover {
            color: #f8fafc !important;
        }
        .navbar-toggler {
            border-color: #334155 !important;
        }
        .navbar-toggler-icon {
            filter: invert(1);
        }
        main {
            padding-bottom: env(safe-area-inset-bottom);
        }
        .text-muted {
            color: #94a3b8 !important;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">PunishApp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/mobile_home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/mobile_karyawan">Karyawan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/mobile_pelanggaran">Pelanggaran</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/mobile_sanksi">Sanksi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/mobile_kategori">Kategori</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main>
@yield('content')
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
