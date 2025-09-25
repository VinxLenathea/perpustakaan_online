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
    .navbar-cusatom {
        background-color: #001f3f !important; /* Navy utama */
    }
    .navbar-custom .nav-link {
        color: FED16A !important;
    }
    .navbar-custom .dropdown-menu {
        background-color: #002147; /* Navy lebih terang */
    }
    .navbar-custom .dropdown-item {
        color:FED16A;
    }
    .navbar-custom .dropdown-item:hover {
        background-color: #001633; /* Hover lebih gelap */
    }
    .search-bar {
        background-color: #002147s;
        padding: 20px;
        margin: 20px 0;
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
    .search-bar {
    background-color: #001f3f; /* Navy utama */
    padding: 20px;
    margin: 20px 0;
    border-radius: 8px; /* opsional biar lebih halus */
}

</style>

    @endif
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18]">

 <!-- Top Bar -->
<div class="top-bar d-flex justify-content-between align-items-center">
    <!-- Logo di kiri -->
    <div class="d-flex align-items-center">
        <img src="assets/img/logo rsmn.png" alt="Logo Perpustakaan" width="100" height="100" class="me-2">
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


    <!-- Logo & Search Section -->
    <div class="container-fluid">
        <div class="row search-bar">

            <!-- Search -->
            <div class="col-md-8" height="80">
    <form class="d-flex align-items-center justify-content-center text-white">
        <span class="me-2">Search the</span>
        <select class="form-select form-select-sm me-2" style="width: auto;">
            <option>Judul</option>
            <option>Penulis</option>
            <option>Tahun</option>
        </select>
        <span class="me-2">by</span>
        <select class="form-select form-select-sm me-2" style="width: auto;">
            <option>Karya Tulis Ilmiah</option>
            <option>Poster</option>
            <option>Penelitian Eksternal</option>
            <option>Penelitian Internal</option>
        </select>
        <input type="text" class="form-control form-control-sm me-2" style="width: 200px;" placeholder="Enter search terms...">
        <button class="btn btn-outline-light" type="submit">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>

        </div>
    </div>



    <!-- Main Content Area -->
    <div class="container-fluid mt-4">
        <div class="row">

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif
</body>
</html>
