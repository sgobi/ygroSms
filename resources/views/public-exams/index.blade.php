@extends('layouts.app')
@section('title', 'Public Exams')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-mortarboard me-2"></i>Public Exams</h5>
    <a href="{{ route('public-exams.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> New Exam</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Exam Name</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($exams as $exam)
                <tr>
                    <td class="fw-semibold">
                        <a href="{{ route('public-exams.show', $exam) }}" class="text-decoration-none">{{ $exam->name }}</a>
                    </td>
                    <td>{{ $exam->exam_date ? $exam->exam_date->format('d M Y') : '–' }}</td>
                    <td class="text-muted small">{{ Str::limit($exam->description, 50) }}</td>
                    <td class="text-end">
                        <a href="{{ route('public-exams.show', $exam) }}" class="btn btn-sm btn-outline-info" title="View Results"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('public-exams.edit', $exam) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('public-exams.destroy', $exam) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this exam?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-4">No public exams recorded.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
