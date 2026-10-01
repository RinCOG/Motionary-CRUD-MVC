@extends('layouts.app')

@section('title', 'Inventory')

@section('content')
<div class="app-container">
    <header class="page-heading">
        <div><p class="eyebrow">Product records</p><h1>Inventory</h1><p class="page-subtitle">Search, review, and maintain every item your team tracks.</p></div>
        <a href="{{ route('products.create') }}" class="btn btn-primary px-3 py-2"><i class="fas fa-plus me-2" aria-hidden="true"></i>Add product</a>
    </header>

    <section class="surface">
        <form method="GET" action="{{ route('products.index') }}" class="filter-bar" role="search">
            <div class="search-field"><label class="visually-hidden" for="q">Search products</label><input type="search" id="q" name="q" class="form-control" placeholder="Search name, category, description" value="{{ $filters['q'] }}"></div>
            <div><label class="visually-hidden" for="category">Category</label><select id="category" name="category" class="form-select"><option value="">All categories</option>@foreach($categories as $category)<option value="{{ $category }}" @selected($filters['category'] === $category)>{{ $category }}</option>@endforeach</select></div>
            <div><label class="visually-hidden" for="stock">Stock status</label><select id="stock" name="stock" class="form-select"><option value="">Any stock</option><option value="in" @selected($filters['stock'] === 'in')>In stock</option><option value="low" @selected($filters['stock'] === 'low')>Low stock</option><option value="out" @selected($filters['stock'] === 'out')>Out of stock</option></select></div>
            <div class="d-flex gap-2"><button class="btn btn-primary px-3" type="submit" aria-label="Apply filters"><i class="fas fa-magnifying-glass" aria-hidden="true"></i></button><a class="btn btn-outline-dark px-3 d-inline-flex align-items-center" href="{{ route('products.index') }}" aria-label="Clear filters"><i class="fas fa-rotate-left" aria-hidden="true"></i></a></div>
        </form>

        <div class="surface-heading"><h2>Products</h2><span class="text-secondary small">{{ $products->total() }} records</span></div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>Product</th><th>Category</th><th>Quantity</th><th>Unit price</th><th>Stock value</th><th>Status</th><th><span class="visually-hidden">Actions</span></th></tr></thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td><a class="product-name" href="{{ route('products.show', $product) }}">{{ $product->name }}</a>@if($product->description)<span class="d-block mt-1 text-secondary small">{{ Str::limit($product->description, 56) }}</span>@endif</td>
                            <td><span class="badge bg-info">{{ $product->category }}</span></td>
                            <td>{{ number_format($product->quantity) }}</td>
                            <td>${{ number_format((float) $product->price, 2) }}</td>
                            <td>${{ number_format($product->total_value, 2) }}</td>
                            <td><span class="badge bg-{{ $product->stock_status_class }}">{{ $product->stock_status }}</span></td>
                            <td><div class="d-flex gap-1"><a href="{{ route('products.show', $product) }}" class="action-icon" title="View {{ $product->name }}" aria-label="View {{ $product->name }}"><i class="fas fa-eye" aria-hidden="true"></i></a><a href="{{ route('products.edit', $product) }}" class="action-icon" title="Edit {{ $product->name }}" aria-label="Edit {{ $product->name }}"><i class="fas fa-pen" aria-hidden="true"></i></a><form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product from inventory?')">@csrf @method('DELETE')<button class="action-icon" type="submit" title="Delete {{ $product->name }}" aria-label="Delete {{ $product->name }}"><i class="fas fa-trash" aria-hidden="true"></i></button></form></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="empty-state">No matching products. Adjust the filters or add a new item.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="surface-body">{{ $products->links() }}</div>
    </section>
</div>
@endsection
