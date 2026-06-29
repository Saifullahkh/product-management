<x-layout>
    <x-slot name="main">
        @php
            $user = auth()->user();
            $isEnterprise  = $user && $user->hasRole('Enterprise User');
            $isProBusiness = !$isEnterprise && $user && $user->hasRole('Pro Business User');
            $isBasic       = !$isEnterprise && !$isProBusiness && $user && $user->hasRole('Basic User');
        @endphp

        @if($isProBusiness || $isEnterprise)

            <div class="mb-4">
                <div class="d-flex align-items-center justify-content-between">
                    <h1 class="h3 fw-bold text-dark mb-1">Category List</h1>
                    <button class="btn btn-primary d-flex align-items-center gap-2 px-3 py-2 rounded-3"
                        data-bs-toggle="modal" data-bs-target="#addCategoryModal" id="openAddCategoryModalBtn">
                        <i class="bi bi-plus-lg"></i>
                        <span>Add Category</span>
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
                                    <th class="border-0 text-muted small py-3">Category Name</th>
                                    <th class="border-0 rounded-end text-muted small py-3 pe-4" width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td class="ps-4 border-0 py-3 text-muted fw-medium">{{ $category->id }}</td>
                                        <td class="border-0 py-3">
                                            <p class="mb-0 fw-semibold text-muted small">{{ $category->name }}</p>
                                        </td>
                                        <td class="border-0 py-3 pe-4">
                                            <a href="#" class="btn btn-sm btn-light border rounded-2 p-1 px-2 edit-category-btn"
                                                data-bs-toggle="modal" data-bs-target="#addCategoryModal"
                                                data-id="{{ $category->id }}"
                                                data-name="{{ $category->name }}">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('categories-delete', $category->id) }}"
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

            <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg rounded-4">
                        <div class="modal-header border-0 p-4 pb-0">
                            <h5 class="fw-bold mb-0" id="categoryModalTitle">Add New Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <form action="{{ route('categories-store') }}" method="post" id="categoryForm">
                                @csrf
                                <input type="hidden" name="_method" id="categoryUpdate" value="POST">
                                <input type="hidden" name="id" id="categoryId">
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Category Name</label>
                                    <input type="text" class="form-control rounded-3" name="categoryName"
                                        id="categoryNameInput" placeholder="Enter category name" required>
                                    @error('categoryName')
                                        <p class="text-danger small mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="modal-footer border-0 p-4 pt-3 justify-content-center">
                                    <button type="submit" class="btn btn-primary rounded-3 px-4" id="categorySubmitBtn">Save Category</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if($errors->any())
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    new bootstrap.Modal(document.getElementById('addCategoryModal')).show();
                });
            </script>
            @endif

            <script>
                $(document).ready(function() {
                    $('.edit-category-btn').on('click', function() {
                        let id   = $(this).data('id');
                        let name = $(this).data('name');
                        $('#categoryModalTitle').text('Edit Category');
                        $('#categorySubmitBtn').text('Update Category');
                        $('#categoryForm').attr('action', "{{ url('edit-category') }}" + "/" + id);
                        $('#categoryUpdate').val('PUT');
                        $('#categoryId').val(id);
                        $('#categoryNameInput').val(name);
                    });
                    $('#addCategoryModal').on('hidden.bs.modal', function() {
                        $('#categoryModalTitle').text('Add New Category');
                        $('#categorySubmitBtn').text('Save Category');
                        $('#categoryForm').attr('action', "{{ route('categories-store') }}");
                        $('#categoryUpdate').val('POST');
                        $('#categoryId').val('');
                        $('#categoryNameInput').val('');
                    });
                });
            </script>

        @else
            <div class="card border-0 shadow-sm text-center p-5 mt-4 rounded-4">
                <div class="card-body py-4">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                        <i class="bi bi-lock fs-1"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-2">Category Management Locked</h3>
                    <p class="text-muted mx-auto mb-4" style="max-width: 450px;">
                        @if($isBasic)
                            You are on the <strong>Basic Plan</strong>. Upgrade to <strong>Pro Business</strong> or <strong>Enterprise</strong> to manage categories.
                        @else
                            You are on the <strong>Free Plan</strong>. Please choose a plan to access categories.
                        @endif
                    </p>
                    <a href="{{ route('pricing') }}" class="btn btn-primary px-4 py-2 fw-semibold rounded-3 shadow-sm">
                        <i class="bi bi-lightning-charge-fill me-2"></i>
                        {{ $isBasic ? 'Upgrade to Pro Business' : 'Choose a Plan' }}
                    </a>
                </div>
            </div>
        @endif

    </x-slot>
</x-layout>
