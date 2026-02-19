@extends('layouts.app')
@section('title', 'Add Academic Year')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('academic-years.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold text-primary">Add Academic Year</h5>
</div>
<div class="card" style="max-width:400px;">
    <div class="card-body">
        <form method="POST" action="{{ route('academic-years.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold small">Year <span class="text-danger">*</span></label>
                <input type="number" name="year" class="form-control" value="{{ old('year', date('Y')) }}" min="2010" max="2100" required>
            </div>
            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1">
                <label class="form-check-label" for="is_active">Set as Active Year</label>
            </div>
            <button class="btn btn-primary"><i class="bi bi-check-circle me-1"></i>Save</button>
            <a href="{{ route('academic-years.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
