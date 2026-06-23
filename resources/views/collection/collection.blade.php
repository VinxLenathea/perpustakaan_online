<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $category->category_name }} - {{ config('app.name', 'Perpustakaan Online RSMN') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <style>
        /* --- Layout Dasar --- */
        html,
        body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
            font-family: 'Instrument Sans', sans-serif;
            overflow-x: hidden;
        }

        body>footer {
            margin-top: auto;
        }

        /* --- Hero Section --- */
        .hero-section {
            background-color: #001f3f;
            color: white;
            padding: 70px 20px;
            text-align: center;
        }

        /* --- Search Container --- */
        .search-container {
            background-color: #001f3f;
            padding: 20px;
            margin-top: -45px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        /* --- Card Dokumen --- */
        .doc-card {
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 20px;
            background: #fff;
            transition: 0.3s;
            margin-bottom: 20px;
            height: 100%;
        }

        .doc-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .img-cover-wrapper {
            width: 100%;
            max-width: 130px;
            margin: 0 auto;
        }

        .img-cover {
            width: 100%;
            aspect-ratio: 3/4;
            object-fit: cover;
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .text-title {
            color: #d93025 !important;
            font-weight: bold;
            text-decoration: none;
            font-size: 1.1rem;
            display: block;
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .info-row {
            display: flex;
            margin-bottom: 4px;
            font-size: 0.9rem;
        }

        .info-label {
            width: 100px;
            font-weight: bold;
            flex-shrink: 0;
            color: #333;
        }

        .info-value {
            color: #555;
        }

        .btn-navy {
            background-color: #001f3f;
            color: white;
            border: none;
        }

        .btn-navy:hover {
            background-color: #002d5c;
            color: white;
        }

        /* Pagination Style */
        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            color: #001f3f;
        }

        .page-item.active .page-link {
            background-color: #001f3f;
            border-color: #001f3f;
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 50px 20px 70px;
            }

            .info-label {
                width: 85px;
            }

            .img-cover-wrapper {
                margin-bottom: 15px;
                max-width: 100px;
            }
        }
    </style>
</head>

<body>

    <!-- Header -->
    @include('view component.headerWelcome')

    <main class="flex-grow-1">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="container">
                <h1 class="fw-bold mb-3">Koleksi {{ ucfirst(str_replace('_', ' ', $category->category_name)) }}</h1>
                <p class="opacity-75 mx-auto" style="max-width: 700px;">
                    Temukan referensi digital terbaik dalam kategori {{ ucfirst(str_replace('_', ' ', $category->category_name)) }} untuk mendukung kebutuhan informasi Anda.
                </p>
            </div>
        </div>

        <!-- Search Bar (Style Halaman Welcome) -->
        <div class="container mb-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="search-container" style="margin-top: 10px">
                        <form action="{{ route('collection', $category->category_name) }}" method="GET">
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-center gap-3">
                                <div class="text-center text-md-start">
                                    <span class="text-white fw-bold">Cari</span>
                                </div>
                                <div class="w-100 w-md-auto">
                                    <select name="filter" class="form-select form-select-sm py-2">
                                        <option value="judul" {{ request('filter') == 'judul' ? 'selected' : '' }}>Judul</option>
                                        <option value="penulis" {{ request('filter') == 'penulis' ? 'selected' : '' }}>Pembuat</option>
                                        <option value="tahun" {{ request('filter') == 'tahun' ? 'selected' : '' }}>Tahun</option>
                                    </select>
                                </div>
                                <div class="d-none d-md-block text-white-50 small">berdasarkan</div>
                                <div class="input-group input-group-sm w-100">
                                    <input type="text" name="keyword" class="form-control py-2" placeholder="Kata kunci pencarian..." value="{{ request('keyword') }}">
                                    <button type="submit" class="btn btn-primary px-3 shadow-none">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents List -->
        <div class="container mb-5">
            <div class="row">
                <!-- Header List & Sort -->
                <div class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                    <h3 class="fw-bold m-0" style="color: #001f3f;">Daftar {{ ucfirst(str_replace('_', ' ', $category->category_name)) }}</h3>

                    @if ($documents->count() > 0)
                    @php
                    $sortOptions = [
                    'tahun_desc' => ['icon' => 'fas fa-calendar-alt', 'label' => 'Terbaru'],
                    'tahun_asc' => ['icon' => 'fas fa-calendar', 'label' => 'Terlama'],
                    'judul_asc' => ['icon' => 'fas fa-sort-alpha-down', 'label' => 'A - Z'],
                    'views' => ['icon' => 'fas fa-eye', 'label' => 'Populer'],
                    ];
                    $currentSort = request('sort_by') ?: 'tahun_desc';
                    @endphp
                    <div class="dropdown">
                        <span class="me-2 small fw-bold text-muted">Urutkan:</span>
                        <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="{{ $sortOptions[$currentSort]['icon'] }} me-1"></i> {{ $sortOptions[$currentSort]['label'] }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            @foreach ($sortOptions as $key => $option)
                            <li>
                                <a class="dropdown-item {{ $key == $currentSort ? 'active' : '' }}"
                                    href="{{ request()->fullUrlWithQuery(['sort_by' => $key]) }}">
                                    <i class="{{ $option['icon'] }} me-2"></i> {{ $option['label'] }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>

                @if ($documents->count() > 0)
                <div class="row g-4">
                    @foreach ($documents as $doc)
                    <div class="col-lg-6">
                        <div class="doc-card">
                            <div class="row g-0 align-items-start">
                                <!-- Bagian Cover -->
                                <div class="col-4 col-sm-3">
                                    <div class="img-cover-wrapper">
                                        @php
                                        $coverUrl = asset('assets/img/undraw_posting_photo.svg');
                                        if ($doc->category->category_name == 'Poster' && $doc->file_url) {
                                        $coverUrl = asset('storage/' . $doc->file_url);
                                        } elseif ($doc->cover_image) {
                                        $coverUrl = asset('storage/' . $doc->cover_image);
                                        }
                                        @endphp
                                        <img src="{{ $coverUrl }}" class="img-cover shadow-sm" alt="{{ $doc->title }}">
                                    </div>
                                </div>

                                <!-- Bagian Detail -->
                                <div class="col-8 col-sm-9 ps-3">
                                    <a href="{{ route('documents.readonly', $doc->id) }}" class="text-title">
                                        {{ $doc->title }}
                                    </a>
                                    <div class="info-row">
                                        <span class="info-label">Pembuat</span>
                                        <span class="info-value">: {{ $doc->author }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Tahun</span>
                                        <span class="info-value">: {{ $doc->year_published }}</span>
                                    </div>
                                    @if($doc->abstract)
                                    <div class="info-row d-none d-md-flex mt-2">
                                        <span class="info-label">Abstrak:</span>
                                        <span class="info-value small text-muted">{{ Str::limit($doc->abstract, 160) }}</span>
                                    </div>
                                    @endif
                                    <div class="info-row">
                                        <span class="info-label">Dilihat</span>
                                        <span class="info-value">: {{ $doc->views }} kali</span>
                                    </div>

                                    <div class="mt-3">
                                        <a href="{{ route('documents.readonly', $doc->id) }}" class="btn btn-navy btn-sm px-3 rounded-pill">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $documents->links('pagination::bootstrap-5') }}
                </div>
                @else
                <div class="col-12 text-center py-5">
                    <img src="{{ asset('assets/img/undraw_no_data.svg') }}" style="width: 200px;" class="mb-3 opacity-50">
                    <p class="text-muted">Maaf, koleksi untuk kategori ini belum tersedia.</p>
                    <a href="/" class="btn btn-outline-secondary btn-sm">Kembali ke Beranda</a>
                </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Footer -->
    @include('view component.footerWelcome')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>