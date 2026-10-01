@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="app-container">
    <header class="page-heading"><div><p class="eyebrow">Inventory intelligence</p><h1>Reports</h1><p class="page-subtitle">A concise read on the stock currently recorded in Stockroom.</p></div><a href="{{ route('data-table') }}" class="btn btn-primary px-3 py-2"><i class="fas fa-table me-2" aria-hidden="true"></i>Full data table</a></header>

    <section class="report-summary" aria-label="Inventory report summary">
        <div class="report-stat"><span>Product records</span><strong>{{ number_format($productCount) }}</strong></div>
        <div class="report-stat"><span>Units on hand</span><strong>{{ number_format($unitCount) }}</strong></div>
        <div class="report-stat"><span>Estimated value</span><strong>${{ number_format((float) $inventoryValue, 2) }}</strong></div>
        <div class="report-stat"><span>Low or empty stock</span><strong>{{ number_format($lowStockCount) }}</strong></div>
    </section>

    <section class="surface">
        <div class="surface-heading"><h2>Latest product records</h2><span class="text-secondary small">Most recently created</span></div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>Product</th><th>Category</th><th>Quantity</th><th>Unit price</th><th>Stock value</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($products as $product)
                        <tr><td><a class="product-name" href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td><td>{{ $product->category }}</td><td>{{ number_format($product->quantity) }}</td><td>${{ number_format((float) $product->price, 2) }}</td><td>${{ number_format($product->total_value, 2) }}</td><td><span class="badge bg-{{ $product->stock_status_class }}">{{ $product->stock_status }}</span></td></tr>
                    @empty
                        <tr><td colspan="6" class="empty-state">No inventory records are available yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
