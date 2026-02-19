@extends('layouts.app')
@section('title', 'Exam Result — ' . $publicExam->student->name)
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('public-exams.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="mb-0 fw-bold text-primary">{{ $publicExam->student->name }}</h5>
        <small class="text-muted">
            <span class="badge bg-{{ $publicExam->exam_type === 'OL' ? 'info text-dark' : 'dark' }}">{{ $publicExam->exam_type }}</span>
            {{ $publicExam->exam_year }} &nbsp;·&nbsp; Index: <span class="font-monospace text-primary fw-bold">{{ $publicExam->index_number }}</span>
        </small>
    </div>
    <div class="ms-auto d-flex gap-2">
        <a href="{{ route('public-exams.edit', $publicExam) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil me-1"></i>Edit</a>
        <form method="POST" action="{{ route('public-exams.destroy', $publicExam) }}" onsubmit="return confirm('Delete this result?')">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash me-1"></i>Delete</button>
        </form>
    </div>
</div>

<div class="row g-3">
    {{-- Grade Card --}}
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header fw-semibold py-2"><i class="bi bi-list-check me-1"></i>Subject Grades</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>#</th><th>Subject</th><th>Grade</th></tr></thead>
                    <tbody>
                    @forelse($publicExam->subjects as $i => $sub)
                        <tr>
                            <td class="text-muted small">{{ $i+1 }}</td>
                            <td class="fw-semibold">{{ $sub->subject_name }}</td>
                            <td>
                                <span class="badge fs-6 bg-{{ \App\Models\PublicExamResult::gradeColor($sub->grade) }}">{{ $sub->grade }}</span>
                                <small class="text-muted ms-2">{{ ['A'=>'Distinction','B'=>'Credit','C'=>'Good','S'=>'Pass','W'=>'Fail','X'=>'Absent','AB'=>'Invalid'][$sub->grade] ?? '' }}</small>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">No subjects recorded.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Grade summary bar --}}
        @if($publicExam->subjects->isNotEmpty())
        <div class="card mt-3">
            <div class="card-body py-2">
                <div class="d-flex gap-3 flex-wrap">
                    @foreach(['A'=>'Distinction','B'=>'Credit','C'=>'Good','S'=>'Pass','W'=>'Fail'] as $g => $label)
                        @php $cnt = $publicExam->subjects->where('grade', $g)->count(); @endphp
                        @if($cnt)
                        <div class="text-center">
                            <div class="badge bg-{{ \App\Models\PublicExamResult::gradeColor($g) }} fs-5 px-3">{{ $g }}</div>
                            <div class="small fw-semibold mt-1">{{ $cnt }}x</div>
                            <div class="text-muted" style="font-size:.7rem">{{ $label }}</div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Right Panel --}}
    <div class="col-lg-5">
        <div class="card mb-3">
            <div class="card-header fw-semibold py-2"><i class="bi bi-info-circle me-1"></i>Details</div>
            <div class="card-body">
                <dl class="row mb-0 small">
                    <dt class="col-5 text-muted">Student</dt>
                    <dd class="col-7"><a href="{{ route('students.show', $publicExam->student) }}">{{ $publicExam->student->name }}</a></dd>
                    <dt class="col-5 text-muted">Grade</dt>
                    <dd class="col-7">{{ $publicExam->student->current_grade }}</dd>
                    <dt class="col-5 text-muted">Stream</dt>
                    <dd class="col-7">{{ $publicExam->student->stream?->name ?? 'N/A' }}</dd>
                    <dt class="col-5 text-muted">Exam Type</dt>
                    <dd class="col-7"><span class="badge bg-{{ $publicExam->exam_type==='OL'?'info text-dark':'dark' }}">{{ $publicExam->exam_type }}</span></dd>
                    <dt class="col-5 text-muted">Exam Year</dt>
                    <dd class="col-7 fw-semibold">{{ $publicExam->exam_year }}</dd>
                    <dt class="col-5 text-muted">Academic Year</dt>
                    <dd class="col-7">{{ $publicExam->academicYear->year }}</dd>
                    <dt class="col-5 text-muted">Index No.</dt>
                    <dd class="col-7 font-monospace text-primary fw-bold">{{ $publicExam->index_number }}</dd>
                    @if($publicExam->notes)
                    <dt class="col-5 text-muted">Notes</dt>
                    <dd class="col-7">{{ $publicExam->notes }}</dd>
                    @endif
                </dl>
            </div>
        </div>

        {{-- Result Sheet --}}
        <div class="card">
            <div class="card-header fw-semibold py-2"><i class="bi bi-file-earmark-text me-1"></i>Result Sheet</div>
            <div class="card-body text-center">
                @if($publicExam->result_sheet_path)
                    @php $ext = pathinfo($publicExam->result_sheet_path, PATHINFO_EXTENSION); @endphp
                    @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                        <img src="{{ Storage::url($publicExam->result_sheet_path) }}" class="img-fluid rounded mb-2" style="max-height:280px" alt="Result Sheet">
                    @else
                        <div class="py-3">
                            <i class="bi bi-file-earmark-pdf text-danger" style="font-size:3rem"></i>
                            <p class="mt-2 mb-0 small text-muted">PDF Result Sheet</p>
                        </div>
                    @endif
                    <div class="d-flex gap-2 justify-content-center mt-2">
                        <a href="{{ Storage::url($publicExam->result_sheet_path) }}" target="_blank" class="btn btn-sm btn-success">
                            <i class="bi bi-eye me-1"></i>View
                        </a>
                        <a href="{{ Storage::url($publicExam->result_sheet_path) }}" download class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-download me-1"></i>Download
                        </a>
                        <form method="POST" action="{{ route('public-exams.removeSheet', $publicExam) }}" onsubmit="return confirm('Remove sheet?')">
                            @csrf
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-x-circle me-1"></i>Remove</button>
                        </form>
                    </div>
                @else
                    <div class="py-3 text-muted">
                        <i class="bi bi-cloud-upload" style="font-size:2.5rem; opacity:.4"></i>
                        <p class="mt-2 mb-2 small">No result sheet uploaded</p>
                        <a href="{{ route('public-exams.edit', $publicExam) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-upload me-1"></i>Upload Sheet
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
