@extends('layouts.app')

@section('title', 'Edit ' . $product->name)

@section('content')
<div class="app-container">
    <header class="page-heading"><div><p class="eyebrow">Inventory / Edit record</p><h1>Update product</h1><p class="page-subtitle">{{ $product->name }} · Record #{{ $product->id }}</p></div><a href="{{ route('products.show', $product) }}" class="btn btn-outline-dark px-3 py-2"><i class="fas fa-arrow-left me-2" aria-hidden="true"></i>Product details</a></header>

    <section class="surface">
        <div class="surface-heading"><h2>Product details</h2><span class="badge bg-{{ $product->stock_status_class }}">{{ $product->stock_status }}</span></div>
        <div class="surface-body">
            <form action="{{ route('products.update', $product) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6"><label for="name" class="form-label">Product name *</label><input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" maxlength="255" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label for="category" class="form-label">Category *</label><select id="category" name="category" class="form-select @error('category') is-invalid @enderror" required>@foreach($categories as $category)<option value="{{ $category }}" @selected(old('category', $product->category) === $category)>{{ $category }}</option>@endforeach</select>@error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-4"><label for="price" class="form-label">Unit price (USD) *</label><input id="price" name="price" type="number" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" min="0" step="0.01" required>@error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-4"><label for="quantity" class="form-label">Quantity on hand *</label><input id="quantity" name="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $product->quantity) }}" min="0" step="1" required>@error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-4"><label for="created_date" class="form-label">Record date *</label><input id="created_date" name="created_date" type="date" class="form-control @error('created_date') is-invalid @enderror" value="{{ old('created_date', $product->created_date->format('Y-m-d')) }}" required>@error('created_date')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-12"><label for="description" class="form-label">Description</label><textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="4" maxlength="5000">{{ old('description', $product->description) }}</textarea>@error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-4"><a href="{{ route('products.show', $product) }}" class="btn btn-outline-dark px-3">Cancel</a><button type="submit" class="btn btn-primary px-4"><i class="fas fa-check me-2" aria-hidden="true"></i>Save changes</button></div>
            </form>
        </div>
    </section>
</div>
@endsection
