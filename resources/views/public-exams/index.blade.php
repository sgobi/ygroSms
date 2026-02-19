@extends('layouts.app')
@section('title', 'Public Exam Results')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-award me-2"></i>Public Exam Results</h5>
    <a href="{{ route('public-exams.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i>Add Result</a>
</div>

{{-- Filters --}}
<div class="card mb-3">
    <div class="card-body py-2">
        <form class="row g-2 align-items-end" method="GET">
            <div class="col-sm-4">
                <select name="student_id" class="form-select form-select-sm">
                    <option value="">All Students</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}" @selected(request('student_id')==$s->id)>{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2">
                <select name="exam_type" class="form-select form-select-sm">
                    <option value="">All Types</option>
                    <option value="OL" @selected(request('exam_type')=='OL')>O/L Exam</option>
                    <option value="AL" @selected(request('exam_type')=='AL')>A/L Exam</option>
                </select>
            </div>
            <div class="col-sm-2">
                <select name="exam_year" class="form-select form-select-sm">
                    <option value="">All Years</option>
                    @foreach($examYears as $yr)
                        <option value="{{ $yr }}" @selected(request('exam_year')==$yr)>{{ $yr }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2">
                <button class="btn btn-primary btn-sm">Filter</button>
                <a href="{{ route('public-exams.index') }}" class="btn btn-outline-secondary btn-sm">✕</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Exam</th>
                    <th>Year</th>
                    <th>Index No.</th>
                    <th>Subjects</th>
                    <th>Grades</th>
                    <th>Sheet</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($results as $r)
                <tr>
                    <td>
                        <a href="{{ route('students.show', $r->student) }}" class="fw-semibold text-decoration-none">{{ $r->student->name }}</a>
                        <div class="text-muted small">Gr. {{ $r->student->current_grade }}</div>
                    </td>
                    <td>
                        <span class="badge bg-{{ $r->exam_type === 'OL' ? 'info text-dark' : 'dark' }}">{{ $r->exam_type }}</span>
                    </td>
                    <td class="fw-semibold">{{ $r->exam_year }}</td>
                    <td class="font-monospace text-primary">{{ $r->index_number }}</td>
                    <td class="small text-muted">{{ $r->subjects->count() }} subject{{ $r->subjects->count() != 1 ? 's' : '' }}</td>
                    <td>
                        @foreach($r->subjects->take(4) as $sub)
                            <span class="badge bg-{{ \App\Models\PublicExamResult::gradeColor($sub->grade) }} me-1">{{ $sub->grade }}</span>
                        @endforeach
                        @if($r->subjects->count() > 4)
                            <span class="text-muted small">+{{ $r->subjects->count()-4 }}</span>
                        @endif
                    </td>
                    <td>
                        @if($r->result_sheet_path)
                            <a href="{{ Storage::url($r->result_sheet_path) }}" target="_blank" class="btn btn-sm btn-outline-success" title="View Sheet">
                                <i class="bi bi-file-earmark-text"></i>
                            </a>
                        @else
                            <span class="text-muted small fst-italic">–</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('public-exams.show', $r) }}" class="btn btn-sm btn-outline-primary" title="View">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('public-exams.edit', $r) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('public-exams.destroy', $r) }}" class="d-inline" onsubmit="return confirm('Delete this result?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted py-4">No public exam results recorded yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($results->hasPages())
        <div class="card-footer d-flex justify-content-center">{{ $results->links() }}</div>
    @endif
</div>
@endsection
