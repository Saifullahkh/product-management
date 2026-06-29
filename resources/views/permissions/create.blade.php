<x-layout>
    <x-slot name="main">
        <div class="mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="h3 fw-bold text-dark mb-1">Permissions</h1>
                </div>
            </div>        
        </div>


         <div class="card border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 rounded-start ps-4 text-muted small py-3" width="60">ID</th>
                                <th class="border-0 text-muted small py-3">Name</th>
                                <th class="border-0 text-muted small py-3" width="140">Created</th>
                                <th class="border-0 rounded-end text-muted small py-3 pe-4" width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td class="ps-4 border-0 py-3 text-muted fw-medium">{{ $permission->id }}</td>
                                    <td class="border-0 py-3">
                                        <p class="mb-0 fw-semibold text-muted small">{{ $permission->name }}</p>
                                    </td>
                                    <td class="border-0 py-3 text-muted small">{{ $permission->created_at->format('d M Y') }}</td>
                                    <td class="border-0 py-3 pe-4">
                                        <a href="{{ route('permissions-edit', $permission->id) }}" class="btn btn-sm btn-light border rounded-2 p-1 px-2"
                                            data-bs-toggle="modal" data-bs-target="#addPermission" data-id="{{ $permission->id }}"
                                            data-name="{{ $permission->name }}"><i class="bi bi-pencil"></i>
                                        </a>
                                      
                                        <a href="{{ route('permissions-delete', $permission->id ) }}" type="submit"
                                            onclick="return confirm('Are you sure to delete this record?')"
                                            class="btn btn-sm btn-light border text-danger rounded-2 p-1 px-2 ms-1"><i
                                                class="bi bi-trash"></i>
                                        </a>
                                       
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


         <!-- Modal -->
        <div class="modal fade" id="addPermission" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header border-0 p-4 pb-0">
                        <h5 class="fw-bold mb-0" id="permissionTitle">Add New Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="{{ route('permissions-store') }}" method="post" id="permissionForm">
                            @csrf
                            <input type="hidden" name="_method" id="permissionUpdate" value="PUT">
                            <input type="hidden" name="id" id="permissionId">
                            
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Permission Name</label>
                                <input type="text" class="form-control rounded-3" name="name"
                                    id="permissionNameInput" placeholder="Enter Permission Name">
                                @error('name')
                                    <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="modal-footer border-0 p-4 pt-3 justify-content-center">
                                <button type="submit" class="btn btn-primary rounded-3 px-4" id="permissionSubmitBtn">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>


         @if($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // 'addProductModal' ki jagah apne Modal ki asal ID likhein
                var myModal = new bootstrap.Modal(document.getElementById('addPermission'));
                myModal.show();
            });
        </script>
        @endif

    </x-slot>
</x-layout>