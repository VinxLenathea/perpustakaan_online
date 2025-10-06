<div class="top-bar d-flex justify-content-between align-items-center">
    <!-- Logo kiri -->
    <div class="d-flex align-items-center">
        <img src="{{ asset('assets/img/logo rsmn.png') }}" alt="Logo Perpustakaan" class="img-fluid me-2"
            style="max-width: 80px; height: auto;">
        <h5 class="m-0 text-success">Perpustakaan online RSMN</h5>
    </div>

    <!-- Kontak & Login kanan -->
    <div class="d-flex align-items-center">
        <a href="#" class="me-3 text-decoration-none text-dark">
            <i class="fas fa-map-marker-alt me-1 text-success"></i> Jl. Bonorogo No.17 Pamekasan
        </a>
        <a href="tel:+6281234567890" class="me-3 text-decoration-none text-dark">
            <i class="fas fa-phone-alt me-1 text-success"></i> +62812-3079-7005
        </a>

        <!-- Login Button -->
        <a href="{{ route('login') }}" class="btn btn-success btn-sm">Login</a>
    </div>
</div>
