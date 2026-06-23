@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
@vite(['resources/css/app.css', 'resources/js/app.js'])
@else
<style>
    /* --- Warna Utama & Navbar --- */
    .navbar-custom {
        background-color: #001f3f !important;
    }

    .navbar-custom .nav-link {
        color: #FED16A !important;
    }

    .navbar-custom .dropdown-menu {
        background-color: #002147;
    }

    .navbar-custom .dropdown-item {
        color: #FED16A;
    }

    .navbar-custom .dropdown-item:hover {
        background-color: #001633;
    }

    /* --- Search Bar Container --- */
    .search-bar {
        background-color: #001f3f;
        padding: 20px;
        margin: 20px 0;
        border-radius: 8px;
    }

    .top-bar {
        background-color: #f8f9fa;
        padding: 10px 20px;
        border-bottom: 1px solid #dee2e6;
    }

    /* --- Buttons & Text --- */
    .btn-success {
        background-color: #001f3f;
        border-color: #001f3f;
    }

    .btn-success:hover {
        background-color: #001633;
        border-color: #001633;
    }

    .text-success {
        color: #001f3f !important;
    }

    /* --- Hero Section --- */
    .hero-section {
        background: linear-gradient(135deg, #001f3f 0%, #002147 100%);
        color: white;
        padding: 60px 0;
        text-align: center;
    }

    /* --- Layout & Cards --- */
    .featured-grid {
        padding: 40px 0;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
    }

    .logo-img {
        max-width: 80px;
        height: auto;
    }

    /* Memastikan gambar cover tetap proporsional */
    .cover-img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 8px;
    }

    /* --- Sticky Footer Logic --- */
    html,
    body {
        min-height: 100vh;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    body>footer {
        margin-top: auto;
    }

    /* --- Pagination Theme --- */
    .pagination .page-link {
        color: #001f3f;
        border-color: #001f3f;
    }

    .pagination .page-item.active .page-link {
        background-color: #001f3f;
        border-color: #001f3f;
        color: white;
    }

    /* ============================================= */
    /*    PENAMBAHAN CSS RESPONSIVE (MEDIA QUERIES)  */
    /* ============================================= */

    @media (max-width: 768px) {
        .hero-section {
            padding: 40px 15px;
        }

        .hero-section h1 {
            font-size: 1.75rem;
            /* Ukuran judul lebih kecil di HP */
        }

        .hero-section p {
            font-size: 1rem;
        }

        .search-bar {
            padding: 15px;
            margin: 10px;
        }

        /* Membuat form pencarian lebih rapi di HP */
        .search-bar form {
            gap: 10px;
        }

        .search-bar select,
        .search-bar input {
            width: 100% !important;
            /* Full width di layar kecil */
            max-width: none !important;
        }

        .search-bar span {
            display: none;
            /* Sembunyikan kata "Cari" & "berdasarkan" di HP agar ringkas */
        }

        /* Pengaturan Kartu Dokumen di Mobile */
        .card .row {
            text-align: center;
            /* Tengahkan teks di mobile */
        }

        .cover-img {
            height: 200px;
            /* Perkecil tinggi gambar di mobile */
            margin-bottom: 15px;
        }

        /* Atur grid kategori agar tidak terlalu lebar */
        .featured-grid .card {
            margin-bottom: 20px;
        }
    }

    /* Untuk layar sangat kecil (Foldable/Small Phones) */
    @media (max-width: 480px) {
        .display-4 {
            font-size: 1.5rem !important;
        }

        .btn-lg {
            width: 100%;
            /* Tombol "Lihat Semua" jadi full width */
        }
    }

    /* Container gambar agar tetap proporsional */
    .img-container {
        width: 100%;
        aspect-ratio: 3 / 4;
        /* Rasio buku/dokumen */
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        border-radius: 8px;
    }

    .cover-img-fixed {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Gambar akan memenuhi kotak tanpa gepeng */
    }

    /* Judul maksimal 2 baris */
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        font-size: 1rem;
        line-height: 1.3;
    }

    /* Meta info (penulis, tahun) */
    .info-meta .badge {
        font-weight: 500;
        font-size: 0.7rem;
    }

    .small {
        font-size: 0.75rem !important;
    }

    /* Hilangkan abstrak di HP agar ringkas */
    @media (max-width: 768px) {
        .text-truncate-2 {
            font-size: 0.9rem;
        }

        .card-doc {
            padding: 10px !important;
        }
    }
</style>
@endif