@extends('layouts.app')
@section('title', isset($discipline) ? 'Edit Tracking Record' : 'Record Tracking Entry')

@section('content')
<div class="row justify-content-center pt-4">
    <div class="col-md-9">
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('discipline.index') }}" class="btn btn-outline-secondary btn-sm rounded-3 px-3 py-2 shadow-sm">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h5 class="mb-0 fw-bold border-start ps-3" style="border-width: 3px !important; border-color: var(--primary) !important;">
                {{ isset($discipline) ? 'Edit Tracking Record' : 'Record New Entry' }}
            </h5>
        </div>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-5">
                <form action="{{ isset($discipline) ? route('discipline.update', $discipline) : route('discipline.store') }}" method="POST">
                    @csrf
                    @if(isset($discipline)) @method('PUT') @endif

                    <div class="row g-4 mb-5">
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-uppercase text-muted ls-wide">Student</label>
                            <select name="student_id" class="form-select form-select-lg bg-light border-0 @error('student_id') is-invalid @enderror" required>
                                <option value="">Select Student...</option>
                                @foreach($students as $s)
                                    <option value="{{ $s->id }}" {{ (old('student_id', $discipline->student_id ?? $selectedStudentId) == $s->id) ? 'selected' : '' }}>
                                        {{ $s->name }} (Grade {{ $s->current_grade }})
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted ls-wide">Academic Year</label>
                            <select id="academic_year_id" name="academic_year_id" class="form-select form-select-lg bg-light border-0 @error('academic_year_id') is-invalid @enderror" required>
                                @foreach($academicYears as $ay)
                                    <option value="{{ $ay->id }}" data-year="{{ $ay->year }}" {{ (old('academic_year_id', $discipline->academic_year_id ?? $activeYearId) == $ay->id) ? 'selected' : '' }}>
                                        {{ $ay->year }}
                                    </option>
                                @endforeach
                            </select>
                            @error('academic_year_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted ls-wide">Tracking Month</label>
                            <select id="tracking_month" name="month" class="form-select form-select-lg bg-light border-0 @error('month') is-invalid @enderror" required>
                                <option value="">Select Month...</option>
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ (old('month', $discipline->month ?? date('n')) == $m) ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('month') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <div class="p-4 rounded-4 border-2 border-dashed h-100 d-flex flex-column justify-content-center transition-all hover-shadow-sm" id="meeting_container">
                                <label class="form-label small fw-bold text-uppercase text-primary ls-wide mb-3"><i class="bi bi-people me-2"></i>Meeting Participation</label>
                                <div class="form-check form-switch p-0 m-0 d-flex align-items-center">
                                    <input class="form-check-input ms-0" type="checkbox" name="meeting_participated" value="1" id="meeting_participated" 
                                        style="width: 3.5rem; height: 1.75rem;" {{ old('meeting_participated', $discipline->meeting_participated ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label ms-3 fw-semibold" for="meeting_participated">
                                        Participated in Meeting
                                    </label>
                                </div>
                                <div id="meeting_note" class="small text-danger mt-3 d-none">
                                    <div class="alert alert-danger p-2 mb-0 border-0 rounded-3">
                                        <i class="bi bi-info-circle me-1"></i>No meeting scheduled for this month.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-4 rounded-4 border-2 border-dashed h-100 d-flex flex-column justify-content-center transition-all hover-shadow-sm">
                                <label class="form-label small fw-bold text-uppercase text-success ls-wide mb-3"><i class="bi bi-receipt me-2"></i>Bill Submission</label>
                                <div class="form-check form-switch p-0 m-0 d-flex align-items-center">
                                    <input class="form-check-input ms-0" type="checkbox" name="bill_submitted" value="1" id="bill_submitted"
                                        style="width: 3.5rem; height: 1.75rem;" {{ old('bill_submitted', $discipline->bill_submitted ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label ms-3 fw-semibold" for="bill_submitted">
                                        Bill Submitted <span class="text-danger">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-top d-flex justify-content-between align-items-center">
                        <div class="alert alert-info py-2 px-3 mb-0 border-0 rounded-3 small">
                            <i class="bi bi-info-circle me-2"></i>Status is auto-calculated. Bill is always required.
                        </div>
                        <div class="d-flex gap-3">
                            <a href="{{ route('discipline.index') }}" class="btn btn-lg btn-outline-secondary px-5 rounded-3">Cancel</a>
                            <button type="submit" class="btn btn-lg btn-primary px-5 rounded-3 shadow" style="background: #1e3a5f;">
                                <i class="bi bi-check2-circle me-2"></i>Save Record
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const yearSelect = document.getElementById('academic_year_id');
    const monthSelect = document.getElementById('tracking_month');
    const meetingCheckbox = document.getElementById('meeting_participated');
    const meetingNote = document.getElementById('meeting_note');
    const meetingContainer = document.getElementById('meeting_container');
    
    const meetingCalendar = @json($meetingCalendar ?? []);

    function updateMeetingVisibility() {
        const selectedYear = yearSelect.options[yearSelect.selectedIndex].dataset.year;
        const selectedMonth = monthSelect.value;
        const key = `${selectedYear}-${selectedMonth}`;
        
        if (meetingCalendar[key]) {
            meetingCheckbox.disabled = false;
            meetingNote.classList.add('d-none');
            meetingContainer.style.background = 'rgba(13, 110, 253, 0.05)';
            meetingContainer.style.borderColor = 'rgba(13, 110, 253, 0.2)';
        } else {
            meetingCheckbox.disabled = true;
            meetingCheckbox.checked = false;
            meetingNote.classList.remove('d-none');
            meetingContainer.style.background = 'rgba(0, 0, 0, 0.02)';
            meetingContainer.style.borderColor = 'rgba(0, 0, 0, 0.05)';
        }
    }

    yearSelect.addEventListener('change', updateMeetingVisibility);
    monthSelect.addEventListener('change', updateMeetingVisibility);
    updateMeetingVisibility();
});
</script>

<style>
    .ls-wide { letter-spacing: 0.1em; }
    .border-dashed { border-style: dashed !important; border-width: 2px !important; }
    .transition-all { transition: all 0.3s ease; }
    .hover-shadow-sm:hover { box-shadow: 0 .125rem .25rem rgba(0,0,0,.075) !important; }
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(30, 58, 95, 0.1);
        border: 1px solid #1e3a5f !important;
    }
</style>
@endsection
