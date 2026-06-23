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
            padding: 15px;
            margin-top: -40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        /* --- List Dokumen (Sesuai Desain Welcome) --- */
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
            max-width: 140px;
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

        .btn-navy {
            background-color: #001f3f;
            color: white;
            border: none;
            font-size: 0.85rem;
            padding: 8px 20px;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .info-label {
                width: 90px;
            }

            .img-cover-wrapper {
                margin-bottom: 15px;
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
                <p class="opacity-75">Menampilkan koleksi terbaik untuk kategori {{ ucfirst(str_replace('_', ' ', $category->category_name)) }}.</p>
            </div>
        </div>

        <!-- Search Bar (Sesuai Permintaan Mobile Terakhir) -->
        <div class="container mb-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="search-container" style="margin-top: 10px;">
                        <form action="{{ route('collectionall') }}" method="GET">
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-center gap-3">

                                <div class="text-center text-md-start">
                                    <span class="text-white fw-bold fs-6">Cari</span>
                                </div>

                                <div class="w-100 w-md-auto">
                                    <select name="search_by" class="form-select form-select-sm py-2 py-md-1"
                                        style="width: 100%; min-width: 120px;">
                                        <option value="judul" {{ request('search_by') == 'judul'   ? 'selected' : '' }}>Judul</option>
                                        <option value="penulis" {{ request('search_by') == 'penulis' ? 'selected' : '' }}>Pembuat</option>
                                        <option value="tahun" {{ request('search_by') == 'tahun'   ? 'selected' : '' }}>Tahun</option>
                                    </select>
                                </div>

                                <div class="d-none d-md-block">
                                    <span class="text-white fw-medium">berdasarkan</span>
                                </div>

                                {{-- Dropdown kategori dinamis --}}
                                <div class="w-100 w-md-auto">
                                    <select name="category" class="form-select form-select-sm py-2 py-md-1"
                                        style="width: 100%; min-width: 180px;">
                                        <option value="">Semua Kategori</option>
                                        @foreach($categories as $cat)
                                        <option value="{{ $cat->category_name }}"
                                            {{ request('category') == $cat->category_name ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $cat->category_name)) }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="input-group input-group-sm w-100">
                                    <input type="text" name="query" class="form-control py-2 py-md-1"
                                        placeholder="Kata kunci..." value="{{ request('query') }}">
                                    <button type="submit" class="btn btn-primary px-3">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>

                                @if(request('sort_by'))
                                <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                                @endif

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents List -->
        <div class="container mb-5">
            <div class="row">
                <div class="col-12 d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold m-0" style="color: #001f3f;">Daftar Koleksi</h3>

                    <!-- Dropdown Sortir -->
                    @php
                    $sortOptions = [
                    'tahun_desc' => ['icon' => 'fas fa-calendar-alt', 'label' => 'Terbaru'],
                    'tahun_asc' => ['icon' => 'fas fa-calendar', 'label' => 'Terlama'],
                    'judul_asc' => ['icon' => 'fas fa-sort-alpha-down', 'label' => 'A - Z'],
                    'views' => ['icon' => 'fas fa-eye', 'label' => 'Terpopuler'],
                    ];
                    $currentSort = request('sort_by') ?: 'tahun_desc';
                    @endphp
                    <div class="dropdown">
                        <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="{{ $sortOptions[$currentSort]['icon'] }} me-1"></i> {{ $sortOptions[$currentSort]['label'] }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @foreach ($sortOptions as $key => $option)
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort_by' => $key]) }}">{{ $option['label'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                @if ($documents->count() > 0)
                <div class="row">
                    @foreach ($documents as $doc)
                    <div class="col-lg-6">
                        <div class="doc-card">
                            <div class="row align-items-start">
                                <div class="col-md-3 col-4 text-center">
                                    <div class="img-cover-wrapper">
                                        @php
                                        $img = ($doc->category->category_name == 'Poster' && $doc->file_url)
                                        ? asset('storage/' . $doc->file_url)
                                        : ($doc->cover_image ? asset('storage/' . $doc->cover_image) : asset('assets/img/undraw_posting_photo.svg'));
                                        @endphp
                                        <img src="{{ $img }}" class="img-cover shadow-sm">
                                    </div>
                                </div>
                                <div class="col-md-9 col-8">
                                    <a href="{{ route('documents.readonly', $doc->id) }}" class="text-title">{{ $doc->title }}</a>
                                    <div class="info-row"><span class="info-label">Kategori:</span><span class="info-value">{{ $doc->category->category_name }}</span></div>
                                    <div class="info-row"><span class="info-label">Pembuat:</span><span class="info-value">{{ $doc->author }}</span></div>
                                    <div class="info-row"><span class="info-label">Tahun:</span><span class="info-value">{{ $doc->year_published }}</span></div>
                                    @if($doc->abstract)
                                    <div class="info-row d-none d-md-flex mt-2">
                                        <span class="info-label">Abstrak:</span>
                                        <span class="info-value small text-muted">{{ Str::limit($doc->abstract, 160) }}</span>
                                    </div>
                                    @endif
                                    <div class="info-row"><span class="info-label">Dilihat:</span><span class="info-value">{{ $doc->views }} kali</span></div>
                                    <div class="info-row">
                                        <span class="info-label">Konten:</span>
                                        <span class="info-value"><a href="{{ route('documents.readonly', $doc->id) }}" class="text-primary text-decoration-underline">Lihat File</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $documents->links('pagination::bootstrap-5') }}
                </div>
                @else
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada dokumen dalam kategori ini.</p>
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