@extends('layouts.app')
@section('title', 'Add Public Exam Result')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('public-exams.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold text-primary">Add Public Exam Result</h5>
</div>

<form method="POST" action="{{ route('public-exams.store') }}" enctype="multipart/form-data" id="examForm">
@csrf
<div class="row g-3">
    {{-- Left Column --}}
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header fw-semibold py-2"><i class="bi bi-person-badge me-1"></i>Exam Details</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Student <span class="text-danger">*</span></label>
                    <select name="student_id" class="form-select" required>
                        <option value="">— Select Student —</option>
                        @foreach($students as $s)
                            <option value="{{ $s->id }}" @selected(old('student_id')==$s->id)>
                                {{ $s->name }} (Gr. {{ $s->current_grade }}{{ $s->stream ? ' · '.$s->stream->name : '' }})
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Only Grade 11+ students shown</small>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Exam Type <span class="text-danger">*</span></label>
                        <select name="exam_type" class="form-select" required id="examType" onchange="updateSubjectHints()">
                            <option value="">— Select —</option>
                            <option value="OL" @selected(old('exam_type')=='OL')>O/L Exam</option>
                            <option value="AL" @selected(old('exam_type')=='AL')>A/L Exam</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Exam Year <span class="text-danger">*</span></label>
                        <input type="number" name="exam_year" class="form-control" value="{{ old('exam_year', date('Y')) }}" min="2000" max="2099" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Academic Year <span class="text-danger">*</span></label>
                    <select name="academic_year_id" class="form-select" required>
                        @foreach($academicYears as $ay)
                            <option value="{{ $ay->id }}" @selected(old('academic_year_id', $ay->is_active ? $ay->id : null)==$ay->id)>
                                {{ $ay->year }}{{ $ay->is_active ? ' (Active)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Index Number <span class="text-danger">*</span></label>
                    <input type="text" name="index_number" class="form-control font-monospace text-primary" value="{{ old('index_number') }}" placeholder="e.g. 5021234" required maxlength="20">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Result Sheet <span class="text-muted small fw-normal">(PDF / Image, max 5MB)</span></label>
                    <input type="file" name="result_sheet" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted">Upload scanned result sheet or DoE certificate</small>
                </div>

                <div class="mb-2">
                    <label class="form-label fw-semibold">Notes</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="Optional remarks...">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Column – Subject Grades --}}
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between py-2">
                <span class="fw-semibold"><i class="bi bi-list-check me-1"></i>Subject Grades</span>
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addSubjectRow()">
                    <i class="bi bi-plus"></i> Add Subject
                </button>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0" id="subjectTable">
                    <thead><tr><th>#</th><th>Subject Name</th><th>Grade</th><th></th></tr></thead>
                    <tbody id="subjectRows">
                    {{-- JS will generate rows --}}
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="d-flex gap-2 flex-wrap" id="subjectHints">
                    <small class="text-muted fst-italic">Select exam type to see common subjects</small>
                </div>
            </div>
        </div>

        <div class="alert alert-info mt-3 small py-2">
            <strong>Grade Key:</strong>
            <span class="badge bg-success">A</span> Distinction &nbsp;
            <span class="badge bg-primary">B</span> Credit &nbsp;
            <span class="badge bg-info text-dark">C</span> Good &nbsp;
            <span class="badge bg-warning text-dark">S</span> Pass &nbsp;
            <span class="badge bg-danger">W</span> Fail &nbsp;
            <span class="badge bg-secondary">X</span> Absent
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Save Result</button>
            <a href="{{ route('public-exams.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </div>
</div>
</form>

@push('scripts')
<script>
const olSubjects = ['Tamil','Sinhala','English','Mathematics','Science','History','Religion','ICT','Commerce','Agriculture','Art','Music','Health & Physical Education'];
const alSubjects = {
    general: ['Common General Test','General English'],
    science: ['Physics','Chemistry','Biology','Combined Mathematics','ICT'],
    commerce: ['Accounting','Business Studies','Economics','Business Statistics'],
    arts: ['History','Geography','Political Science','Logic','Literature'],
};

let rowCount = 0;

function addSubjectRow(name = '', grade = '') {
    rowCount++;
    const tbody = document.getElementById('subjectRows');
    const tr = document.createElement('tr');
    tr.id = `row-${rowCount}`;
    tr.innerHTML = `
        <td class="text-muted small">${rowCount}</td>
        <td><input type="text" name="subjects[${rowCount}][name]" class="form-control form-control-sm" value="${name}" placeholder="Subject name" required></td>
        <td>
            <select name="subjects[${rowCount}][grade]" class="form-select form-select-sm" required>
                <option value="">—</option>
                ${['A','B','C','S','W','X','AB'].map(g => `<option value="${g}" ${g===grade?'selected':''}>${g}</option>`).join('')}
            </select>
        </td>
        <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="document.getElementById('row-${rowCount}').remove()"><i class="bi bi-x"></i></button></td>
    `;
    tbody.appendChild(tr);
}

function updateSubjectHints() {
    const type = document.getElementById('examType').value;
    const hints = document.getElementById('subjectHints');
    let list = [];
    if (type === 'OL')      list = olSubjects;
    else if (type === 'AL') list = [...alSubjects.general, ...alSubjects.science, ...alSubjects.commerce, ...alSubjects.arts];

    hints.innerHTML = list.length
        ? '<small class="text-muted me-1">Quick add:</small>' + list.map(s =>
            `<button type="button" class="btn btn-sm btn-outline-secondary py-0 px-1" style="font-size:.75rem" onclick="addSubjectRow('${s}')">${s}</button>`
          ).join('')
        : '<small class="text-muted fst-italic">Select exam type to see common subjects</small>';
}

// Start with 5 blank rows
window.onload = () => { for(let i=0;i<5;i++) addSubjectRow(); };
</script>
@endpush
@endsection
