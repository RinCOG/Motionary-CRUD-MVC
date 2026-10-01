@extends('layouts.app')

@section('title', 'Inventory data table')

@section('content')
<div class="app-container">
    <header class="page-heading"><div><p class="eyebrow">Reports / Records</p><h1>Inventory data table</h1><p class="page-subtitle">All products in one sortable-by-page view.</p></div><a href="{{ route('reports') }}" class="btn btn-outline-dark px-3 py-2"><i class="fas fa-arrow-left me-2" aria-hidden="true"></i>Back to reports</a></header>

    <section class="surface">
        <div class="surface-heading"><h2>All product records</h2><span class="text-secondary small">{{ $products->total() }} total</span></div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>ID</th><th>Product</th><th>Category</th><th>Quantity</th><th>Unit price</th><th>Stock value</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($products as $product)
                        <tr><td class="text-secondary">#{{ $product->id }}</td><td><a class="product-name" href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td><td>{{ $product->category }}</td><td>{{ number_format($product->quantity) }}</td><td>${{ number_format((float) $product->price, 2) }}</td><td>${{ number_format($product->total_value, 2) }}</td><td><span class="badge bg-{{ $product->stock_status_class }}">{{ $product->stock_status }}</span></td></tr>
                    @empty
                        <tr><td colspan="7" class="empty-state">No product records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="surface-body">{{ $products->links() }}</div>
    </section>
</div>
@endsection
