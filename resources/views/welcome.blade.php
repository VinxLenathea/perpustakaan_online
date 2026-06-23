<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Perpustakaan Online RSMN') }}</title>

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

        /* --- Search Bar Responsif --- */
        .search-container {
            background-color: #001f3f;
            padding: 15px;
            margin-top: -35px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);

        }

        .search-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
            justify-content: center;
        }

        .search-wrapper select,
        .search-wrapper input {
            height: 38px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        /* --- List Dokumen (Sesuai Referensi Gambar) --- */
        .doc-card {
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 20px;
            background: #fff;
            transition: 0.3s;
            margin-bottom: 20px;
        }

        .doc-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .img-cover-wrapper {
            width: 100%;
            max-width: 160px;
            /* Menjaga ukuran gambar agar tidak raksasa */
            margin: 0 auto;
        }

        .img-cover {
            width: 100%;
            aspect-ratio: 3/4;
            object-fit: cover;
            border-radius: 5px;
        }

        .text-title {
            color: #d93025 !important;
            font-weight: bold;
            text-decoration: none;
            font-size: 1.15rem;
            display: block;
            margin-bottom: 10px;
        }

        .info-row {
            display: flex;
            margin-bottom: 5px;
            font-size: 0.9rem;
        }

        .info-label {
            width: 110px;
            font-weight: bold;
            flex-shrink: 0;
            color: #333;
        }

        .info-value {
            color: #555;
        }

        /* --- Kategori Unggulan --- */
        .cat-card {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: 0.3s;
        }

        .cat-card:hover {
            border-color: #001f3f;
            transform: translateY(-3px);
        }

        .cat-icon {
            font-size: 2.5rem;
            color: #001f3f;
            margin-bottom: 15px;
        }

        .btn-navy {
            background-color: #001f3f;
            color: white;
            border: none;
            font-size: 0.85rem;
            padding: 8px 20px;
            border-radius: 5px;
        }

        .btn-navy:hover {
            background-color: #001122;
            color: white;
        }

        /* --- Mobile Adjustments --- */
        @media (max-width: 768px) {
            .search-wrapper>* {
                flex: 1 1 100%;
            }

            .info-label {
                width: 90px;
            }

            .img-cover-wrapper {
                margin-bottom: 15px;
            }

            .hero-section h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>

    <!-- Header / Navbar -->
    @include('view component.headerWelcome')

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1 class="fw-bold mb-3">Selamat Datang di Perpustakaan Online RSMN</h1>
            <p class="opacity-75">Temukan koleksi buku, jurnal, dan dokumen ilmiah terlengkap untuk mendukung pembelajaran Anda.</p>
        </div>
    </div>

    <!-- Search Section -->
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="search-container shadow-sm p-3 p-md-4" style="background-color: #001f3f; border-radius: 12px; margin-top: 10px;">
                    <form action="{{ url('/') }}" method="GET">

                        <!-- Container utama menggunakan flex-column (mobile) dan flex-md-row (desktop) -->
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-center gap-3">

                            <!-- Label "Cari" - Muncul di atas pada mobile -->
                            <div class="text-center text-md-start">
                                <span class="text-white fw-bold fs-6">Cari</span>
                            </div>

                            <!-- Dropdown Berdasarkan (Judul, Penulis, dll) -->
                            <div class="w-100 w-md-auto">
                                <select name="search_by" class="form-select form-select-sm py-2 py-md-1" style="width: 100%; min-width: 120px; border-radius: 6px;">
                                    <option value="judul">Judul</option>
                                    <option value="penulis">Pembuat</option>
                                    <option value="tahun">Tahun</option>
                                </select>
                            </div>

                            <!-- Label "berdasarkan" - Disembunyikan di mobile agar lebih clean seperti gambar -->
                            <div class="d-none d-md-block">
                                <span class="text-white fw-medium">berdasarkan</span>
                            </div>

                            <!-- Dropdown Kategori -->
                            <div class="w-100 w-md-auto">
                                <select name="category" class="form-select form-select-sm py-2 py-md-1" style="width: 100%; min-width: 180px; border-radius: 6px;">
                                    <option value="">Semua Kategori</option>
                                    <option value="karya_tulis_ilmiah">Karya Tulis Ilmiah</option>
                                    <option value="Poster">Poster</option>
                                    <option value="penelitian_eksternal">Penelitian Eksternal</option>
                                    <option value="penelitian_internal">Penelitian Internal</option>
                                    <option value="e_book">E-Book</option>
                                </select>
                            </div>

                            <!-- Input Kata Kunci & Tombol Search -->
                            <div class="input-group input-group-sm w-100">
                                <input type="text" name="query" class="form-control py-2 py-md-1" placeholder="Kata kunci..." value="{{ request('query') }}" style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;">
                                <button type="submit" class="btn btn-primary px-3" style="border-top-right-radius: 6px; border-bottom-right-radius: 6px; background-color: #007bff;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Populer / Hasil Pencarian -->
    <div class="container mb-5">
        <h3 class="text-center fw-bold mb-5" style="color: #001f3f;">
            {{ (isset($isSearch) && $isSearch) ? 'Hasil Pencarian' : 'Populer' }}
        </h3>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                @php $docs = (isset($isSearch) && $isSearch) ? $searchResults : $topViewedDocuments; @endphp

                @forelse ($docs as $doc)
                <div class="doc-card">
                    <div class="row align-items-start">
                        <!-- Gambar -->
                        <div class="col-md-3 col-sm-4 text-center">
                            <div class="img-cover-wrapper">
                                @php
                                $img = ($doc->category->category_name == 'Poster' && $doc->file_url)
                                ? asset('storage/' . $doc->file_url)
                                : ($doc->cover_image ? asset('storage/' . $doc->cover_image) : asset('assets/img/undraw_posting_photo.svg'));
                                @endphp
                                <img src="{{ $img }}" class="img-cover shadow-sm">
                            </div>
                        </div>
                        <!-- Info -->
                        <div class="col-md-9 col-sm-8">
                            <a href="{{ route('documents.readonly', $doc->id) }}" class="text-title">{{ $doc->title }}</a>
                            <div class="info-row"><span class="info-label">Jenis:</span><span class="info-value">{{ $doc->category->category_name }}</span></div>
                            <div class="info-row"><span class="info-label">Pembuat:</span><span class="info-value">{{ $doc->author }}</span></div>
                            <div class="info-row"><span class="info-label">Tahun:</span><span class="info-value">{{ $doc->year_published }}</span></div>

                            @if($doc->abstract)
                            <div class="info-row d-none d-md-flex mt-2">
                                <span class="info-label">Abstrak:</span>
                                <span class="info-value small text-muted">{{ Str::limit($doc->abstract, 160) }}</span>
                            </div>
                            @endif

                            <div class="info-row mt-2"><span class="info-label">Dilihat:</span><span class="info-value">{{ $doc->views }} kali</span></div>
                            <div class="info-row">
                                <span class="info-label">Konten Digital:</span>
                                <span class="info-value"><a href="{{ route('documents.readonly', $doc->id) }}" class="text-primary text-decoration-underline">Lihat File</a></span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <p class="text-muted">Tidak ditemukan dokumen.</p>
                    <a href="{{ url('/') }}" class="btn btn-outline-primary btn-sm">Refresh</a>
                </div>
                @endforelse

                <div class="text-center mt-5">
                    <a href="{{ route('collectionall') }}" class="btn btn-navy px-5 rounded-pill shadow-sm">Lihat Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Kategori Unggulan -->
    <div class="container my-5 pb-5">
        <h3 class="text-center fw-bold mb-5" style="color: #001f3f;">Kategori Unggulan</h3>
        <div class="row g-4 justify-content-center">
            @php
            $cats = [
            ['Karya Tulis Ilmiah', 'fas fa-file-contract'],
            ['Poster', 'fas fa-image'],
            ['Penelitian Eksternal', 'fas fa-flask'],
            ['Penelitian Internal', 'fas fa-microscope'],
            ['E-Book', 'fas fa-book-open']
            ];
            @endphp

            @foreach($cats as $c)
            <div class="col-6 col-md-4 col-lg-2">
                <div class="cat-card shadow-sm">
                    <div>
                        <i class="{{ $c[1] }} cat-icon"></i>
                        <p class="fw-bold small mb-3">{{ $c[0] }}</p>
                    </div>
                    <a href="{{ route('collection', $c[0]) }}" class="btn btn-navy btn-sm w-100">Lihat Koleksi</a>
                </div>
            </div>
            @endforeach

            <!-- Tombol Lihat Semua Kategori -->
            <div class="text-center mt-4">
                <a href="{{ route('categoryCollection') }}" class="btn btn-navy btn-lg">
                    <i class="fas fa-th-large me-2"></i>Lihat Semua Kategori
                </a>
            </div>

        </div>
    </div>

    <!-- Footer -->
    @include('view component.footerWelcome')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>