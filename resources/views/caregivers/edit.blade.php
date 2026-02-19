@extends('layouts.app')

@section('title', 'Edit Main Caregiver')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('caregivers.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold text-primary">Edit Main Caregiver</h5>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('caregivers.update', $caregiver->id) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label fw-semibold small">Title</label>
                    <select name="title" class="form-select">
                        <option value="">Select</option>
                        @foreach(['Mr', 'Mrs', 'Miss', 'Ms', 'Rev', 'Dr'] as $t)
                            <option value="{{ $t }}" @selected(old('title', $caregiver->title) == $t)>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-semibold small">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $caregiver->name) }}" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-semibold small">Relationship to Student</label>
                    <input type="text" name="relationship_to_student" class="form-control" value="{{ old('relationship_to_student', $caregiver->relationship_to_student) }}" placeholder="e.g. Father, Mother, Aunt">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold small">Mobile Number</label>
                    <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $caregiver->mobile) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold small">Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $caregiver->email) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold small">Occupation</label>
                    <input type="text" name="occupation" class="form-control" value="{{ old('occupation', $caregiver->occupation) }}">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold small">Address</label>
                    <textarea name="address" class="form-control" rows="2">{{ old('address', $caregiver->address) }}</textarea>
                </div>

                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-circle me-1"></i> Update Caregiver
                    </button>
                    <a href="{{ route('caregivers.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
