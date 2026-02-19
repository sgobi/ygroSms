@extends('layouts.app')
@section('title', 'Add Student')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold text-primary">Add New Student</h5>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('students.store') }}">
            @csrf
            <div class="row g-3">
                {{-- Personal Info --}}
                <div class="col-12"><h6 class="text-muted fw-semibold border-bottom pb-2">Personal Information</h6></div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Date of Birth</label>
                    <input type="date" name="dob" class="form-control" value="{{ old('dob') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">Select</option>
                        <option @selected(old('gender')=='Male')>Male</option>
                        <option @selected(old('gender')=='Female')>Female</option>
                        <option @selected(old('gender')=='Other')>Other</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Address</label>
                    <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Parent/Guardian Name</label>
                    <input type="text" name="parent_name" class="form-control" value="{{ old('parent_name') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Contact Number</label>
                    <input type="text" name="contact" class="form-control" value="{{ old('contact') }}">
                </div>

                {{-- Academic Info --}}
                <div class="col-12 mt-2"><h6 class="text-muted fw-semibold border-bottom pb-2">Academic Information</h6></div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Admission Year <span class="text-danger">*</span></label>
                    <input type="number" name="admission_year" class="form-control" value="{{ old('admission_year', date('Y')) }}" min="2010" max="2100" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Current Grade <span class="text-danger">*</span></label>
                    <select name="current_grade" class="form-select" id="gradeSelect" required>
                        <option value="">Select Grade</option>
                        @for($g=1; $g<=13; $g++)
                            <option value="{{ $g }}" @selected(old('current_grade')==$g)>Grade {{ $g }}
                                @if($g<=5) (Primary) @elseif($g<=11) (O/L) @else (A/L) @endif
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3" id="streamGroup" style="display:none;">
                    <label class="form-label fw-semibold small">A/L Stream</label>
                    <select name="stream_id" class="form-select">
                        <option value="">Select Stream</option>
                        @foreach($streams as $s)
                            <option value="{{ $s->id }}" @selected(old('stream_id')==$s->id)>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">O/L Index Number</label>
                    <input type="text" name="ol_index" class="form-control" value="{{ old('ol_index') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">A/L Index Number</label>
                    <input type="text" name="al_index" class="form-control" value="{{ old('al_index') }}">
                </div>

                {{-- Initial School --}}
                <div class="col-12 mt-2"><h6 class="text-muted fw-semibold border-bottom pb-2">Current School</h6></div>
                <div class="col-md-5">
                    <label class="form-label fw-semibold small">School</label>
                    <select name="school_id" class="form-select">
                        <option value="">Select School</option>
                        @foreach($schools as $school)
                            <option value="{{ $school->id }}" @selected(old('school_id')==$school->id)>{{ $school->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">From Year</label>
                    <input type="number" name="from_year" class="form-control" value="{{ old('from_year', date('Y')) }}" min="2010" max="2100">
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-circle me-1"></i> Save Student
                    </button>
                    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const gradeSelect = document.getElementById('gradeSelect');
    const streamGroup = document.getElementById('streamGroup');
    function toggleStream() {
        streamGroup.style.display = gradeSelect.value >= 12 ? 'block' : 'none';
    }
    gradeSelect.addEventListener('change', toggleStream);
    toggleStream();
</script>
@endpush
@endsection
