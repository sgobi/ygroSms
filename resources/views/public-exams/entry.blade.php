@extends('layouts.app')
@section('title', 'Add Exam Result')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('public-exams.show', $publicExam) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
    <h5 class="mb-0 fw-bold text-primary">Add Result — {{ $publicExam->name }}</h5>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('public-exams.results.store', $publicExam) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Student</label>
                    <select name="student_id" class="form-select" required>
                        <option value="">Select Student...</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->gradeGroup }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Index Number</label>
                    <input type="text" name="index_number" class="form-control" placeholder="e.g. 23456789" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Result Sheet (PDF/Image)</label>
                    <input type="file" name="result_file" class="form-control" accept=".pdf,image/*">
                    <div class="form-text">Optional. Upload the official result sheet (Max 5MB).</div>
                </div>
            </div>

            <hr>
            <h6 class="fw-bold mb-3">Subject Results</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="resultsTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60%">Subject</th>
                            <th>Grade (A, B, C, S, W, etc.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=0; $i<12; $i++)
                        <tr>
                            <td>
                                <select name="results[{{ $i }}][subject_id]" class="form-select form-select-sm">
                                    <option value="">Select Subject...</option>
                                    @foreach($subjects as $sub)
                                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="results[{{ $i }}][grade]" class="form-control form-control-sm text-uppercase" placeholder="Grade">
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Save Results</button>
            </div>
        </form>
    </div>
</div>
@endsection
