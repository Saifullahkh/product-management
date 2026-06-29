<x-layout>
    <x-slot name="main">
        @php
            $user = auth()->user();

            // Cashier subscription system validation checking
            $hasActiveSubscription = $user && $user->subscribed('default');
            $activePriceId = $hasActiveSubscription ? $user->subscription('default')->stripe_price : null;

            // Stripe Price ID OR Spatie Role fallbacks
            $isEnterprise  = ($activePriceId === 'price_1Tl0ex5TaCf50YAD6FZs8a54') || ($user && $user->hasRole('Enterprise User'));
            $isProBusiness = !$isEnterprise && (($activePriceId === 'price_1Tl0dp5TaCf50YADcqrJRwsG') || ($user && $user->hasRole('Pro Business User')));
            $isBasic       = !$isEnterprise && !$isProBusiness && (($activePriceId === 'price_1Tl0cP5TaCf50YADJPdhkbHQ') || ($user && $user->hasRole('Basic User')));

            // Roles & Permissions panel security logic mapping
            $hasTableAccess = $isEnterprise; 
        @endphp

        @if($hasTableAccess)
        <div class="mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="h3 fw-bold text-dark mb-1">Role Management</h1>
                </div>
                <button class="btn btn-primary d-flex align-items-center gap-2 px-3 py-2 rounded-3"
                    data-bs-toggle="modal" data-bs-target="#addRole" id="openAddRoleModalBtn">
                    <i class="bi bi-plus-lg"></i>
                    <span>Add Role</span>
                </button>
            </div>        
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 rounded-start ps-4 text-muted small py-3" width="60">ID</th>
                                <th class="border-0 text-muted small py-3">Name</th>
                                <th class="border-0 text-muted small py-3">Permissions</th>
                                <th class="border-0 text-muted small py-3" width="140">Created</th>
                                <th class="border-0 rounded-end text-muted small py-3 pe-4" width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td class="ps-4 border-0 py-3 text-muted fw-medium">{{ $role->id }}</td>
                                    <td class="border-0 py-3">
                                        <p class="mb-0 fw-semibold text-muted small">{{ $role->name }}</p>
                                    </td>
                                    <td class="border-0 py-3">
                                        <div class="d-flex flex-wrap gap-1" style="max-width: 400px;">
                                            @foreach($role->permissions as $perm)
                                                <span class="badge bg-light text-primary border px-2 py-1 rounded" style="font-size: 0.7rem;">
                                                    {{ $perm->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="border-0 py-3 text-muted small">{{ $role->created_at->format('d M Y') }}</td>
                                    <td class="border-0 py-3 pe-4">
                                        <a href="#" class="btn btn-sm btn-light border rounded-2 p-1 px-2 edit-role-btn"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#addRole" 
                                            data-id="{{ $role->id }}"
                                            data-name="{{ $role->name }}">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                      
                                        <a href="{{ route('roles-delete', $role->id) }}"
                                            onclick="return confirm('Are you sure to delete this record?')"
                                            class="btn btn-sm btn-light border text-danger rounded-2 p-1 px-2 ms-1">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addRole" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header border-0 p-4 pb-0">
                        <h5 class="fw-bold mb-0" id="roleModalTitle">Add New Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="{{ route('roles-store') }}" method="post" id="roleForm">
                            @csrf
                            <input type="hidden" name="_method" id="roleUpdate" value="POST">
                            <input type="hidden" name="id" id="roleId">
                            
                            <div class="mb-4">
                                <label class="form-label small fw-semibold">Role Name</label>
                                <input type="text" class="form-control rounded-3" name="name"
                                    id="roleNameInput" placeholder="Enter Role Name" required>
                                @error('name')
                                    <p class="text-danger small mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold d-block mb-2 text-muted text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Assign Permissions</label>
                                @if ($permissions->isNotEmpty())
                                   <div class="row g-3">
                                     @foreach ($permissions as $permission)
                                        <div class="col-md-4 col-sm-6">
                                            <div class="p-2 border rounded-3 bg-light bg-opacity-50 d-flex align-items-center">
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input permission-checkbox" type="checkbox" 
                                                        id="permission-{{ $permission->id }}" 
                                                        name="permissions[]" 
                                                        value="{{ $permission->name }}" />
                                                    <label class="form-check-label small fw-medium text-dark ms-1" for="permission-{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                     @endforeach
                                   </div>
                                @endif
                            </div>
                            
                            <div class="modal-footer border-0 p-4 pt-3 justify-content-center">
                                <button type="submit" class="btn btn-primary rounded-3 px-4" id="roleSubmitBtn">Save Role</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var myModal = new bootstrap.Modal(document.getElementById('addRole'));
                myModal.show();
            });
        </script>
        @endif

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const roleModal = document.getElementById('addRole');
                if (!roleModal) return;

                const modalTitle = document.getElementById('roleModalTitle');
                const roleId = document.getElementById('roleId');
                const roleUpdate = document.getElementById('roleUpdate');
                const roleNameInput = document.getElementById('roleNameInput');
                const roleSubmitBtn = document.getElementById('roleSubmitBtn');
                const roleForm = document.getElementById('roleForm');

                // Centralized Edit Mode initialization configuration structure
                function setupEditMode(id, name) {
                    modalTitle.textContent = 'Edit Role';
                    roleId.value = id;
                    roleNameInput.value = name || '';
                    if (roleUpdate) roleUpdate.value = 'PUT';
                    roleSubmitBtn.textContent = 'Update';
                    if (roleForm) roleForm.action = '/role/edit/' + id; // Corrected singular endpoint parameters fallback

                    // Reset privileges checkboxes
                    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
                        checkbox.checked = false;
                    });

                    // Async payload permissions mapping node fetch
                    fetch('/role/' + id + '/permissions')
                        .then(response => response.json())
                        .then(data => {
                            if (data.permissions && Array.isArray(data.permissions)) {
                                data.permissions.forEach(permissionName => {
                                    const checkbox = document.querySelector(`.permission-checkbox[value="${permissionName}"]`);
                                    if (checkbox) checkbox.checked = true;
                                });
                            }
                        })
                        .catch(error => console.error('Error fetching permissions system array:', error));
                }

                // Listen for Bootstrap modal show trigger standard nodes
                roleModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    if (!button || !button.hasAttribute('data-id')) return;

                    const id = button.getAttribute('data-id');
                    const name = button.getAttribute('data-name') || '';
                    setupEditMode(id, name);
                });

                // Clear states lifecycle parameters mapping triggers on modal hidden
                roleModal.addEventListener('hidden.bs.modal', function () {
                    modalTitle.textContent = 'Add New Role';
                    roleId.value = '';
                    roleNameInput.value = '';
                    if (roleUpdate) roleUpdate.value = 'POST';
                    roleSubmitBtn.textContent = 'Save Role';
                    if (roleForm) {
                        roleForm.action = "{{ route('roles-store') }}";
                        if (typeof roleForm.reset === 'function') roleForm.reset();
                    }
                    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
                        checkbox.checked = false;
                    });
                });

                // Prevent links navigation bugs on dynamic anchors
                document.body.addEventListener('click', function (e) {
                    const el = e.target.closest('.edit-role-btn');
                    if (el) {
                        e.preventDefault();
                        const id = el.getAttribute('data-id');
                        const name = el.getAttribute('data-name') || '';

                        setupEditMode(id, name);

                        const modal = bootstrap.Modal.getOrCreateInstance(roleModal);
                        modal.show();
                    }
                });
            });
        </script>

        @else
        <div class="alert border-0 shadow-sm p-4 mt-4 rounded-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 animate__animated animate__fadeIn" 
            style="background: linear-gradient(135deg, #eef2ff 0%, #f4f7ff 100%); border-left: 5px solid #0d6efd !important;">
            
            <div class="d-flex align-items-start gap-3">
                <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" 
                    style="width: 48px; height: 48px; border: 1px solid rgba(13, 110, 253, 0.15);">
                    <i class="bi bi-shield-lock-fill fs-4"></i>
                </div>
                <div>
                    <h5 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2" style="font-family: 'Inter', sans-serif;">
                        <span class="text-primary">RBAC</span> Enterprise Security Engine Locked
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1 small fw-semibold" style="font-size: 0.75rem;">
                            Enterprise Plan Only
                        </span>
                    </h5>
                    
                    @if($isProBusiness || $isBasic)
                        <p class="text-muted small mb-0" style="max-width: 650px; line-height: 1.5;">
                            Aapka current tier **{{ $isProBusiness ? 'Pro Business Plan' : 'Basic Plan' }}** hai. Global custom roles initialization, user level granular privilege bindings, aur security policy configuration panels sirf **Enterprise Tier** scaling accounts ke liye open hotay hain.
                        </p>
                    @else
                        <p class="text-muted small mb-0" style="max-width: 650px; line-height: 1.5;">
                            Aap abhi **Free Plan** use kar rahe hain. Live granular permissions cascading matrices control karne, role-based user routing workflows handle karne aur system schemas modify karne ke liye dynamic billing framework register kijiye.
                        </p>
                    @endif
                </div>
            </div>

            <div class="flex-shrink-0 ms-md-auto">
                <a href="{{ route('pricing') }}" class="btn btn-primary px-3 py-2 fw-semibold rounded-3 shadow-sm d-flex align-items-center gap-2 transition-all hover-scale">
                    <i class="bi bi-lightning-charge-fill"></i>
                    <span>Upgrade to Enterprise Plan</span>
                </a>
            </div>
        </div>
        @endif
    </x-slot>
</x-layout>