@extends('layouts.app')
@section('title', 'New Public Exam')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('public-exams.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
    <h5 class="mb-0 fw-bold text-primary">New Public Exam</h5>
</div>

<div class="card col-md-8 mx-auto">
    <div class="card-body">
        <form action="{{ route('public-exams.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Exam Name</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. G.C.E. O/L 2024" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Exam Date</label>
                <input type="date" name="exam_date" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Description (Optional)</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <button class="btn btn-primary"><i class="bi bi-save me-1"></i> Save Exam</button>
        </form>
    </div>
</div>
@endsection
