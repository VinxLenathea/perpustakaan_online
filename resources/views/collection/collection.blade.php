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

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold">Koleksi {{ ucfirst(str_replace('_', ' ', $category->category_name)) }}</h1>
            <p class="lead">Temukan koleksi {{ ucfirst(str_replace('_', ' ', $category->category_name)) }} terlengkap
                untuk mendukung pembelajaran dan penelitian Anda.</p>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('collection', $category->category_name) }}" method="GET"
                    class="d-flex flex-wrap align-items-center justify-content-center bg-light p-3 rounded">
                    <span class="me-2">Cari</span>
                    <select name="filter" class="form-select form-select-sm me-2" style="width: auto;">
                        <option value="judul" {{ request('filter') == 'judul' ? 'selected' : '' }}>Judul</option>
                        <option value="penulis" {{ request('filter') == 'penulis' ? 'selected' : '' }}>Pembuat</option>
                        <option value="tahun" {{ request('filter') == 'tahun' ? 'selected' : '' }}>Tahun</option>
                    </select>
                    <span class="me-2">berdasarkan</span>
                    <input type="text" name="keyword" class="form-control form-control-sm me-2"
                        placeholder="Kata kunci..." value="{{ request('keyword') }}" style="max-width: 200px;">
                    <button class="btn btn-success btn-sm" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Documents List -->
    <div class="container my-4">
        <h2 class="text-center mb-4 text-success">Daftar {{ ucfirst(str_replace('_', ' ', $category->category_name)) }}
        </h2>
        @if ($documents->count() > 0)
            <div class="row flex-grow-1">
                @php
                    $sortOptions = [
                        'tahun_desc' => ['icon' => 'fas fa-calendar-alt', 'label' => 'Tahun Terbaru'],
                        'tahun_asc' => ['icon' => 'fas fa-calendar', 'label' => 'Tahun Terlama'],
                        'judul_asc' => ['icon' => 'fas fa-sort-alpha-down', 'label' => 'A - Z'],
                        'judul_desc' => ['icon' => 'fas fa-sort-alpha-up', 'label' => 'Z - A'],
                        'views' => ['icon' => 'fas fa-eye', 'label' => 'Paling Sering Dibaca'],
                    ];
                    $currentSort = request('sort_by') ?: 'tahun_desc';
                @endphp
                <div class="d-flex align-items-center mb-3">
                    <label class="me-2 fw-bold">Urutkan:</label>
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle" type="button" id="sortDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="{{ $sortOptions[$currentSort]['icon'] }}"></i>
                            {{ $sortOptions[$currentSort]['label'] }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                            @foreach ($sortOptions as $key => $option)
                                <li><a class="dropdown-item {{ $key == $currentSort ? 'active' : '' }}"
                                        href="{{ route('collection', $category->category_name) . '?' . http_build_query(array_merge(request()->query(), ['sort_by' => $key])) }}"><i
                                            class="{{ $option['icon'] }}"></i> {{ $option['label'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @foreach ($documents as $doc)
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm border-0 rounded-3 card-hover d-flex flex-row h-100">
                            <div class="col-md-3 d-flex align-items-stretch p-0">
                                @if ($doc->category->category_name == 'Poster')
                                    @if ($doc->file_url && in_array(pathinfo($doc->file_url, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'gif']))
                                        <img src="{{ asset('storage/' . $doc->file_url) }}"
                                            class="img-fluid rounded-start h-100 object-fit-cover"
                                            alt="Cover {{ $doc->title }}">
                                    @else
                                        <img src="{{ asset('assets/img/undraw_posting_photo.svg') }}"
                                            class="img-fluid rounded-start h-100 object-fit-cover"
                                            alt="Cover {{ $doc->title }}">
                                    @endif
                                @else
                                    @if ($doc->cover_image)
                                        <img src="{{ asset('storage/' . $doc->cover_image) }}"
                                            class="img-fluid rounded-start h-100 object-fit-cover"
                                            alt="Cover {{ $doc->title }}">
                                    @else
                                        <img src="{{ asset('assets/img/undraw_posting_photo.svg') }}"
                                            class="img-fluid rounded-start h-100 object-fit-cover"
                                            alt="Cover {{ $doc->title }}">
                                    @endif
                                @endif
                            </div>
                            <div class="col-md-9 d-flex flex-column">
                                <div class="card-body d-flex flex-column flex-grow-1">
                                    <h4 class="card-title text-danger fw-bold mb-3">{{ $doc->title }}</h4>
                                    <p class="mb-1"><strong>Pembuat:</strong> {{ $doc->author }}</p>
                                    <p class="mb-1"><strong>Tahun:</strong> {{ $doc->year_published }}</p>
                                    @if ($doc->abstract)
                                        <p class="mb-1 text-truncate" style="max-height: 3.6em; overflow: hidden;">
                                            <strong>Abstrak:</strong> {{ $doc->abstract }}
                                        </p>
                                    @endif
                                    <p class="mb-1"><strong>Dilihat:</strong> {{ $doc->views }} kali</p>
                                    <p class="mb-2">
                                        <strong>Konten Digital:</strong>
                                        <a href="{{ route('documents.readonly', $doc->id) }}" class="text-primary">Lihat File</a>

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

    <!-- Footer -->
    @include('view component.footerWelcome')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
