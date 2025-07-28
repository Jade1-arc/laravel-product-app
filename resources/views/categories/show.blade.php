@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-tag me-2"></i>Category: {{ $category->name }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-1"></i>Edit
                </a>
                @if($category->products()->count() == 0)
                    <button type="button" class="btn btn-danger me-2" 
                            onclick="confirmDelete('{{ route('categories.destroy', $category) }}', '{{ $category->name }}')">
                        <i class="fas fa-trash me-1"></i>Delete
                    </button>
                @endif
            @endif
        @endauth
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Categories
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Category Information
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>ID:</strong></td>
                        <td>{{ $category->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Name:</strong></td>
                        <td>{{ $category->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Products:</strong></td>
                        <td><span class="badge bg-info">{{ $products->total() }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Created:</strong></td>
                        <td>{{ $category->created_at->format('F d, Y \a\t g:i A') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Updated:</strong></td>
                        <td>{{ $category->updated_at->format('F d, Y \a\t g:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        @auth
            @if(auth()->user()->isAdmin())
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-cog me-2"></i>Admin Actions
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-1"></i>Edit Category
                            </a>
                            @if($category->products()->count() == 0)
                                <button type="button" class="btn btn-danger" 
                                        onclick="confirmDelete('{{ route('categories.destroy', $category) }}', '{{ $category->name }}')">
                                    <i class="fas fa-trash me-1"></i>Delete Category
                                </button>
                            @else
                                <button type="button" class="btn btn-danger" disabled>
                                    <i class="fas fa-trash me-1"></i>Cannot Delete (Has Products)
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endauth
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-box me-2"></i>Products in {{ $category->name }}
                </h5>
            </div>
            <div class="card-body">
                @if($products->count() > 0)
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="row g-0">
                                        <div class="col-4">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" class="img-fluid rounded-start h-100" alt="{{ $product->name }}" style="object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-8">
                                            <div class="card-body">
                                                <h6 class="card-title">{{ $product->name }}</h6>
                                                <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="text-success fw-bold">${{ number_format($product->price, 2) }}</span>
                                                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye me-1"></i>View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                        <h3 class="text-muted">No products in this category</h3>
                        <p class="text-muted">This category doesn't have any products yet.</p>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('products.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>Add Product
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 