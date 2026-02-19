@extends('layouts.app')
@section('title', $publicExam->name)
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('public-exams.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
    <h5 class="mb-0 fw-bold text-primary">{{ $publicExam->name }}</h5>
    <span class="badge bg-secondary ms-2">{{ $publicExam->exam_date ? $publicExam->exam_date->format('d M Y') : 'Date TBD' }}</span>
    <div class="ms-auto d-flex gap-2">
        <a href="{{ route('public-exams.report', $publicExam) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-file-earmark-pdf me-1"></i>Download Report</a>
        <a href="{{ route('public-exams.results.create', $publicExam) }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Add Result</a>
    </div>
</div>

@if($publicExam->description)
<div class="alert alert-light border mb-4">{{ $publicExam->description }}</div>
@endif

<div class="card">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-bold">Student Results ({{ $publicExam->studentPublicExams->count() }})</h6>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Index No</th>
                    <th>Results</th>
                    <th>Result File</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($publicExam->studentPublicExams as $i => $entry)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td class="fw-semibold">
                        <a href="{{ route('students.show', $entry->student) }}" class="text-decoration-none">{{ $entry->student->name }}</a>
                    </td>
                    <td><span class="font-monospace text-muted">{{ $entry->index_number }}</span></td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                        @foreach($entry->results as $res)
                            <span class="badge bg-light text-dark border">{{ $res->subject->name }}: <b>{{ $res->grade }}</b></span>
                        @endforeach
                        </div>
                    </td>
                    <td>
                        @if($entry->result_file_path)
                            <a href="{{ route('public-exams.results.download', $entry) }}" class="btn btn-sm btn-outline-secondary" title="Download Result Sheet">
                                <i class="bi bi-file-earmark-pdf text-danger"></i> Format
                            </a>
                        @else
                            <span class="text-muted small">–</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <form action="{{ route('public-exams.results.destroy', $entry) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove result for {{ $entry->student->name }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-5">No results recorded yet. Click "Add Student Result" to begin.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
