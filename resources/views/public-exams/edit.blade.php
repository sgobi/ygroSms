@extends('layouts.app')
@section('title', 'Edit Public Exam')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('public-exams.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
    <h5 class="mb-0 fw-bold text-primary">Edit Public Exam</h5>
</div>

<div class="card col-md-8 mx-auto">
    <div class="card-body">
        <form action="{{ route('public-exams.update', $publicExam) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Exam Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $publicExam->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Exam Date</label>
                <input type="date" name="exam_date" class="form-control" value="{{ old('exam_date', $publicExam->exam_date?->format('Y-m-d')) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Description (Optional)</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $publicExam->description) }}</textarea>
            </div>
            <button class="btn btn-primary"><i class="bi bi-pencil me-1"></i> Update Exam</button>
        </form>
    </div>
</div>
@endsection
