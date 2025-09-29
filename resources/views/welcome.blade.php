<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Perpustakaan Online') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <!-- Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
    .navbar-custom {
        background-color: #001f3f !important; /* Navy utama */
    }
    .navbar-custom .nav-link {
        color: #FED16A !important;
    }
    .navbar-custom .dropdown-menu {
        background-color: #002147; /* Navy lebih terang */
    }
    .navbar-custom .dropdown-item {
        color: #FED16A;
    }
    .navbar-custom .dropdown-item:hover {
        background-color: #001633; /* Hover lebih gelap */
    }
    .search-bar {
        background-color: #001f3f; /* Navy utama */
        padding: 20px;
        margin: 20px 0;
        border-radius: 8px;
    }
    .top-bar {
        background-color: #f8f9fa;
        padding: 10px 20px;
        border-bottom: 1px solid #dee2e6;
    }
    .btn-success {
        background-color: #001f3f;  /* Tombol navy */
        border-color: #001f3f;
    }
    .btn-success:hover {
        background-color: #001633; /* Hover navy */
        border-color: #001633;
    }
    .text-success {
        color: #001f3f !important; /* Ikon & teks jadi navy */
    }
    .hero-section {
        background: linear-gradient(135deg, #001f3f 0%, #002147 100%);
        color: white;
        padding: 60px 0;
        text-align: center;
    }
    .featured-grid {
        padding: 40px 0;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
    }

</style>

    @endif
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18]">

 <!-- Top Bar -->
<div class="top-bar d-flex justify-content-between align-items-center">
    <!-- Logo di kiri -->
    <div class="d-flex align-items-center">
        <img src="assets/img/logo rsmn.png" alt="Logo Perpustakaan" class="img-fluid me-2" style="max-width: 80px; height: auto;">
        <h5 class="m-0 text-success">Perpustakaan online RSMN</h5>
    </div>

    <!-- Kontak dan Login di kanan -->
<div class="d-flex align-items-center">
    <a href="#" class="me-3 text-decoration-none text-dark">
        <i class="fas fa-map-marker-alt me-1 text-success"></i> Jl. Bonorogo No.17 Pamekasan
    </a>
    <a href="tel:+6281234567890" class="me-3 text-decoration-none text-dark">
        <i class="fas fa-phone-alt me-1 text-success"></i>+62812-3079-7005
    </a>

    <!-- Dropdown Login/Register -->
    <div class="dropdown">
        <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Akun
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
            <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
        </ul>
    </div>
</div>

</div>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold">Selamat Datang di Perpustakaan Online RSMN</h1>
            <p class="lead">Temukan koleksi buku, jurnal, dan dokumen ilmiah terlengkap untuk mendukung pembelajaran dan penelitian Anda.</p>
            <a href="{{ route('library') }}" class="btn btn-light btn-lg">Jelajahi Koleksi</a>
        </div>
    </div>

    <!-- Logo & Search Section -->
    <div class="container-fluid">
        <div class="row search-bar">

            <!-- Search -->
            <div class="col-12 d-flex justify-content-center">
    <form class="d-flex align-items-center justify-content-center text-white flex-wrap" action="{{ route('library') }}" method="GET">
        <span class="me-2">Cari</span>
        <select class="form-select form-select-sm me-2" name="search_by" style="width: auto;">
            <option value="judul">Judul</option>
            <option value="penulis">Penulis</option>
            <option value="tahun">Tahun</option>
        </select>
        <span class="me-2">berdasarkan</span>
        <select class="form-select form-select-sm me-2" name="category" style="width: auto;">
            <option value="karya_tulis_ilmiah">Karya Tulis Ilmiah</option>
            <option value="poster">Poster</option>
            <option value="penelitian_eksternal">Penelitian Eksternal</option>
            <option value="penelitian_internal">Penelitian Internal</option>
        </select>
        <input type="text" class="form-control form-control-sm me-2" name="query" style="min-width: 200px;" placeholder="Masukkan kata kunci...">
        <button class="btn btn-outline-light" type="submit">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>

        </div>
    </div>

<div class="container my-4">
    <h2 class="text-center mb-4 text-success">Buku Unggulan</h2>
    <div class="card shadow-sm border-0 rounded-3 card-hover">
        <div class="row g-0">
            <!-- Gambar Cover -->
            <div class="col-md-3">
                <img src="assets/img/undraw_posting_photo.svg" class="img-fluid rounded-start" alt="Cover Buku Unggulan">
            </div>
            <!-- Detail Buku -->
            <div class="col-md-9">
                <div class="card-body">
                    <h4 class="card-title text-danger fw-bold mb-3">
                        Thoracic Surgery Clinics
                    </h4>
                    <p class="mb-1"><strong>Jenis Bahan:</strong> Sumber Elektronik</p>
                    <p class="mb-1"><strong>Pengarang:</strong></p>
                    <ul class="list-unstyled ms-3">
                        <li><a href="#" class="text-primary text-decoration-none">Sandeep J. Khandhar</a></li>
                    </ul>
                    <p class="mb-1">
                        <strong>Penerbitan:</strong> ELSEVIER SAUNDERS, 2007
                    </p>
                    <p class="mb-1">
                        <strong>Konten Digital:</strong>
                        <a href="#" class="text-primary fw-semibold">pdf</a>
                    </p>
                    <p class="mb-3">
                        <strong>Artikel:</strong> <span class="text-muted">Tidak ada data</span>
                    </p>
                    <a href="{{ route('library') }}" class="btn btn-success">Lihat Lebih Banyak</a>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Featured Categories -->
    <div class="container featured-grid">
        <h2 class="text-center mb-4 text-success">Kategori Unggulan</h2>
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card card-hover text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-book fa-3x text-success mb-3"></i>
                        <h5>Karya Tulis Ilmiah</h5>
                        <p>Koleksi penelitian dan artikel ilmiah terbaru.</p>
                        <a href="{{ route('library') }}?category=karya_tulis_ilmiah" class="btn btn-success">Lihat Koleksi</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card card-hover text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-image fa-3x text-success mb-3"></i>
                        <h5>Poster</h5>
                        <p>Poster penelitian dan presentasi visual.</p>
                        <a href="{{ route('library') }}?category=poster" class="btn btn-success">Lihat Koleksi</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card card-hover text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-flask fa-3x text-success mb-3"></i>
                        <h5>Penelitian Eksternal</h5>
                        <p>Hasil penelitian dari kolaborasi eksternal.</p>
                        <a href="{{ route('library') }}?category=penelitian_eksternal" class="btn btn-success">Lihat Koleksi</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card card-hover text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-microscope fa-3x text-success mb-3"></i>
                        <h5>Penelitian Internal</h5>
                        <p>Penelitian yang dilakukan secara internal.</p>
                        <a href="{{ route('library') }}?category=penelitian_internal" class="btn btn-success">Lihat Koleksi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">&copy; 2024 Perpustakaan Online RSMN. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif
</body>
</html>
