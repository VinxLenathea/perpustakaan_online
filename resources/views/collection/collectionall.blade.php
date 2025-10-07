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
    @include('styleUserPage')

</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18]">

    <!-- Top Bar -->
    @include('view component.headerWelcome')

    <main class="flex-grow-1 d-flex flex-column">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="container">
                <h1 class="display-4 fw-bold">Koleksi {{ ucfirst(str_replace('_', ' ', $category->category_name)) }}</h1>
                <p class="lead">Temukan koleksi {{ ucfirst(str_replace('_', ' ', $category->category_name)) }} terlengkap untuk mendukung pembelajaran dan penelitian Anda.</p>
            </div>
        </div>

   <!-- Search Section -->
<div class="container-fluid">
    <div class="row search-bar">
        <div class="col-12 col-md-8 mx-auto">
            <form class="d-flex flex-wrap align-items-center justify-content-center text-white"
                  action="{{ route('collectionall') }}" method="GET">

                <span class="me-2">Cari</span>

                <select class="form-select form-select-sm me-2 mb-2 mb-md-0" name="search_by" style="width: auto;">
                    <option value="judul" {{ request('search_by') == 'judul' ? 'selected' : '' }}>Judul</option>
                    <option value="penulis" {{ request('search_by') == 'penulis' ? 'selected' : '' }}>Penulis</option>
                    <option value="tahun" {{ request('search_by') == 'tahun' ? 'selected' : '' }}>Tahun</option>
                </select>

                <span class="me-2">berdasarkan</span>

                <select class="form-select form-select-sm me-2 mb-2 mb-md-0" name="category" style="width: auto;">
                    <option value="">Semua Kategori</option>
                    <option value="karya_tulis_ilmiah" {{ request('category') == 'karya_tulis_ilmiah' ? 'selected' : '' }}>Karya Tulis Ilmiah</option>
                    <option value="poster" {{ request('category') == 'poster' ? 'selected' : '' }}>Poster</option>
                    <option value="penelitian_eksternal" {{ request('category') == 'penelitian_eksternal' ? 'selected' : '' }}>Penelitian Eksternal</option>
                    <option value="penelitian_internal" {{ request('category') == 'penelitian_internal' ? 'selected' : '' }}>Penelitian Internal</option>
                </select>

                <input type="text"
       class="form-control form-control-sm me-2"
       name="query"
       placeholder="Kata kunci..."
       value="{{ request('query') }}"
       style="max-width: 200px;">

                <button class="btn btn-outline-light mb-2 mb-md-0" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
</div>

        <!-- Documents List -->
        <div class="container my-4 flex-grow-1 d-flex flex-column">
            <h2 class="text-center mb-4 text-success">Daftar {{ ucfirst(str_replace('_', ' ', $category->category_name)) }}</h2>
            @if($documents->count() > 0)
                <div class="row flex-grow-1">
                    @foreach($documents as $doc)
                        <div class="col-md-6 mb-4 d-flex">
                            <div class="card shadow-sm border-0 rounded-3 card-hover d-flex flex-row h-100 w-100">
                                <div class="col-md-3 d-flex align-items-stretch p-0">
                                    @if($doc->category->category_name == 'poster')
                                        @if($doc->file_url && in_array(pathinfo($doc->file_url, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'gif']))
                                            <img src="{{ asset('storage/' . $doc->file_url) }}" class="img-fluid rounded-start h-100 object-fit-cover" alt="Cover {{ $doc->title }}">
                                        @else
                                            <img src="{{ asset('assets/img/undraw_posting_photo.svg') }}" class="img-fluid rounded-start h-100 object-fit-cover" alt="Cover {{ $doc->title }}">
                                        @endif
                                    @else
                                        @if($doc->cover_image)
                                            <img src="{{ asset('storage/' . $doc->cover_image) }}" class="img-fluid rounded-start h-100 object-fit-cover" alt="Cover {{ $doc->title }}">
                                        @else
                                            <img src="{{ asset('assets/img/undraw_posting_photo.svg') }}" class="img-fluid rounded-start h-100 object-fit-cover" alt="Cover {{ $doc->title }}">
                                        @endif
                                    @endif
                                </div>
                                <div class="col-md-9 d-flex flex-column">
                                    <div class="card-body d-flex flex-column flex-grow-1">
                                        <h4 class="card-title text-danger fw-bold mb-3">{{ $doc->title }}</h4>
                                        <p class="mb-1"><strong>Pengarang:</strong> {{ $doc->author }}</p>
                                        <p class="mb-1"><strong>Tahun Terbit:</strong> {{ $doc->year_published }}</p>
                                        @if($doc->abstract)
                                            <p class="mb-1 text-truncate" style="max-height: 3.6em; overflow: hidden;"><strong>Abstrak:</strong> {{ $doc->abstract }}</p>
                                        @endif
                                        <p class="mb-3 mt-auto">
                                            <strong>Konten Digital:</strong>
                                            <a href="{{ asset('storage/' . $doc->file_url) }}" target="_blank" class="text-primary fw-semibold">Lihat File</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $documents->links('pagination::bootstrap-5') }}
            @else
                <div class="text-center">
                    <p class="text-muted">Belum ada dokumen dalam kategori ini.</p>
                </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    @include('view component.footerWelcome')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
