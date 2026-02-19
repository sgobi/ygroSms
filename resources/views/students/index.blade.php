@extends('layouts.app')
@section('title', 'Students')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-people me-2"></i>Students</h5>
    <a href="{{ route('students.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Add Student
    </a>
</div>

{{-- Filters --}}
<div class="card mb-3">
    <div class="card-body py-2">
        <form class="row g-2 align-items-end" method="GET">
            <div class="col-sm-4">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by name…" value="{{ request('search') }}">
            </div>
            <div class="col-sm-3">
                <select name="grade" class="form-select form-select-sm">
                    <option value="">All Grades</option>
                    @for($g=1;$g<=13;$g++)
                        <option value="{{ $g }}" @selected(request('grade')==$g)>Grade {{ $g }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-sm-3">
                <select name="stream_id" class="form-select form-select-sm">
                    <option value="">All Streams</option>
                    @foreach($streams as $stream)
                        <option value="{{ $stream->id }}" @selected(request('stream_id')==$stream->id)>{{ $stream->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2 d-flex gap-1">
                <button class="btn btn-primary btn-sm flex-fill">Filter</button>
                <a href="{{ route('students.index') }}" class="btn btn-outline-secondary btn-sm">✕</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Grade</th>
                    <th>Stream</th>
                    <th>Contact</th>
                    <th>Current School</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($students as $student)
                <tr>
                    <td class="text-muted small">{{ $student->id }}</td>
                    <td>
                        <a href="{{ route('students.show', $student) }}" class="fw-semibold text-decoration-none">{{ $student->name }}</a>
                        <div class="text-muted small">Adm: {{ $student->admission_year }}</div>
                    </td>
                    <td><span class="badge-grade">Gr. {{ $student->current_grade }}</span></td>
                    <td>{{ $student->stream?->name ?? '–' }}</td>
                    <td class="text-muted small">{{ $student->contact ?? '–' }}</td>
                    <td class="small">{{ $student->currentSchool?->school?->name ?? '–' }}</td>
                    <td>
                        <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-info" title="View"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('students.destroy', $student) }}" class="d-inline"
                            onsubmit="return confirm('Delete {{ addslashes($student->name) }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No students found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($students->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center">
        <small class="text-muted">Showing {{ $students->firstItem() }}–{{ $students->lastItem() }} of {{ $students->total() }}</small>
        {{ $students->links() }}
    </div>
    @endif
</div>
@endsection
