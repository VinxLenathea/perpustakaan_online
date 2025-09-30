@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    <style>
        .navbar-custom {
            background-color: #001f3f !important;
            /* Navy utama */
        }

        .navbar-custom .nav-link {
            color: #FED16A !important;
        }

        .navbar-custom .dropdown-menu {
            background-color: #002147;
            /* Navy lebih terang */
        }

        .navbar-custom .dropdown-item {
            color: #FED16A;
        }

        .navbar-custom .dropdown-item:hover {
            background-color: #001633;
            /* Hover lebih gelap */
        }

        .search-bar {
            background-color: #001f3f;
            /* Navy utama */
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
            background-color: #001f3f;
            /* Tombol navy */
            border-color: #001f3f;
        }

        .btn-success:hover {
            background-color: #001633;
            /* Hover navy */
            border-color: #001633;
        }

        .text-success {
            color: #001f3f !important;
            /* Ikon & teks jadi navy */
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

        footer {
            position: relative;
        }
    </style>
@endif
