<x-layout>
    <x-slot name="main">
        @php
            $user = auth()->user();
            $isAdmin       = $user && $user->hasRole('Admin');
            $isEnterprise  = !$isAdmin && $user && $user->hasRole('Enterprise User');
            $isProBusiness = !$isAdmin && !$isEnterprise && $user && $user->hasRole('Pro Business User');
            $isBasic       = !$isAdmin && !$isEnterprise && !$isProBusiness && $user && $user->hasRole('Basic User');
            $displayedProducts = $isProBusiness ? $products->take(5) : $products;
        @endphp

        @if($isAdmin || $isProBusiness || $isEnterprise)

            <div class="mb-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h1 class="h3 fw-bold text-dark mb-1">Product List</h1>
                    </div>
                    @can('create products')
                    <button class="btn btn-primary d-flex align-items-center gap-2 px-3 py-2 rounded-3"
                        data-bs-toggle="modal" data-bs-target="#addProductModal1">
                        <i class="bi bi-plus-lg"></i>
                        <span>Add Product</span>
                    </button>
                    @endcan
                </div>
            </div>
            
            @can('view products')
            <div class="card border-0 mb-4 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="border-0 rounded-start ps-4 text-muted small py-3">ID</th>
                                    <th class="border-0 text-muted small py-3">Image</th>
                                    <th class="border-0 text-muted small py-3">Name</th>
                                    <th class="border-0 text-muted small py-3">Category</th>
                                    <th class="border-0 text-muted small py-3">Price</th>
                                    <th class="border-0 text-muted small py-3">Stock</th>
                                    <th class="border-0 rounded-end text-muted small py-3 pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($displayedProducts as $product)
                                    <tr>
                                        <td class="ps-4 border-0 py-3 text-muted fw-medium">{{ $product->id }}</td>
                                        <td class="border-0 py-3">
                                            @if($product->image)
                                                <img src="{{ asset('storage/uploads/' . $product->image) }}"
                                                    class="rounded-3 border" width="45" height="45" alt="Product">
                                            @endif
                                        </td>
                                        <td class="border-0 py-3">
                                            <p class="mb-0 fw-semibold text-muted small">{{ $product->name }}</p>
                                        </td>
                                        <td class="border-0 py-3">
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-1">{{ $product->category->name ?? 'N/A' }}</span>
                                        </td>
                                        <td class="border-0 py-3 text-secondary">${{ $product->price }}</td>
                                        <td class="border-0 py-3">
                                            <div class="d-flex align-items-center gap-2 {{ $product->stock < 5 ? 'text-danger' : 'text-muted' }}">
                                                {{ $product->stock }} <span>In Stock</span>
                                            </div>
                                        </td>
                                        <td class="border-0 py-3 pe-4">
                                            @can('edit products')
                                            <a href="{{ route('products-update', $product->id) }}" 
                                                class="btn btn-sm btn-light border rounded-2 p-1 px-2"
                                                data-bs-toggle="modal" data-bs-target="#addProductModal1"
                                                data-id="{{ $product->id }}"
                                                data-name="{{ $product->name }}"
                                                data-category="{{ $product->category_id }}"
                                                data-price="{{ $product->price }}"
                                                data-stock="{{ $product->stock }}"
                                                data-image="{{ asset('storage/uploads/' . $product->image) }}">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            @endcan

                                            @can('delete products')
                                            <a href="{{ route('products-delete', $product->id) }}" 
                                                onclick="return confirm('Are you sure to delete this record?')" 
                                                class="btn btn-sm btn-light border text-danger rounded-2 p-1 px-2 ms-1">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Pro Business upgrade banner --}}
            @if($isProBusiness)
                <div class="card border-0 shadow-sm text-center p-5 mt-2 rounded-4" style="border-top: 3px solid #0d6efd !important;">
                    <div class="card-body py-2">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                            <i class="bi bi-shield-lock fs-2"></i>
                        </div>
                        <h3 class="fw-bold text-dark mb-2">Unlimited Products Locked</h3>
                        <p class="text-muted mx-auto mb-4" style="max-width: 500px;">
                            You are on the <strong>Pro Business Plan</strong> — limited to 5 products. Upgrade to Enterprise for unlimited access.
                        </p>
                        <a href="{{ route('pricing') }}" class="btn btn-primary px-4 py-2 fw-semibold rounded-3 shadow-sm">
                            <i class="bi bi-lightning-charge-fill me-2"></i>Upgrade to Enterprise
                        </a>
                    </div>
                </div>
            @endif
            @endcan

            {{-- Add/Edit Product Modal --}}
            <div class="modal fade" id="addProductModal1" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg rounded-4">
                        <div class="modal-header border-0 p-4 pb-0">
                            <h5 class="fw-bold mb-0" id="productModalTitle">Add New Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <form action="{{ route('products-store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="productId">
                                <input type="hidden" name="update" id="productUpdate" value="">
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Product Name</label>
                                    <input type="text" class="form-control rounded-3" name="productName"
                                        id="productNameInput" value="{{ old('productName') }}" placeholder="Enter product name">
                                    @error('productName')
                                        <p class="text-danger small">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Category</label>
                                    <select class="form-select rounded-3" name="selectCategory" id="productCategoryInput">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('selectCategory') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('selectCategory')
                                        <p class="text-danger small">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col">
                                        <label class="form-label small fw-semibold">Price ($)</label>
                                        <input type="number" class="form-control rounded-3" name="price" value="{{ old('price') }}" id="productPriceInput">
                                        @error('price')
                                            <p class="text-danger small">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label class="form-label small fw-semibold">Stock</label>
                                        <input type="number" class="form-control rounded-3" name="stock" id="productStockInput" value="{{ old('stock') }}">
                                        @error('stock')
                                            <p class="text-danger small">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label small fw-semibold">Product Image</label>
                                    <input type="file" class="form-control rounded-3" name="image" id="productImage">
                                    @error('image')
                                        <p class="text-danger small">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-12 mt-3 text-center">
                                    <img id="imagePreview" src="" alt="Current product image" class="rounded-3 border" style="display:none; max-width: 100px; max-height: 100px;" />
                                </div>
                                <div class="modal-footer border-0 p-4 pt-3 justify-content-center">
                                    <button type="submit" class="btn btn-primary rounded-3 px-4" id="productSubmitBtn">Save Product</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if($errors->any())
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    new bootstrap.Modal(document.getElementById('addProductModal1')).show();
                });
            </script>
            @endif

        @else
            {{-- Locked screen --}}
            <div class="card border-0 shadow-sm text-center p-5 mt-4 rounded-4">
                <div class="card-body py-4">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                        <i class="bi bi-lock fs-1"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-2">Product Management Locked</h3>
                    <p class="text-muted mx-auto mb-4" style="max-width: 450px;">
                        @if($isBasic)
                            You are on the <strong>Basic Plan</strong>. Upgrade to <strong>Pro Business</strong> or <strong>Enterprise</strong> to manage products.
                        @else
                            You are on the <strong>Free Plan</strong>. Please choose a plan to access products.
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
