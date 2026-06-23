<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-2 sticky-top">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2 m-0" href="/">
            <img src="{{ asset('assets/img/logo rsmn.png') }}"
                alt="Logo RSMN"
                class="logo-img"
                style="width: 50px; height: auto; object-fit: contain;">

            <div class="d-flex flex-column lh-sm">
                <span class="fw-bold mb-0" style="font-size: 1rem; color: #001f5b;">Perpustakaan</span>
                <small class="text-muted" style="font-size: 0.8rem;">RSMN</small>
            </div>
        </a>

        <!-- Hamburger -->
        <button class="navbar-toggler border-0 shadow-none"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="fas fa-bars fs-4" style="color: #001f5b;"></i>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse mt-3 mt-lg-0" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">

                <!-- Address -->
                <li class="nav-item">
                    <a class="nav-link px-lg-3 text-dark small" href="#">
                        <i class="fas fa-map-marker-alt me-2" style="color: #001f5b;"></i>
                        Jl. Bonorogo No.17
                    </a>
                </li>

                <!-- Phone -->
                <li class="nav-item">
                    <a class="nav-link px-lg-3 text-dark small" href="tel:+6281230797005">
                        <i class="fas fa-phone-alt me-2" style="color: #001f5b;"></i>
                        +62 812-3079-7005
                    </a>
                </li>

                <!-- Login -->
                <li class="nav-item mt-2 mt-lg-0">
                    <a class="btn px-4 w-100 w-lg-auto text-white"
                        href="{{ route('login') }}"
                        style="background-color: #001f5b; border-color: #001f5b;">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>