<aside id="sidebar">
    <div class="sidebar-header d-flex align-items-center justify-content-between">
        <a href="{{ route('welcome') }}" class="d-flex align-items-center text-decoration-none">
            <img src="{{ asset('storage/uploads/logo.png') }}" width="150px" alt="">
        </a>
        <button class="btn d-md-none p-0 border-0" id="sidebarClose">
            <i class="bi bi-x-lg fs-5"></i>
        </button>
    </div>
    
    <div class="sidebar-content">
        @php
            $sidebarUser   = auth()->user();
            $isAdmin       = $sidebarUser && $sidebarUser->hasRole('Admin');
            $isEnterprise  = !$isAdmin && $sidebarUser && $sidebarUser->hasRole('Enterprise User');
            $isProBusiness = !$isAdmin && !$isEnterprise && $sidebarUser && $sidebarUser->hasRole('Pro Business User');
            $isBasic       = !$isAdmin && !$isEnterprise && !$isProBusiness && $sidebarUser && $sidebarUser->hasRole('Basic User');
            $isDropdownActive = request()->routeIs('users*') || request()->routeIs('roles-index*');
        @endphp

        <div class="text-uppercase text-muted extra-small fw-bold mb-3 px-3" style="font-size: 0.7rem; letter-spacing: 0.05rem;">Main Menu</div>
        <nav class="nav flex-column gap-1">

            <a href="{{ route('welcome') }}" class="nav-link {{ request()->routeIs('welcome') ? 'active' : '' }}">
                <i class="bi bi-columns-gap"></i>
                <span>Dashboard</span>
            </a>

            @canany(['view products', 'create products', 'edit products', 'delete products'])
            <a href="{{ route('products') }}" class="nav-link {{ request()->routeIs('products') ? 'active' : '' }}">
                <i class="bi bi-bag-plus"></i>
                <span>Products</span>
            </a>
            @endcan

            @can('view categories')
            <a href="{{ route('categories') }}" class="nav-link {{ request()->routeIs('categories') ? 'active' : '' }}">
                <i class="bi bi-tags"></i>
                <span>Categories</span>
            </a>
            @endcan

            @if($isAdmin)
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ $isDropdownActive ? 'active show' : '' }}" 
                    href="#" id="rolePermissionDropdown" role="button" 
                    data-bs-toggle="dropdown" data-bs-auto-close="outside" 
                    aria-expanded="{{ $isDropdownActive ? 'true' : 'false' }}">
                    <i class="bi bi-shield-lock"></i>
                    <span>Configuration</span>
                </a>
                <ul class="dropdown-menu border-0 {{ $isDropdownActive ? 'show' : '' }}" 
                    aria-labelledby="rolePermissionDropdown"
                    data-bs-popper="{{ $isDropdownActive ? 'static' : '' }}">
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('roles-index') ? 'active' : '' }}" href="{{ route('roles-index') }}">
                            <i class="bi bi-person me-2"></i> Role & Permission
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request()->routeIs('users') ? 'active' : '' }}" href="{{ route('users') }}">
                            <i class="bi bi-people me-2"></i> Users
                        </a>
                    </li>
                </ul>
            </div>
            @endif

        </nav>

        <div class="position-absolute bottom-0 d-flex align-items-center justify-content-between p-1" 
            style="width: calc(100% - 24px); left: 12px; bottom: 12px !important;">
            
            <div class="d-flex align-items-center gap-2">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($sidebarUser->name) }}&background=4f46e5&color=fff" alt="User" class="rounded-circle" width="32" height="32">
                <div class="d-flex flex-column align-items-start">
                    <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.875rem; letter-spacing: -0.1px; line-height: 1.2;">{{ $sidebarUser->name }}</h6>
                    @if($isAdmin)
                        <span class="badge mt-1 fw-semibold" style="font-size: 0.7rem; background-color: #fde8e8; color: #c0392b;">Admin</span>
                    @elseif($isEnterprise)
                        <span class="badge mt-1 fw-semibold" style="font-size: 0.7rem; background-color: #e2e3e5; color: #1c1f23;">Enterprise</span>
                    @elseif($isProBusiness)
                        <span class="badge mt-1 fw-semibold" style="font-size: 0.7rem; background-color: #e7f1ff; color: #0d6efd;">Pro Business</span>
                    @elseif($isBasic)
                        <span class="badge mt-1 fw-semibold" style="font-size: 0.7rem; background-color: #f1f3f5; color: #495057;">Basic</span>
                    @else
                        <span class="badge mt-1 fw-semibold" style="font-size: 0.7rem; background-color: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0;">Free Plan</span>
                    @endif
                </div>
            </div>

            <div>
                <a href="{{ route('pricing') }}" class="btn btn-sm btn-primary rounded-pill px-3 py-2 fw-bold text-decoration-none custom-upgrade-btn" 
                    style="font-size: 0.65rem; background: #0d6efd; border: none;">
                    Upgrade
                </a>
            </div>
        </div>
    </div>
</aside>

<style>
    .custom-upgrade-btn:hover {
        background-color: #0b5ed7 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2) !important;
    }
</style>
