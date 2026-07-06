<x-layout>
    <x-slot name="main">

        <div class="mb-4">
            <h1 class="h3 fw-bold text-dark mb-1">User List</h1>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 rounded-start ps-4 text-muted small py-3" width="60">ID</th>
                                <th class="border-0 text-muted small py-3">Name</th>
                                <th class="border-0 text-muted small py-3">Email</th>
                                <th class="border-0 text-muted small py-3">Plan</th>
                                <th class="border-0 rounded-end text-muted small py-3 pe-4" width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @php
                                    $isEnt = $user->hasRole('Enterprise User');
                                    $isPro = !$isEnt && $user->hasRole('Pro Business User');
                                    $isBas = !$isEnt && !$isPro && $user->hasRole('Basic User');

                                    if ($isEnt){ $planLabel = 'Enterprise';    $planClass = 'bg-dark bg-opacity-10 text-dark'; }
                                    elseif ($isPro){ $planLabel = 'Pro Business';  $planClass = 'bg-primary bg-opacity-10 text-primary'; }
                                    elseif ($isBas){ $planLabel = 'Basic';         $planClass = 'bg-info bg-opacity-10 text-info'; }
                                    elseif ($user->hasRole('Admin')) { $planLabel = 'Admin'; $planClass = 'bg-danger bg-opacity-10 text-danger'; }
                                    else { $planLabel = 'Free Plan';     $planClass = 'bg-secondary bg-opacity-10 text-secondary'; }

                                    $userRole = $user->roles->first()?->name ?? '';
                                @endphp
                                <tr>
                                    <td class="ps-4 border-0 py-3 text-muted fw-medium">{{ $user->id }}</td>
                                    <td class="border-0 py-3">
                                        <p class="mb-0 fw-semibold text-muted small">{{ $user->name }}</p>
                                    </td>
                                    <td class="border-0 py-3">
                                        <p class="mb-0 fw-semibold text-muted small">{{ $user->email }}</p>
                                    </td>
                                    <td class="border-0 py-3">
                                        <span class="badge rounded-pill px-3 py-1 {{ $planClass }}">
                                            {{ $planLabel }}
                                        </span>
                                    </td>
                                    <td class="border-0 py-3 pe-4">
                                        <a href="#"
                                            class="btn btn-sm btn-light border rounded-2 p-1 px-2 edit-user-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#addUserModal"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}"
                                            data-email="{{ $user->email }}"
                                            data-role="{{ $userRole }}">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ route('users-delete', $user->id) }}"
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

        <!-- Edit User Modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header border-0 p-4 pb-0">
                        <h5 class="fw-bold mb-0" id="userModalTitle">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="" method="post" id="userForm">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="id" id="userId">

                            <div class="mb-3">
                                <label class="form-label small fw-semibold">User Name</label>
                                <input type="text" class="form-control rounded-3" name="name" id="userNameInput" placeholder="Enter User Name" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold">User Email</label>
                                <input type="email" class="form-control rounded-3" name="email" id="userEmailInput" placeholder="Enter Email" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Plan / Role</label>
                                <select class="form-select rounded-3" name="role[]" id="userRoleInput">
                                    <option value="Basic User">Basic</option>
                                    <option value="Pro Business User">Pro Business</option>
                                    <option value="Enterprise User">Enterprise</option>
                                    <option value="Admin">Admin</option>
                                </select>
                            </div>

                            <div class="modal-footer border-0 p-4 pt-3 justify-content-center">
                                <button type="submit" class="btn btn-primary rounded-3 px-4">Update User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('.edit-user-btn').on('click', function() {
                    let id    = $(this).data('id');
                    let name  = $(this).data('name');
                    let email = $(this).data('email');
                    let role  = $(this).data('role');

                    $('#userForm').attr('action', "{{ url('users/edit') }}" + "/" + id);
                    $('#userId').val(id);
                    $('#userNameInput').val(name);
                    $('#userEmailInput').val(email);
                    $('#userRoleInput').val(role || '');
                });

                $('#addUserModal').on('hidden.bs.modal', function() {
                    $('#userNameInput').val('');
                    $('#userEmailInput').val('');
                    $('#userRoleInput').val('');
                });
            });
        </script>

    </x-slot>
</x-layout>
