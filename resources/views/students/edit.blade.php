@extends('layouts.app')
@section('title', 'Edit Student')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('students.show', $student) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold text-primary">Edit — {{ $student->name }}</h5>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('students.update', $student) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-12"><h6 class="text-muted fw-semibold border-bottom pb-2">Sponsorship</h6></div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Select Caregiver</label>
                    <select name="caregiver_id" class="form-select">
                        <option value="">Select Caregiver</option>
                        @foreach($caregivers as $caregiver)
                            <option value="{{ $caregiver->id }}" @selected(old('caregiver_id', $student->caregiver_id) == $caregiver->id)>
                                {{ $caregiver->title }} {{ $caregiver->name }} ({{ $caregiver->relationship_to_student ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Select Donor</label>
                    <select name="donor_id" class="form-select">
                        <option value="">Select Donor</option>
                        @foreach($donors as $donor)
                            <option value="{{ $donor->id }}" @selected(old('donor_id', $student->donor_id) == $donor->id)>{{ $donor->title }} {{ $donor->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mt-4"><h6 class="text-muted fw-semibold border-bottom pb-2">Personal Information</h6></div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $student->name) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Admission Number</label>
                    <input type="text" name="admission_number" class="form-control" value="{{ old('admission_number', $student->admission_number) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Date of Birth</label>
                    <input type="date" name="dob" class="form-control" value="{{ old('dob', $student->dob?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">Select</option>
                        @foreach(['Male','Female','Other'] as $g)
                            <option @selected(old('gender',$student->gender)==$g)>{{ $g }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Address</label>
                    <textarea name="address" class="form-control" rows="2">{{ old('address', $student->address) }}</textarea>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Parent/Guardian Name</label>
                    <input type="text" name="parent_name" class="form-control" value="{{ old('parent_name', $student->parent_name) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Contact</label>
                    <input type="text" name="contact" class="form-control" value="{{ old('contact', $student->contact) }}">
                </div>



                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Medical/Emergency Contact Name</label>
                    <input type="text" name="medical_emergency_name" class="form-control" value="{{ old('medical_emergency_name', $student->medical_emergency_name) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Medical/Emergency Contact No</label>
                    <input type="text" name="medical_emergency_contact" class="form-control" value="{{ old('medical_emergency_contact', $student->medical_emergency_contact) }}">
                </div>

                <div class="col-12 mt-4"><h6 class="text-muted fw-semibold border-bottom pb-2">Regional Information</h6></div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">GN Division</label>
                    <select name="gn_division" class="form-select">
                        <option value="">Select GN Division</option>
                        @foreach($gnDivisions as $gn)
                            <option value="{{ $gn }}" @selected(old('gn_division', $student->gn_division) == $gn)>{{ $gn }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">GS Division</label>
                    <select name="gs_division" class="form-select">
                        <option value="">Select GS Division</option>
                        @foreach($gsDivisions as $gs)
                            <option value="{{ $gs }}" @selected(old('gs_division', $student->gs_division) == $gs)>{{ $gs }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mt-4"><h6 class="text-muted fw-semibold border-bottom pb-2">Academic Information</h6></div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Admission Year <span class="text-danger">*</span></label>
                    <input type="number" name="admission_year" class="form-control" value="{{ old('admission_year', $student->admission_year) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Current Grade <span class="text-danger">*</span></label>
                    <select name="current_grade" class="form-select" id="gradeSelect" required>
                        @for($g=1;$g<=13;$g++)
                            <option value="{{ $g }}" @selected(old('current_grade',$student->current_grade)==$g)>Grade {{ $g }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3" id="streamGroup" style="display:none;">
                    <label class="form-label fw-semibold small">A/L Stream</label>
                    <select name="stream_id" class="form-select" disabled>
                        <option value="">Select</option>
                        @foreach($streams as $s)
                            <option value="{{ $s->id }}" @selected(old('stream_id',$student->stream_id)==$s->id)>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3" id="olIndexGroup" style="display:none;">
                    <label class="form-label fw-semibold small">O/L Index</label>
                    <input type="text" name="ol_index" class="form-control" value="{{ old('ol_index', $student->ol_index) }}" disabled>
                </div>
                <div class="col-md-3" id="alIndexGroup" style="display:none;">
                    <label class="form-label fw-semibold small">A/L Index</label>
                    <input type="text" name="al_index" class="form-control" value="{{ old('al_index', $student->al_index) }}" disabled>
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-circle me-1"></i>Update Student</button>
                    <a href="{{ route('students.show', $student) }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
    const gradeSelect = document.getElementById('gradeSelect');
    const streamGroup = document.getElementById('streamGroup');
    const olIndexGroup = document.getElementById('olIndexGroup');
    const alIndexGroup = document.getElementById('alIndexGroup');

    function toggleFields() {
        const grade = parseInt(gradeSelect.value) || 0;
        
        const toggle = (element, show) => {
            element.style.display = show ? 'block' : 'none';
            const input = element.querySelector('input, select');
            if (input) input.disabled = !show;
        };

        toggle(streamGroup, grade >= 12);
        toggle(olIndexGroup, grade === 11);
        toggle(alIndexGroup, grade === 13);
    }
    
    gradeSelect.addEventListener('change', toggleFields);
    toggleFields(); // Initial run
</script>
@endpush
@endsection
