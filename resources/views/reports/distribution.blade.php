@extends('layouts.app')
@section('title', 'Distribution Report')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold text-primary">Welfare Distribution — {{ $student->name }}</h5>
    <a href="{{ route('reports.distribution', array_merge(request()->all(), ['pdf'=>1])) }}" class="btn btn-outline-danger btn-sm ms-auto">
        <i class="bi bi-file-pdf me-1"></i>Download PDF
    </a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>Product</th><th>Year</th><th>Qty</th><th>Unit Price</th><th>Total</th><th>Date</th></tr></thead>
            <tbody>
            @forelse($distributions as $d)
                <tr>
                    <td>{{ $d->product->name }}</td>
                    <td>{{ $d->academicYear->year }}</td>
                    <td>{{ $d->quantity }}</td>
                    <td>Rs. {{ number_format($d->unit_price, 2) }}</td>
                    <td>Rs. {{ number_format($d->quantity * $d->unit_price, 2) }}</td>
                    <td class="text-muted small">{{ $d->date_given->format('d M Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No distributions.</td></tr>
            @endforelse
            @if($distributions->isNotEmpty())
            <tr class="table-light fw-bold"><td colspan="4">Total Support</td><td colspan="2">Rs. {{ number_format($total, 2) }}</td></tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
