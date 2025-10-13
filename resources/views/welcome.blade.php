<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Perpustakaan Online') }}</title

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <!-- Styles -->
    @include('styleUserPage')
</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18]">

    <!-- Top Bar -->
    @include('view component.headerWelcome')

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold">Selamat Datang di Perpustakaan Online RSMN</h1>
            <p class="lead">Temukan koleksi buku, jurnal, dan dokumen ilmiah terlengkap untuk mendukung pembelajaran
                dan penelitian Anda.</p>

        </div>
    </div>

    <!-- Search Section -->
    <div class="container-fluid">
        <div class="row search-bar">
            <div class="col-12 col-md-8 mx-auto">
                <form class="d-flex flex-wrap align-items-center justify-content-center text-white"
                    action="{{ url('/') }}" method="GET">

                    <span class="me-2">Cari</span>

                    <select class="form-select form-select-sm me-2 mb-2 mb-md-0" name="search_by" style="width: auto;">
                        <option value="judul">Judul</option>
                        <option value="penulis">Penulis</option>
                        <option value="tahun">Tahun</option>
                    </select>

                    <span class="me-2">berdasarkan</span>

                    <select class="form-select form-select-sm me-2 mb-2 mb-md-0" name="category" style="width: auto;">
                        <option value="">Semua Kategori</option>
                        <option value="karya_tulis_ilmiah"
                            {{ request('category') == 'karya_tulis_ilmiah' ? 'selected' : '' }}>Karya Tulis Ilmiah
                        </option>
                        <option value="Poster" {{ request('category') == 'poster' ? 'selected' : '' }}>Poster</option>
                        <option value="penelitian_eksternal"
                            {{ request('category') == 'penelitian_eksternal' ? 'selected' : '' }}>Penelitian Eksternal
                        </option>
                        <option value="penelitian_internal"
                            {{ request('category') == 'penelitian_internal' ? 'selected' : '' }}>Penelitian Internal
                        </option>
                    </select>

                    <input type="text" class="form-control form-control-sm me-2" name="query"
                        placeholder="Kata kunci..." value="{{ request('query') }}" style="max-width: 200px;">

                    <button class="btn btn-outline-light mb-2 mb-md-0" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>


    <!-- Buku Unggulan / Hasil Pencarian -->
    <!-- Baru Ditambahkan -->
    <div class="container my-4">
        <h2 class="text-center mb-4 text-success">
            @if (isset($isSearch) && $isSearch)
                Hasil Pencarian
            @else
                Baru Ditambahkan
            @endif
        </h2>

        @if (isset($isSearch) && $isSearch)
            @if ($searchResults->count() > 0)
                @foreach ($searchResults as $doc)
                    <div class="card shadow-sm border-0 rounded-3 mb-3 p-3">
                        <div class="row g-3 align-items-center">
                            <!-- Cover Buku -->
                            <div class="col-md-3 col-12 text-center">
                                @if ($doc->category->category_name == 'Poster')
                                    @if ($doc->file_url && in_array(pathinfo($doc->file_url, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'gif']))
                                        <img src="{{ asset('storage/' . $doc->file_url) }}"
                                            class="img-fluid rounded shadow-sm" alt="Cover {{ $doc->title }}"
                                            style="max-height: 220px; object-fit: cover;">
                                    @else
                                        <img src="assets/img/undraw_posting_photo.svg"
                                            class="img-fluid rounded shadow-sm" alt="Cover {{ $doc->title }}"
                                            style="max-height: 220px; object-fit: cover;">
                                    @endif
                                @else
                                    @if ($doc->cover_image)
                                        <img src="{{ asset('storage/' . $doc->cover_image) }}"
                                            class="img-fluid rounded shadow-sm" alt="Cover {{ $doc->title }}"
                                            style="max-height: 220px; object-fit: cover;">
                                    @else
                                        <img src="assets/img/undraw_posting_photo.svg"
                                            class="img-fluid rounded shadow-sm" alt="Cover {{ $doc->title }}"
                                            style="max-height: 220px; object-fit: cover;">
                                    @endif
                                @endif
                            </div>

                            <!-- Detail Buku -->
                            <div class="col-md-9 col-12">
                                <h5 class="fw-bold text-danger mb-2" style="font-size: 1.2rem;">
                                    {{ $doc->title }}
                                </h5>
                                <p class="mb-1"><strong>Jenis:</strong> {{ $doc->category->category_name }}</p>
                                <p class="mb-1"><strong>Penulis:</strong> {{ $doc->author }}</p>
                                <p class="mb-1"><strong>Tahun:</strong> {{ $doc->year_published }}</p>
                                @if ($doc->abstract)
                                    <p class="mb-2"><strong>Abstrak:</strong> {{ $doc->abstract }}</p>
                                @endif
                                <p class="mb-2">
                                    <strong>Konten Digital:</strong>
                                    <a href="{{ route('collection.view', $doc->id) }}" target="_blank"
                                            class="text-primary">Lihat File</a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $searchResults->links() }}
                </div>
            @else
                <div class="text-center">
                    <p class="text-muted">Tidak ada dokumen yang ditemukan untuk kriteria pencarian Anda.</p>
                    <a href="{{ url('/') }}" class="btn btn-success">Kembali ke Beranda</a>
                </div>
            @endif
        @else
            @if ($recentDocuments->count() > 0)
                @foreach ($recentDocuments as $doc)
                    <div class="card shadow-sm border-0 rounded-3 mb-3 p-3">
                        <div class="row g-3 align-items-center">
                            <!-- Cover Buku -->
                            <div class="col-md-3 col-12 text-center">
                                @if ($doc->category->category_name == 'Poster')
                                    @if ($doc->file_url && in_array(pathinfo($doc->file_url, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'gif']))
                                        <img src="{{ asset('storage/' . $doc->file_url) }}"
                                            class="img-fluid rounded shadow-sm" alt="Cover {{ $doc->title }}"
                                            style="max-height: 220px; object-fit: cover;">
                                    @else
                                        <img src="assets/img/undraw_posting_photo.svg"
                                            class="img-fluid rounded shadow-sm" alt="Cover {{ $doc->title }}"
                                            style="max-height: 220px; object-fit: cover;">
                                    @endif
                                @else
                                    @if ($doc->cover_image)
                                        <img src="{{ asset('storage/' . $doc->cover_image) }}"
                                            class="img-fluid rounded shadow-sm" alt="Cover {{ $doc->title }}"
                                            style="max-height: 220px; object-fit: cover;">
                                    @else
                                        <img src="assets/img/undraw_posting_photo.svg"
                                            class="img-fluid rounded shadow-sm" alt="Cover {{ $doc->title }}"
                                            style="max-height: 220px; object-fit: cover;">
                                    @endif
                                @endif
                            </div>

                            <!-- Detail Buku -->
                            <div class="col-md-9 col-12">
                                <h5 class="fw-bold text-danger mb-2" style="font-size: 1.2rem;">
                                    {{ $doc->title }}
                                </h5>
                                <p class="mb-1"><strong>Jenis:</strong> {{ $doc->category->category_name }}</p>
                                <p class="mb-1"><strong>Penulis:</strong> {{ $doc->author }}</p>
                                <p class="mb-1"><strong>Tahun:</strong> {{ $doc->year_published }}</p>
                                @if ($doc->abstract)
                                    <p class="mb-2"><strong>Abstrak:</strong> {{ $doc->abstract }}</p>
                                @endif
                                <p class="mb-1"><strong>Dilihat:</strong> {{ $doc->views }} kali</p>
                                <p class="mb-2">
                                    <strong>Konten Digital:</strong>
                                    <a href="{{ route('collectionall.view', $doc->id) }}" target="_blank"
                                                class="text-primary">Lihat File</a>
                                </p>

                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="text-center mt-3">
                    <a href="{{ route('collectionall') }}" class="btn btn-success btn-lg">Lihat Lebih Banyak</a>
                </div>
            @else
                <div class="text-center">
                    <p class="text-muted">Belum ada dokumen yang ditambahkan.</p>
                </div>
            @endif
        @endif
    </div>


    <!-- Kategori Unggulan -->
    <div class="container featured-grid">
        <h2 class="text-center mb-4 text-success">Kategori Unggulan</h2>
        <div class="row">
            <!-- Item kategori -->
            <div class="col-md-3 mb-4">
                <div class="card card-hover text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-book fa-3x text-success mb-3"></i>
                        <h5>Karya Tulis Ilmiah</h5>
                        <p>Koleksi penelitian dan artikel ilmiah terbaru.</p>
                        <a href="{{ route('collection', 'Karya Tulis Ilmiah') }}" class="btn btn-success">Lihat
                            Koleksi</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card card-hover text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-image fa-3x text-success mb-3"></i>
                        <h5>Poster</h5>
                        <p>Poster penelitian dan presentasi visual.</p>
                        <a href="{{ route('collection', 'Poster') }}" class="btn btn-success">Lihat Koleksi</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card card-hover text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-flask fa-3x text-success mb-3"></i>
                        <h5>Penelitian Eksternal</h5>
                        <p>Hasil penelitian dari kolaborasi eksternal.</p>
                        <a href="{{ route('collection', 'Penelitian Eksternal') }}" class="btn btn-success">Lihat
                            Koleksi</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card card-hover text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-microscope fa-3x text-success mb-3"></i>
                        <h5>Penelitian Internal</h5>
                        <p>Penelitian yang dilakukan secara internal.</p>
                        <a href="{{ route('collection', 'Penelitian Internal') }}" class="btn btn-success">Lihat
                            Koleksi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('view component.footerWelcome')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif

</body>

</html>
