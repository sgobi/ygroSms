@extends('layouts.app')
@section('title', 'Record Distribution')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('distributions.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold text-primary">Record Distribution</h5>
</div>
<div class="card" style="max-width:580px;">
    <div class="card-body">
        <form method="POST" action="{{ route('distributions.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold small">Student <span class="text-danger">*</span></label>
                <select name="student_id" class="form-select" required>
                    <option value="">Select Student</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}" @selected(old('student_id')==$s->id)>{{ $s->name }} (Grade {{ $s->current_grade }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold small">Product <span class="text-danger">*</span></label>
                <select name="product_id" class="form-select" required>
                    <option value="">Select Product</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}" @selected(old('product_id')==$p->id)>{{ $p->name }} (Rs. {{ number_format($p->price,2) }})</option>
                    @endforeach
                </select>
            </div>
            <div class="row g-2 mb-3">
                <div class="col-6">
                    <label class="form-label fw-semibold small">Academic Year <span class="text-danger">*</span></label>
                    <select name="academic_year_id" class="form-select" required>
                        @foreach($academicYears as $y)
                            <option value="{{ $y->id }}" @selected($y->is_active)>{{ $y->year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold small">Quantity <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 1) }}" min="1" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold small">Date Given <span class="text-danger">*</span></label>
                <input type="date" name="date_given" class="form-control" value="{{ old('date_given', date('Y-m-d')) }}" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold small">Notes</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
            </div>
            <button class="btn btn-primary"><i class="bi bi-check-circle me-1"></i>Save Distribution</button>
            <a href="{{ route('distributions.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
