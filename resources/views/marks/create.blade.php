@extends('layouts.app')
@section('title', 'Enter Marks')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('marks.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold text-primary">Enter Marks</h5>
</div>

{{-- Step 1: Select student first --}}
@if(!$selectedStudent)
<div class="card" style="max-width:480px;">
    <div class="card-body">
        <form method="GET" action="{{ route('marks.create') }}">
            <div class="mb-3">
                <label class="form-label fw-semibold small">Select Student <span class="text-danger">*</span></label>
                <select name="student_id" class="form-select" required>
                    <option value="">-- Select --</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}">{{ $s->name }} (Grade {{ $s->current_grade }})</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-primary">Continue →</button>
        </form>
    </div>
</div>
@else
{{-- Step 2: Enter marks for all subjects --}}
<div class="alert alert-info py-2 mb-3">
    <strong>Student:</strong> {{ $selectedStudent->name }} &nbsp;|&nbsp;
    <strong>Grade:</strong> {{ $selectedStudent->current_grade }} &nbsp;|&nbsp;
    <strong>Stream:</strong> {{ $selectedStudent->stream?->name ?? 'N/A' }}
</div>

<form method="POST" action="{{ route('marks.store') }}">
    @csrf
    <input type="hidden" name="student_id" value="{{ $selectedStudent->id }}">
    <input type="hidden" name="grade" value="{{ $selectedStudent->current_grade }}">

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <label class="form-label fw-semibold small">Academic Year <span class="text-danger">*</span></label>
            <select name="academic_year_id" class="form-select" required>
                @foreach($academicYears as $y)
                    <option value="{{ $y->id }}" @selected($y->is_active)>{{ $y->year }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold small">Term <span class="text-danger">*</span></label>
            <select name="term" class="form-select" required>
                <option value="1">Term 1</option>
                <option value="2">Term 2</option>
                <option value="3">Term 3</option>
            </select>
        </div>
    </div>

    <div class="card">
        <div class="card-header fw-semibold py-2"><i class="bi bi-pencil-square me-2 text-primary"></i>Marks Entry</div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead><tr><th>Subject</th><th style="width:150px;">Marks (0–100)</th><th>Remarks</th></tr></thead>
                <tbody>
                @forelse($subjects as $index => $subj)
                    <tr>
                        <td class="fw-semibold">
                            {{ $subj->name }}
                            @if($subj->is_optional)<span class="badge bg-warning text-dark ms-1">Optional</span>@endif
                            <input type="hidden" name="marks[{{ $index }}][subject_id]" value="{{ $subj->id }}">
                        </td>
                        <td><input type="number" name="marks[{{ $index }}][marks]" class="form-control form-control-sm" min="0" max="100" step="0.5" placeholder="–"></td>
                        <td><input type="text" name="marks[{{ $index }}][remarks]" class="form-control form-control-sm" placeholder="Optional"></td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-muted py-3">No subjects available for this student's grade/stream.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($subjects->isNotEmpty())
        <div class="card-footer">
            <button class="btn btn-primary"><i class="bi bi-save me-1"></i>Save All Marks</button>
        </div>
        @endif
    </div>
</form>
@endif
@endsection
