@extends('layouts.app')
@section('title', 'Add Product')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold text-primary">Add Product</h5>
</div>
<div class="card" style="max-width:480px;">
    <div class="card-body">
        <form method="POST" action="{{ route('products.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold small">Product Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold small">Description</label>
                <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold small">Price (Rs.) <span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control" value="{{ old('price', 0) }}" min="0" step="0.01" required>
            </div>
            <button class="btn btn-primary"><i class="bi bi-check-circle me-1"></i>Save Product</button>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
