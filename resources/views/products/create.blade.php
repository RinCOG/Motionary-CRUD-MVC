@extends('layouts.app')

@section('title', 'Add product')

@section('content')
<div class="app-container">
    <header class="page-heading"><div><p class="eyebrow">Inventory / New record</p><h1>Add a product</h1><p class="page-subtitle">Enter the product details and its current stock position.</p></div><a href="{{ route('products.index') }}" class="btn btn-outline-dark px-3 py-2"><i class="fas fa-arrow-left me-2" aria-hidden="true"></i>Back to inventory</a></header>

    <section class="surface">
        <div class="surface-heading"><h2>Product details</h2><span class="text-secondary small">Required fields marked *</span></div>
        <div class="surface-body">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6"><label for="name" class="form-label">Product name *</label><input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" maxlength="255" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label for="category" class="form-label">Category *</label><select id="category" name="category" class="form-select @error('category') is-invalid @enderror" required><option value="">Choose category</option>@foreach($categories as $category)<option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>@endforeach</select>@error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-4"><label for="price" class="form-label">Unit price (USD) *</label><input id="price" name="price" type="number" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" min="0" step="0.01" required>@error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-4"><label for="quantity" class="form-label">Quantity on hand *</label><input id="quantity" name="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', 0) }}" min="0" step="1" required>@error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-4"><label for="created_date" class="form-label">Record date *</label><input id="created_date" name="created_date" type="date" class="form-control @error('created_date') is-invalid @enderror" value="{{ old('created_date', now()->toDateString()) }}" required>@error('created_date')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-12"><label for="description" class="form-label">Description</label><textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="4" maxlength="5000">{{ old('description') }}</textarea>@error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-4"><a href="{{ route('products.index') }}" class="btn btn-outline-dark px-3">Cancel</a><button type="submit" class="btn btn-primary px-4"><i class="fas fa-check me-2" aria-hidden="true"></i>Create product</button></div>
            </form>
        </div>
    </section>
</div>
@endsection
