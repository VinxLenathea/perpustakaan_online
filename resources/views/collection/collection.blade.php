<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $category->category_name }} - {{ config('app.name', 'Perpustakaan Online') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet">

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
        <!-- Logo kiri -->
        <div class="d-flex align-items-center">
            <img src="{{ asset('assets/img/logo rsmn.png') }}" alt="Logo Perpustakaan" class="img-fluid me-2" style="max-width: 80px; height: auto;">
            <h5 class="m-0 text-success">Perpustakaan online RSMN</h5>
        </div>

        <!-- Kontak & Login kanan -->
        <div class="d-flex align-items-center">
            <a href="#" class="me-3 text-decoration-none text-dark">
                <i class="fas fa-map-marker-alt me-1 text-success"></i> Jl. Bonorogo No.17 Pamekasan
            </a>
            <a href="tel:+6281234567890" class="me-3 text-decoration-none text-dark">
                <i class="fas fa-phone-alt me-1 text-success"></i> +62812-3079-7005
            </a>

            <!-- Dropdown Akun -->
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
            <h1 class="display-4 fw-bold">Koleksi {{ ucfirst(str_replace('_', ' ', $category->category_name)) }}</h1>
            <p class="lead">Temukan koleksi {{ ucfirst(str_replace('_', ' ', $category->category_name)) }} terlengkap untuk mendukung pembelajaran dan penelitian Anda.</p>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('collection', $category->category_name) }}" method="GET" class="d-flex flex-wrap align-items-center justify-content-center bg-light p-3 rounded">
                    <span class="me-2">Cari</span>
                    <select name="filter" class="form-select form-select-sm me-2" style="width: auto;">
                        <option value="judul" {{ request('filter') == 'judul' ? 'selected' : '' }}>Judul</option>
                        <option value="penulis" {{ request('filter') == 'penulis' ? 'selected' : '' }}>Penulis</option>
                        <option value="tahun" {{ request('filter') == 'tahun' ? 'selected' : '' }}>Tahun</option>
                    </select>
                    <span class="me-2">berdasarkan</span>
                    <input type="text" name="keyword" class="form-control form-control-sm me-2" placeholder="Kata kunci..." value="{{ request('keyword') }}" style="max-width: 200px;">
                    <button class="btn btn-success btn-sm" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Documents List -->
    <div class="container my-4">
        <h2 class="text-center mb-4 text-success">Daftar {{ ucfirst(str_replace('_', ' ', $category->category_name)) }}</h2>
        @if($documents->count() > 0)
            <div class="row">
                @foreach($documents as $doc)
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm border-0 rounded-3 card-hover">
                            <div class="row g-0">
                                <!-- Cover Dokumen -->
                                <div class="col-md-3">
                                    @if($doc->cover_image)
                                        <img src="{{ asset('storage/' . $doc->cover_image) }}" class="img-fluid rounded-start" alt="Cover {{ $doc->title }}">
                                    @else
                                        <img src="{{ asset('assets/img/undraw_posting_photo.svg') }}" class="img-fluid rounded-start" alt="Cover {{ $doc->title }}">
                                    @endif
                                </div>
                                <!-- Detail Dokumen -->
                                <div class="col-md-9">
                                    <div class="card-body">
                                        <h4 class="card-title text-danger fw-bold mb-3">{{ $doc->title }}</h4>
                                        <p class="mb-1"><strong>Pengarang:</strong> {{ $doc->author }}</p>
                                        <p class="mb-1"><strong>Tahun Terbit:</strong> {{ $doc->year_published }}</p>
                                        @if($doc->abstract)
                                            <p class="mb-1"><strong>Abstrak:</strong> {{ Str::limit($doc->abstract, 100) }}</p>
                                        @endif
                                        <p class="mb-3">
                                            <strong>Konten Digital:</strong>
                                            <a href="{{ asset('storage/' . $doc->file_url) }}" target="_blank" class="text-primary fw-semibold">Lihat File</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center">
                <p class="text-muted">Belum ada dokumen dalam kategori ini.</p>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">&copy; 2024 Perpustakaan Online RSMN. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
