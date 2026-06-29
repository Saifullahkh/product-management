<header class="topbar">
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-icon border-0 d-inline-flex align-items-center justify-content-center" id="sidebarToggle" type="button">
            <i class="bi bi-list fs-5 text-dark"></i>
        </button>
    </div>
    <div class="ms-auto d-flex align-items-center gap-3">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle px-2 py-1 rounded-3 hover-bg-light" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=fff" alt="User" class="rounded-circle" width="32" height="32">
                <span class="d-none d-sm-inline fw-medium text-dark small">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 mt-2" aria-labelledby="userDropdown">
                <li><a class="dropdown-item py-2 d-flex align-items-center gap-2" href="#"><i class="bi bi-person"></i> Profile</a></li>
                <li><a class="dropdown-item py-2 d-flex align-items-center gap-2" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                <li><hr class="dropdown-item-divider"></li>
                <li><a class="dropdown-item py-2 d-flex align-items-center gap-2 text-danger" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right"></i> Sign Out</a></li>
            </ul>
        </div>
    </div>
</header>