@extends('layouts.app')
@section('title', 'Edit School')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('schools.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold text-primary">Edit School</h5>
</div>
<div class="card" style="max-width:540px;">
    <div class="card-body">
        <form method="POST" action="{{ route('schools.update', $school) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold small">School Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $school->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold small">Address</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $school->address) }}">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold small">Contact</label>
                <input type="text" name="contact" class="form-control" value="{{ old('contact', $school->contact) }}">
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold small">Principal Name</label>
                <input type="text" name="principal_name" class="form-control" value="{{ old('principal_name', $school->principal_name) }}">
            </div>
            <button class="btn btn-primary"><i class="bi bi-check-circle me-1"></i>Update School</button>
            <a href="{{ route('schools.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
