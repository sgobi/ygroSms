@extends('layouts.app')
@section('title', 'Year-wise Expense')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold text-primary">Year-wise Expense Report</h5>
    <a href="{{ route('reports.expense', ['pdf'=>1]) }}" class="btn btn-outline-danger btn-sm ms-auto">
        <i class="bi bi-file-pdf me-1"></i>Download PDF
    </a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>Academic Year</th><th>Total Items</th><th>Total Expense</th></tr></thead>
            <tbody>
            @php $grandTotal = 0; $grandQty = 0; @endphp
            @forelse($years as $row)
                @php $grandTotal += $row->total_expense; $grandQty += $row->total_quantity; @endphp
                <tr>
                    <td class="fw-semibold">{{ $row->academicYear->year }}</td>
                    <td>{{ $row->total_quantity }}</td>
                    <td>Rs. {{ number_format($row->total_expense, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center text-muted py-4">No data available.</td></tr>
            @endforelse
            @if($years->isNotEmpty())
            <tr class="table-light fw-bold">
                <td>Grand Total</td>
                <td>{{ $grandQty }}</td>
                <td>Rs. {{ number_format($grandTotal, 2) }}</td>
            </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
