@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="app-container">
    <header class="page-heading"><div><p class="eyebrow">Inventory / Product record</p><h1>{{ $product->name }}</h1><p class="page-subtitle">Record #{{ $product->id }} · Added {{ $product->created_date->format('M d, Y') }}</p></div><div class="d-flex gap-2"><a href="{{ route('products.index') }}" class="btn btn-outline-dark px-3 py-2"><i class="fas fa-arrow-left me-2" aria-hidden="true"></i>Inventory</a><a href="{{ route('products.edit', $product) }}" class="btn btn-primary px-3 py-2"><i class="fas fa-pen me-2" aria-hidden="true"></i>Edit</a></div></header>

    <section class="surface">
        <div class="surface-heading"><h2>Product overview</h2><span class="badge bg-{{ $product->stock_status_class }}">{{ $product->stock_status }}</span></div>
        <div class="surface-body">
            <div class="detail-grid">
                <div class="detail-item"><span>Category</span><strong>{{ $product->category }}</strong></div>
                <div class="detail-item"><span>Quantity on hand</span><strong>{{ number_format($product->quantity) }} units</strong></div>
                <div class="detail-item"><span>Unit price</span><strong>${{ number_format((float) $product->price, 2) }}</strong></div>
                <div class="detail-item"><span>Total stock value</span><strong>${{ number_format($product->total_value, 2) }}</strong></div>
            </div>
            @if($product->description)
                <div class="mt-4"><p class="eyebrow">Description</p><p class="mb-0 text-secondary">{{ $product->description }}</p></div>
            @endif
            <form action="{{ route('products.destroy', $product) }}" method="POST" class="mt-4" onsubmit="return confirm('Delete this product from inventory?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash me-2" aria-hidden="true"></i>Delete product</button>
            </form>
        </div>
    </section>
</div>
@endsection
