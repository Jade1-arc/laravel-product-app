@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-eye me-2"></i>Product Details
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-1"></i>Edit
                </a>
                <button type="button" class="btn btn-danger me-2" 
                        onclick="confirmDelete('{{ route('products.destroy', $product) }}', '{{ $product->name }}')">
                    <i class="fas fa-trash me-1"></i>Delete
                </button>
            @endif
        @endauth
        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Products
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 400px;">
                        <i class="fas fa-image fa-5x text-muted"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Product Information
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Name:</strong></td>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Category:</strong></td>
                        <td><span class="badge bg-primary">{{ $product->category->name }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Price:</strong></td>
                        <td><span class="h4 text-success mb-0">${{ number_format($product->price, 2) }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Description:</strong></td>
                        <td>{{ $product->description }}</td>
                    </tr>
                    <tr>
                        <td><strong>Created:</strong></td>
                        <td>{{ $product->created_at->format('F d, Y \a\t g:i A') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Last Updated:</strong></td>
                        <td>{{ $product->updated_at->format('F d, Y \a\t g:i A') }}</td>
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
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-1"></i>Edit Product
                            </a>
                            <button type="button" class="btn btn-danger" 
                                    onclick="confirmDelete('{{ route('products.destroy', $product) }}', '{{ $product->name }}')">
                                <i class="fas fa-trash me-1"></i>Delete Product
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        @endauth
    </div>
</div>

<!-- Related Products -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-tags me-2"></i>Other Products in {{ $product->category->name }}
                </h5>
            </div>
            <div class="card-body">
                @php
                    $relatedProducts = $product->category->products()->where('id', '!=', $product->id)->take(4)->get();
                @endphp
                
                @if($relatedProducts->count() > 0)
                    <div class="row">
                        @foreach($relatedProducts as $relatedProduct)
                            <div class="col-md-3 mb-3">
                                <div class="card h-100">
                                    @if($relatedProduct->image)
                                        <img src="{{ Storage::url($relatedProduct->image) }}" class="card-img-top" alt="{{ $relatedProduct->name }}" style="height: 150px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $relatedProduct->name }}</h6>
                                        <p class="card-text text-success fw-bold">${{ number_format($relatedProduct->price, 2) }}</p>
                                        <a href="{{ route('products.show', $relatedProduct) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center">No other products in this category.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 