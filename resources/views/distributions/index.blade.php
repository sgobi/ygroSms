@extends('layouts.app')
@section('title', 'Welfare Distributions')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-gift me-2"></i>Distributions</h5>
    <a href="{{ route('distributions.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> Record Distribution</a>
</div>
<div class="card mb-3">
    <div class="card-body py-2">
        <form class="row g-2 align-items-end" method="GET">
            <div class="col-sm-3">
                <select name="student_id" class="form-select form-select-sm">
                    <option value="">All Students</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}" @selected(request('student_id')==$s->id)>{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                <select name="product_id" class="form-select form-select-sm">
                    <option value="">All Products</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}" @selected(request('product_id')==$p->id)>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2">
                <select name="academic_year_id" class="form-select form-select-sm">
                    <option value="">All Years</option>
                    @foreach($academicYears as $y)
                        <option value="{{ $y->id }}" @selected(request('academic_year_id')==$y->id)>{{ $y->year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2 d-flex gap-1">
                <button class="btn btn-primary btn-sm flex-fill">Filter</button>
                <a href="{{ route('distributions.index') }}" class="btn btn-outline-secondary btn-sm">✕</a>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>Student</th><th>Product</th><th>Year</th><th>Qty</th><th>Unit Price</th><th>Total</th><th>Date</th><th></th></tr></thead>
            <tbody>
            @forelse($distributions as $d)
                <tr>
                    <td><a href="{{ route('students.show', $d->student) }}" class="text-decoration-none">{{ $d->student->name }}</a></td>
                    <td>{{ $d->product->name }}</td>
                    <td>{{ $d->academicYear->year }}</td>
                    <td>{{ $d->quantity }}</td>
                    <td>Rs. {{ number_format($d->unit_price, 2) }}</td>
                    <td class="fw-semibold">Rs. {{ number_format($d->quantity * $d->unit_price, 2) }}</td>
                    <td class="text-muted small">{{ $d->date_given->format('d M Y') }}</td>
                    <td>
                        <form method="POST" action="{{ route('distributions.destroy', $d) }}" class="d-inline" onsubmit="return confirm('Delete record?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted py-4">No distributions recorded.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($distributions->hasPages())<div class="card-footer">{{ $distributions->links() }}</div>@endif
</div>
@endsection
