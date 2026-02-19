@extends('layouts.app')
@section('title', $student->name)

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="mb-0 fw-bold text-primary">{{ $student->name }}</h5>
        <small class="text-muted">Grade {{ $student->current_grade }} · {{ $student->gradeGroup }}</small>
    </div>
    <div class="ms-auto">
        <a href="{{ route('students.edit', $student) }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <a href="{{ route('marks.create', ['student_id' => $student->id]) }}" class="btn btn-primary btn-sm ms-1">
            <i class="bi bi-pencil-square me-1"></i>Enter Marks
        </a>
    </div>
</div>

<div class="row g-3">
    {{-- Personal Details --}}
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header fw-semibold py-2"><i class="bi bi-person me-2 text-primary"></i>Personal Details</div>
            <div class="card-body">
                <dl class="row mb-0 small">
                    <dt class="col-5 text-muted">DOB</dt><dd class="col-7">{{ $student->dob?->format('d M Y') ?? '–' }}</dd>
                    <dt class="col-5 text-muted">Gender</dt><dd class="col-7">{{ $student->gender ?? '–' }}</dd>
                    <dt class="col-5 text-muted">Address</dt><dd class="col-7">{{ $student->address ?? '–' }}</dd>
                    <dt class="col-5 text-muted">Parent</dt><dd class="col-7">{{ $student->parent_name ?? '–' }}</dd>
                    <dt class="col-5 text-muted">Contact</dt><dd class="col-7">{{ $student->contact ?? '–' }}</dd>
                    <dt class="col-5 text-muted">Admitted</dt><dd class="col-7">{{ $student->admission_year }}</dd>
                    <dt class="col-5 text-muted">O/L Index</dt><dd class="col-7">{{ $student->ol_index ?? '–' }}</dd>
                    <dt class="col-5 text-muted">A/L Index</dt><dd class="col-7">{{ $student->al_index ?? '–' }}</dd>
                    <dt class="col-5 text-muted">Stream</dt><dd class="col-7">{{ $student->stream?->name ?? '–' }}</dd>
                </dl>
            </div>
        </div>
    </div>

    {{-- School History --}}
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center py-2">
                <span class="fw-semibold"><i class="bi bi-building me-2 text-primary"></i>School History</span>
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addSchoolModal">
                    <i class="bi bi-plus"></i> Add School
                </button>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0 small">
                    <thead><tr><th>School</th><th>From</th><th>To</th></tr></thead>
                    <tbody>
                    @forelse($student->schoolHistories as $h)
                        <tr>
                            <td>{{ $h->school->name }}</td>
                            <td>{{ $h->from_year }}</td>
                            <td>{!! $h->to_year ?? '<span class="badge bg-success">Current</span>' !!}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-2">No school history.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Marks --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center py-2">
                <span class="fw-semibold"><i class="bi bi-journal me-2 text-primary"></i>Recent Marks</span>
                <a href="{{ route('reports.history', ['student_id' => $student->id]) }}" class="btn btn-sm btn-outline-secondary">Full History</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0 small">
                    <thead><tr><th>Year</th><th>Term</th><th>Subject</th><th>Marks</th><th>Grade</th></tr></thead>
                    <tbody>
                    @forelse($student->marks->sortByDesc('id')->take(8) as $m)
                        <tr>
                            <td>{{ $m->academicYear->year }}</td>
                            <td>T{{ $m->term }}</td>
                            <td>{{ $m->subject->name }}</td>
                            <td>{{ $m->marks }}</td>
                            <td><span class="badge bg-{{ $m->grade_letter == 'A' ? 'success' : ($m->grade_letter == 'W' ? 'danger' : 'secondary') }}">{{ $m->grade_letter }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-2">No marks recorded.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Welfare --}}
<div class="card mt-3">
    <div class="card-header fw-semibold py-2">
        <i class="bi bi-gift me-2 text-warning"></i>Welfare Distributions
    </div>
    <div class="card-body p-0">
        <table class="table mb-0 small">
            <thead><tr><th>Year</th><th>Product</th><th>Qty</th><th>Unit Price</th><th>Total</th><th>Date</th></tr></thead>
            <tbody>
            @forelse($student->distributions as $d)
                <tr>
                    <td>{{ $d->academicYear->year }}</td>
                    <td>{{ $d->product->name }}</td>
                    <td>{{ $d->quantity }}</td>
                    <td>Rs. {{ number_format($d->unit_price, 2) }}</td>
                    <td>Rs. {{ number_format($d->quantity * $d->unit_price, 2) }}</td>
                    <td>{{ $d->date_given->format('d M Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-2">No distributions.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Add School Modal --}}
<div class="modal fade" id="addSchoolModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header"><h6 class="modal-title">Add School History</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <form method="POST" action="{{ route('students.addSchoolHistory', $student) }}">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label small fw-semibold">School</label>
                    <select name="school_id" class="form-select" required>
                        @foreach(\App\Models\School::orderBy('name')->get() as $school)
                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label small fw-semibold">From Year</label>
                        <input type="number" name="from_year" class="form-control" value="{{ date('Y') }}" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-semibold">To Year (leave blank if current)</label>
                        <input type="number" name="to_year" class="form-control" placeholder="Current">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary">Save</button>
                <button class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div></div>
</div>
@endsection
