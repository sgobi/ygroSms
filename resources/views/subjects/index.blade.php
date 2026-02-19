@extends('layouts.app')
@section('title', 'Subjects')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-journal-bookmark me-2"></i>Subjects</h5>
    <a href="{{ route('subjects.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> Add Subject</a>
</div>
<div class="card mb-3">
    <div class="card-body py-2">
        <form class="row g-2 align-items-end" method="GET">
            <div class="col-sm-4">
                <select name="grade" class="form-select form-select-sm">
                    <option value="">All Grades</option>
                    @for($g=1;$g<=13;$g++)
                        <option value="{{ $g }}" @selected(request('grade')==$g)>Grade {{ $g }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-sm-2">
                <button class="btn btn-primary btn-sm">Filter</button>
                <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary btn-sm">✕</a>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>Subject</th><th>Grades</th><th>Stream</th><th>Optional?</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($subjects as $s)
                <tr>
                    <td class="fw-semibold">{{ $s->name }}</td>
                    <td><span class="badge-grade">{{ $s->grade_from }}–{{ $s->grade_to }}</span></td>
                    <td>{{ $s->stream?->name ?? 'All' }}</td>
                    <td>{!! $s->is_optional ? '<span class="badge bg-warning text-dark">Optional</span>' : '<span class="text-muted">–</span>' !!}</td>
                    <td>
                        <a href="{{ route('subjects.edit', $s) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('subjects.destroy', $s) }}" class="d-inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No subjects yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($subjects->hasPages())<div class="card-footer d-flex justify-content-center">{{ $subjects->onEachSide(1)->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
