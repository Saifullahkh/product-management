<x-layout>
    <x-slot name="main">

        @if(auth()->user()->hasRole('Admin'))

        <div class="mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <h1 class="h3 fw-bold text-dark mb-1">Role Management</h1>
                <button class="btn btn-primary d-flex align-items-center gap-2 px-3 py-2 rounded-3"
                    data-bs-toggle="modal" data-bs-target="#addRole">
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
                                <th class="border-0 text-muted small py-3" width="140">Name</th>
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
                                        <div class="d-flex flex-wrap gap-1">
                                            @forelse($role->permissions as $perm)
                                                <span class="badge bg-light text-primary border px-2 py-1 rounded" style="font-size: 0.7rem;">
                                                    {{ $perm->name }}
                                                </span>
                                            @empty
                                                <span class="text-muted small">—</span>
                                            @endforelse
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

        <!-- Add/Edit Role Modal -->
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
                                <label class="form-label small fw-semibold d-block mb-2">Assign Permissions</label>
                                @if($permissions->isNotEmpty())
                                <div class="row g-2">
                                    @foreach($permissions as $permission)
                                    <div class="col-md-4 col-sm-6">
                                        <div class="p-2 border rounded-3 bg-light d-flex align-items-center">
                                            <div class="form-check mb-0">
                                                <input class="form-check-input permission-checkbox" type="checkbox"
                                                    id="perm-{{ $permission->id }}"
                                                    name="permissions[]"
                                                    value="{{ $permission->name }}">
                                                <label class="form-check-label small fw-medium ms-1" for="perm-{{ $permission->id }}">
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
                new bootstrap.Modal(document.getElementById('addRole')).show();
            });
        </script>
        @endif

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const roleModal = document.getElementById('addRole');
                const roleForm  = document.getElementById('roleForm');

                roleModal.addEventListener('show.bs.modal', function (e) {
                    const btn = e.relatedTarget;
                    if (!btn || !btn.hasAttribute('data-id')) return;

                    const id   = btn.getAttribute('data-id');
                    const name = btn.getAttribute('data-name') || '';

                    document.getElementById('roleModalTitle').textContent = 'Edit Role';
                    document.getElementById('roleSubmitBtn').textContent  = 'Update Role';
                    document.getElementById('roleId').value               = id;
                    document.getElementById('roleNameInput').value        = name;
                    document.getElementById('roleUpdate').value           = 'PUT';
                    roleForm.action = '/role/edit/' + id;

                    document.querySelectorAll('.permission-checkbox').forEach(c => c.checked = false);

                    fetch('/role/' + id + '/permissions')
                        .then(r => r.json())
                        .then(data => {
                            (data.permissions || []).forEach(perm => {
                                const cb = document.querySelector(`.permission-checkbox[value="${perm}"]`);
                                if (cb) cb.checked = true;
                            });
                        });
                });

                roleModal.addEventListener('hidden.bs.modal', function () {
                    document.getElementById('roleModalTitle').textContent = 'Add New Role';
                    document.getElementById('roleSubmitBtn').textContent  = 'Save Role';
                    document.getElementById('roleId').value               = '';
                    document.getElementById('roleNameInput').value        = '';
                    document.getElementById('roleUpdate').value           = 'POST';
                    roleForm.action = "{{ route('roles-store') }}";
                    document.querySelectorAll('.permission-checkbox').forEach(c => c.checked = false);
                });
            });
        </script>

        @else
        <div class="card border-0 shadow-sm text-center p-5 mt-4 rounded-4">
            <div class="card-body py-4">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                    <i class="bi bi-shield-lock fs-1"></i>
                </div>
                <h3 class="fw-bold text-dark mb-2">Access Restricted</h3>
                <p class="text-muted mx-auto mb-0" style="max-width: 400px;">
                    Role management is only accessible to <strong>Admin</strong> users.
                </p>
            </div>
        </div>
        @endif

    </x-slot>
</x-layout>
