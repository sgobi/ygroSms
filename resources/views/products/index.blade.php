@extends('layouts.app')
@section('title', 'Products')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-box-seam me-2"></i>Welfare Products</h5>
    <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> Add Product</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>Product</th><th>Description</th><th>Price (Rs.)</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($products as $p)
                <tr>
                    <td class="fw-semibold">{{ $p->name }}</td>
                    <td class="text-muted small">{{ $p->description ?? '–' }}</td>
                    <td>{{ number_format($p->price, 2) }}</td>
                    <td>
                        <a href="{{ route('products.edit', $p) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('products.destroy', $p) }}" class="d-inline" onsubmit="return confirm('Delete product?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-4">No products yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())<div class="card-footer">{{ $products->links() }}</div>@endif
</div>
@endsection
