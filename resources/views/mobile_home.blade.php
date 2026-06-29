<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Mobile Dashboard</title>
    <!-- Bootstrap CSS CDN -->
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
        .text-muted {
            color: #94a3b8 !important;
        }

        /* Landscape / tablet: carousel runs as a modal-style full-screen overlay */
        @media (min-aspect-ratio: 16/10) and (orientation: landscape) {
            #heroCarousel {
                position: fixed;
                inset: 0;
                z-index: 2000;
            }
            #heroCarousel .carousel {
                height: 100dvh;
            }
            #heroCarousel .carousel-inner,
            #heroCarousel .carousel-item {
                height: 100%;
            }
            #heroCarousel .carousel-item {
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #020617 !important;
            }
            #heroCarousel .carousel-item .container {
                width: 100%;
                max-width: 600px;
                padding: 2rem;
            }
            .carousel-control-prev,
            .carousel-control-next {
                width: 15%;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">PunishApp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Carousel -->
<div id="heroCarousel" class="carousel slide mb-4" data-bs-ride="carousel" data-bs-interval="4000">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="container text-center py-5">
                <div class="display-4 mb-3">📋</div>
                <h2 class="fw-bold mb-2">Manajemen Pelanggaran</h2>
                <p class="text-muted">Catat dan kelola semua pelanggaran karyawan secara terpusat</p>
            </div>
        </div>
        <div class="carousel-item">
            <div class="container text-center py-5">
                <div class="display-4 mb-3">⚖️</div>
                <h2 class="fw-bold mb-2">Sistem Sanksi</h2>
                <p class="text-muted">Berikan sanksi yang adil dan terukur untuk setiap pelanggaran</p>
            </div>
        </div>
        <div class="carousel-item">
            <div class="container text-center py-5">
                <div class="display-4 mb-3">📊</div>
                <h2 class="fw-bold mb-2">Dashboard Analitik</h2>
                <p class="text-muted">Pantau statistik pelanggaran dan sanksi secara real-time</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="container pb-5">
    <h4 class="mb-3">Dashboard</h4>
    <div class="row g-3">
        <div class="col-12">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Data Karyawan</h5>
                    <p class="card-text">Lihat dan kelola data karyawan.</p>
                    <a href="#" class="btn btn-primary w-100">Lihat Karyawan</a>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Pelanggaran</h5>
                    <p class="card-text">Catat dan pantau pelanggaran.</p>
                    <a href="#" class="btn btn-danger w-100">Lihat Pelanggaran</a>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Sanksi</h5>
                    <p class="card-text">Kelola sanksi yang diberikan.</p>
                    <a href="#" class="btn btn-warning w-100">Lihat Sanksi</a>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Kategori & Jenis</h5>
                    <p class="card-text">Atur kategori dan jenis pelanggaran.</p>
                    <a href="#" class="btn btn-info w-100">Lihat Kategori</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
