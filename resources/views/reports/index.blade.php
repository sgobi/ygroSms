@extends('layouts.app')
@section('title', 'Reports & PDFs')
@section('content')
<h5 class="fw-bold text-primary mb-4"><i class="bi bi-file-earmark-bar-graph me-2"></i>Reports & PDF Downloads</h5>

<div class="row g-3">
    {{-- Term Report --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header fw-semibold py-2"><i class="bi bi-journal-text me-2"></i>Term Report</div>
            <div class="card-body">
                <form method="GET" action="{{ route('reports.term') }}">
                    <div class="row g-2">
                        <div class="col-12">
                            <select name="student_id" class="form-select form-select-sm" required>
                                <option value="">Select Student</option>
                                @foreach($students as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <select name="academic_year_id" class="form-select form-select-sm" required>
                                @foreach($academicYears as $y)<option value="{{ $y->id }}">{{ $y->year }}</option>@endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <select name="term" class="form-select form-select-sm" required>
                                <option value="1">Term 1</option><option value="2">Term 2</option><option value="3">Term 3</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3 d-flex gap-2">
                        <button class="btn btn-primary btn-sm">View Online</button>
                        <button name="pdf" value="1" class="btn btn-outline-danger btn-sm"><i class="bi bi-file-pdf me-1"></i>Download PDF</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Year Report --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header fw-semibold py-2"><i class="bi bi-calendar2-week me-2"></i>Year Report</div>
            <div class="card-body">
                <form method="GET" action="{{ route('reports.year') }}">
                    <div class="row g-2">
                        <div class="col-12">
                            <select name="student_id" class="form-select form-select-sm" required>
                                <option value="">Select Student</option>
                                @foreach($students as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <select name="academic_year_id" class="form-select form-select-sm" required>
                                @foreach($academicYears as $y)<option value="{{ $y->id }}">{{ $y->year }}</option>@endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-3 d-flex gap-2">
                        <button class="btn btn-primary btn-sm">View Online</button>
                        <button name="pdf" value="1" class="btn btn-outline-danger btn-sm"><i class="bi bi-file-pdf me-1"></i>Download PDF</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Academic History --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header fw-semibold py-2"><i class="bi bi-clock-history me-2"></i>Full Academic History</div>
            <div class="card-body">
                <form method="GET" action="{{ route('reports.history') }}">
                    <select name="student_id" class="form-select form-select-sm" required>
                        <option value="">Select Student</option>
                        @foreach($students as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                    <div class="mt-3 d-flex gap-2">
                        <button class="btn btn-primary btn-sm">View Online</button>
                        <button name="pdf" value="1" class="btn btn-outline-danger btn-sm"><i class="bi bi-file-pdf me-1"></i>Download PDF</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Distribution Report --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header fw-semibold py-2"><i class="bi bi-gift me-2"></i>Student Distribution Report</div>
            <div class="card-body">
                <form method="GET" action="{{ route('reports.distribution') }}">
                    <select name="student_id" class="form-select form-select-sm" required>
                        <option value="">Select Student</option>
                        @foreach($students as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                    <div class="mt-3 d-flex gap-2">
                        <button class="btn btn-primary btn-sm">View Online</button>
                        <button name="pdf" value="1" class="btn btn-outline-danger btn-sm"><i class="bi bi-file-pdf me-1"></i>Download PDF</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Year-wise Expense --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header fw-semibold py-2"><i class="bi bi-graph-up-arrow me-2"></i>Year-wise Expense</div>
            <div class="card-body">
                <p class="text-muted small mb-3">Shows total welfare spend per academic year.</p>
                <form method="GET" action="{{ route('reports.expense') }}">
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary btn-sm">View Online</button>
                        <button name="pdf" value="1" class="btn btn-outline-danger btn-sm"><i class="bi bi-file-pdf me-1"></i>Download PDF</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Product Summary --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header fw-semibold py-2"><i class="bi bi-box-seam me-2"></i>Product Summary</div>
            <div class="card-body">
                <p class="text-muted small mb-3">Total quantity and value distributed per product.</p>
                <form method="GET" action="{{ route('reports.productSummary') }}">
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary btn-sm">View Online</button>
                        <button name="pdf" value="1" class="btn btn-outline-danger btn-sm"><i class="bi bi-file-pdf me-1"></i>Download PDF</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
