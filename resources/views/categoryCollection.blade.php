<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Semua Kategori - {{ config('app.name', 'Perpustakaan Online') }}</title>

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
            <h1 class="display-4 fw-bold">Semua Kategori Koleksi</h1>
            <p class="lead">Temukan semua koleksi kategori terlengkap untuk mendukung pembelajaran dan penelitian
                Anda.</p>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="container my-4">
        <h2 class="text-center mb-4 text-success">Kategori Tersedia</h2>
        <div class="row justify-content-center">
            @php
                $categories = \App\Models\CategoryModel::all();
            @endphp

            @foreach ($categories as $category)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card card-hover text-center h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <i class="fas fa-folder fa-3x text-success mb-3"></i>
                            <h5 class="card-title">{{ ucfirst(str_replace('_', ' ', $category->category_name)) }}</h5>
                            <p class="card-text flex-grow-1">
                                @php
                                    $documentCount = \App\Models\DocumentModel::where(
                                        'category_id',
                                        $category->id,
                                    )->count();
                                @endphp
                                {{ $documentCount }} dokumen tersedia
                            </p>
                            <a href="{{ route('collection', $category->category_name) }}"
                                class="btn btn-success mt-auto">Lihat Koleksi</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Footer -->
    @include('view component.footerWelcome')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
