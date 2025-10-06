<ul class="navbar-nav sidebar sidebar-light bg-white shadow-sm" id="accordionSidebar" style="min-height: 100vh;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center py-3 mb-3 border-bottom" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon text-primary">
            <i class="fas fa-book-reader fa-2x"></i>
        </div>
        <div class="sidebar-brand-text mx-2 text-primary fw-bold">Admin Perpustakaan</div>
    </a>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
        <a class="nav-link text-primary {{ Request::is('dashboard') ? 'fw-bold bg-light rounded' : '' }}" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt me-2 text-primary"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading text-secondary">Menu</div>

    <!-- Nav Item - Users -->
    <li class="nav-item {{ Request::is('users*') ? 'active' : '' }}">
        <a class="nav-link text-primary {{ Request::is('users*') ? 'fw-bold bg-light rounded' : '' }}" href="{{ route('users.index') }}">
            <i class="fas fa-users me-2 text-primary"></i>
            <span>Users</span>
        </a>
    </li>

    <!-- Nav Item - Library -->
    <li class="nav-item {{ Request::is('library*') ? 'active' : '' }}">
        <a class="nav-link text-primary {{ Request::is('library*') ? 'fw-bold bg-light rounded' : '' }}" href="{{ route('library') }}">
            <i class="fas fa-book me-2 text-primary"></i>
            <span>Library</span>
        </a>
    </li>

</ul>
