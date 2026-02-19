@extends('layouts.app')
@section('title', 'Marks Ledger')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-pencil-square me-2"></i>Marks</h5>
    <a href="{{ route('marks.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> Enter Marks</a>
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
            <div class="col-sm-2">
                <select name="academic_year_id" class="form-select form-select-sm">
                    <option value="">All Years</option>
                    @foreach($academicYears as $y)
                        <option value="{{ $y->id }}" @selected(request('academic_year_id')==$y->id)>{{ $y->year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2">
                <select name="term" class="form-select form-select-sm">
                    <option value="">All Terms</option>
                    <option value="1" @selected(request('term')==1)>Term 1</option>
                    <option value="2" @selected(request('term')==2)>Term 2</option>
                    <option value="3" @selected(request('term')==3)>Term 3</option>
                </select>
            </div>
            <div class="col-sm-2 d-flex gap-1">
                <button class="btn btn-primary btn-sm flex-fill">Filter</button>
                <a href="{{ route('marks.index') }}" class="btn btn-outline-secondary btn-sm">✕</a>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>Student</th><th>Year</th><th>Term</th><th>Subject</th><th>Marks</th><th>Grade</th><th></th></tr></thead>
            <tbody>
            @forelse($marks as $m)
                <tr>
                    <td><a href="{{ route('students.show', $m->student) }}" class="text-decoration-none">{{ $m->student->name }}</a></td>
                    <td>{{ $m->academicYear->year }}</td>
                    <td>T{{ $m->term }}</td>
                    <td>{{ $m->subject->name }}</td>
                    <td class="fw-semibold">{{ $m->marks }}</td>
                    <td>
                        @php $cl = ['A'=>'success','B'=>'primary','C'=>'info','S'=>'secondary','W'=>'danger'][$m->grade_letter] ?? 'secondary'; @endphp
                        <span class="badge bg-{{ $cl }}">{{ $m->grade_letter }}</span>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('marks.destroy', $m) }}" class="d-inline" onsubmit="return confirm('Delete mark?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No marks found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($marks->hasPages())<div class="card-footer">{{ $marks->links() }}</div>@endif
</div>
@endsection
