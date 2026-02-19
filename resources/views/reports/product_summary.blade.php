@extends('layouts.app')
@section('title', 'Product Summary')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold text-primary">Product Summary Report</h5>
    <a href="{{ route('reports.productSummary', ['pdf'=>1]) }}" class="btn btn-outline-danger btn-sm ms-auto">
        <i class="bi bi-file-pdf me-1"></i>Download PDF
    </a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>Product</th><th>Unit Price</th><th>Total Qty Distributed</th><th>Total Value</th></tr></thead>
            <tbody>
            @php $grand = 0; @endphp
            @forelse($products as $p)
                @php $grand += $p->total_value ?? 0; @endphp
                <tr>
                    <td class="fw-semibold">{{ $p->name }}@if($p->trashed()) <span class="badge bg-secondary ms-1">Archived</span>@endif</td>
                    <td>Rs. {{ number_format($p->price, 2) }}</td>
                    <td>{{ $p->total_quantity ?? 0 }}</td>
                    <td>Rs. {{ number_format($p->total_value ?? 0, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-4">No products.</td></tr>
            @endforelse
            @if($products->isNotEmpty())
            <tr class="table-light fw-bold">
                <td colspan="3">Total</td>
                <td>Rs. {{ number_format($grand, 2) }}</td>
            </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
