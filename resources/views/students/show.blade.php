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
                    <dt class="col-5 text-muted">Medical Contact Name</dt><dd class="col-7">{{ $student->medical_emergency_name ?? '–' }}</dd>
                    <dt class="col-5 text-muted">Medical Contact No</dt><dd class="col-7">{{ $student->medical_emergency_contact ?? '–' }}</dd>
                    <dt class="col-5 text-muted">GN Div</dt><dd class="col-7">{{ $student->gn_division ?? '–' }}</dd>
                    <dt class="col-5 text-muted">GS Div</dt><dd class="col-7">{{ $student->gs_division ?? '–' }}</dd>
                    <dt class="col-5 text-muted">Admission No</dt><dd class="col-7 font-monospace">{{ $student->admission_number ?? '–' }}</dd>
                    <dt class="col-5 text-muted">Admitted</dt><dd class="col-7">{{ $student->admission_year }}</dd>
                    <dt class="col-5 text-muted">O/L Index</dt><dd class="col-7">{{ $student->ol_index ?? '–' }}</dd>
                    <dt class="col-5 text-muted">A/L Index</dt><dd class="col-7">{{ $student->al_index ?? '–' }}</dd>
                    <dt class="col-5 text-muted">Stream</dt><dd class="col-7">{{ $student->stream?->name ?? '–' }}</dd>
                </dl>
                
                <div class="mt-3 pt-3 border-top">
                    <h6 class="small fw-bold text-uppercase text-muted mb-2">Main Caregiver</h6>
                    @if($student->caregiver)
                        <div class="small">
                            <div class="fw-semibold text-dark">{{ $student->caregiver->title }} {{ $student->caregiver->name }}</div>
                            @if($student->caregiver->mobile)
                                <div class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $student->caregiver->mobile }}</div>
                            @endif
                            @if($student->caregiver->occupation)
                                <div class="text-muted"><i class="bi bi-briefcase me-1"></i>{{ $student->caregiver->occupation }}</div>
                            @endif
                            @if($student->caregiver->address)
                                <div class="text-muted mt-1"><i class="bi bi-geo-alt me-1"></i>{{ $student->caregiver->address }}</div>
                            @endif
                        </div>
                    @else
                        <div class="text-muted small fst-italic">No caregiver details.</div>
                    @endif
                </div>

                <div class="mt-3 pt-3 border-top">
                    <h6 class="small fw-bold text-uppercase text-muted mb-2">Sponsorship</h6>
                    @if($student->donor)
                        <div class="d-flex align-items-center bg-light p-2 rounded border">
                            <i class="bi bi-heart-fill text-danger fs-5 me-2"></i>
                            <div>
                                <div class="fw-semibold text-dark">{{ $student->donor->title }} {{ $student->donor->name }}</div>
                                <div class="small text-muted">{{ $student->donor->phone }}</div>
                            </div>
                            <a href="{{ route('donors.edit', $student->donor) }}" class="btn btn-sm btn-link text-decoration-none ms-auto"><i class="bi bi-pencil-square"></i></a>
                        </div>
                    @else
                        <div class="text-muted small fst-italic">No donor assigned. <a href="{{ route('students.edit', $student) }}">Assign now</a></div>
                    @endif
                </div>
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


        {{-- Public Exams --}}
        @if($student->publicExamEntries->isNotEmpty())
        <div class="card mb-3">
            <div class="card-header fw-semibold py-2">
                <i class="bi bi-mortarboard me-2 text-info"></i>Public Exam Results
            </div>
            <div class="card-body p-0">
                <table class="table mb-0 small">
                    <thead><tr><th>Exam</th><th>Index</th><th>Results</th><th>File</th></tr></thead>
                    <tbody>
                    @foreach($student->publicExamEntries as $pe)
                        <tr>
                            <td>{{ $pe->publicExam->name }}</td>
                            <td class="font-monospace text-muted">{{ $pe->index_number }}</td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                @foreach($pe->results as $r)
                                    <span class="badge border bg-light text-dark">{{ $r->subject->name }}: {{ $r->grade }}</span>
                                @endforeach
                                </div>
                            </td>
                            <td>
                                @if($pe->result_file_path)
                                <a href="{{ route('public-exams.results.download', $pe) }}" class="text-danger" title="Result Sheet"><i class="bi bi-file-pdf"></i></a>
                                @else – @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

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

        {{-- Disciplinary History --}}
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center py-2">
                <span class="fw-semibold text-danger"><i class="bi bi-shield-check me-2"></i>Tracking History</span>
                <a href="{{ route('discipline.create', ['student_id' => $student->id]) }}" class="btn btn-sm btn-outline-danger">Track Participation</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0 small">
                    <thead><tr><th>Year</th><th>Month</th><th class="text-center">Meeting</th><th class="text-center">Bill</th><th>Status</th></tr></thead>
                    <tbody>
                    @forelse($student->disciplinaryRecords as $dr)
                        <tr>
                            <td>{{ $dr->academicYear->year }}</td>
                            <td>{{ $dr->month_name }}</td>
                            <td class="text-center">
                                @if($dr->meeting_participated)
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                @else
                                    <i class="bi bi-x-circle-fill text-danger"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($dr->bill_submitted)
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                @else
                                    <i class="bi bi-x-circle-fill text-danger"></i>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusClass = match($dr->status) {
                                        'Good' => 'bg-success',
                                        'Pending Bill' => 'bg-info text-dark',
                                        'No Meeting' => 'bg-primary',
                                        'Warning' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }}">
                                    {{ $dr->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-2">No tracking records found.</td></tr>
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
