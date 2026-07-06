<x-layout>
    <x-slot name="main">
        @php
            $user = auth()->user();
            $isAdmin       = $user && $user->hasRole('Admin');
            $isEnterprise  = !$isAdmin && $user && $user->hasRole('Enterprise User');
            $isProBusiness = !$isAdmin && !$isEnterprise && $user && $user->hasRole('Pro Business User');
            $isBasic       = !$isAdmin && !$isEnterprise && !$isProBusiness && $user && $user->hasRole('Basic User');
            $hasPlan       = $isAdmin || $isBasic || $isProBusiness || $isEnterprise;
        @endphp

        @if($hasPlan)
            <div class="mb-4">
                <h1 class="h3 fw-bold text-dark mb-1">Dashboard</h1>
            </div>

            <div class="row g-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100 rounded-3">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2">
                                    <i class="bi bi-cart-check fs-4"></i>
                                </div>
                                <span class="text-muted small fw-medium">Total Products</span>
                            </div>
                            <h2 class="h3 mb-0 fw-bold text-dark">{{ $totalData }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100 rounded-3">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-2">
                                    <i class="bi bi-boxes fs-4"></i>
                                </div>
                                <span class="text-muted small fw-medium">Total Stock</span>
                            </div>
                            <h2 class="h3 mb-0 fw-bold text-dark">{{ $totalStock }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100 rounded-3">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-success bg-opacity-10 text-success rounded-3 p-2">
                                    <i class="bi bi-graph-up-arrow fs-4"></i>
                                </div>
                                <span class="text-muted small fw-medium">Today Inventory</span>
                            </div>
                            <h2 class="h3 mb-0 fw-bold text-dark">${{ $totalInventory }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100 rounded-3">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-info bg-opacity-10 text-info rounded-3 p-2">
                                    <i class="bi bi-grid-fill fs-4"></i>
                                </div>
                                <span class="text-muted small fw-medium">Total Category</span>
                            </div>
                            <h2 class="h3 mb-0 fw-bold text-dark">{{ $totalCategory }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <div class="card border-0 shadow-sm text-center p-5 mt-4 rounded-4">
                <div class="card-body py-4">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                        <i class="bi bi-lock fs-1"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-2">Dashboard Locked</h3>
                    <p class="text-muted mx-auto mb-4" style="max-width: 450px;">
                        You are on the <strong>Free Plan</strong>. Please choose a plan to get started.
                    </p>
                    <a href="{{ route('pricing') }}" class="btn btn-primary px-4 py-2 fw-semibold rounded-3 shadow-sm">
                        <i class="bi bi-lightning-charge-fill me-2"></i>Choose a Plan
                    </a>
                </div>
            </div>
        @endif

    </x-slot>
</x-layout>
