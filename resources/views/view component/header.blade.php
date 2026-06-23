<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <ul class="navbar-nav ml-auto">

        <li class="nav-item d-flex align-items-center">
            @auth
                <span class="mr-3 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
            @endauth
            {{-- Tombol trigger modal, bukan submit form --}}
            <button type="button" class="btn btn-sm btn-light" title="Logout" 
                    data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-power-off text-danger"></i>
            </button>
        </li>

    </ul>

</nav>

{{-- Modal konfirmasi logout --}}
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Logout</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin keluar dari sesi ini?
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-power-off mr-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>