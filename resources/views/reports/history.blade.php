@extends('layouts.app')
@section('title', 'Academic History')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold text-primary">Full Academic History — {{ $student->name }}</h5>
    <a href="{{ route('reports.history', array_merge(request()->all(), ['pdf'=>1])) }}" class="btn btn-outline-danger btn-sm ms-auto">
        <i class="bi bi-file-pdf me-1"></i>Download PDF
    </a>
</div>
@if($student->schoolHistories->isNotEmpty())
<div class="card mb-3">
    <div class="card-header fw-semibold py-2">School History</div>
    <div class="card-body p-0">
        <table class="table mb-0 small">
            <thead><tr><th>School</th><th>From</th><th>To</th></tr></thead>
            <tbody>
            @foreach($student->schoolHistories as $h)
                <tr><td>{{ $h->school->name }}</td><td>{{ $h->from_year }}</td><td>{{ $h->to_year ?? 'Present' }}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@forelse($marks as $year => $yearMarks)
<h6 class="fw-bold text-primary mb-1 mt-3">{{ $year }}</h6>
@foreach($yearMarks->groupBy('term') as $term => $termMarks)
<p class="mb-1 fw-semibold small">Term {{ $term }}</p>
<div class="card mb-2">
    <div class="card-body p-0">
        <table class="table mb-0 table-sm">
            <thead><tr><th>Subject</th><th>Marks</th><th>Grade</th></tr></thead>
            <tbody>
            @foreach($termMarks as $m)
                <tr>
                    <td>{{ $m->subject->name }}</td>
                    <td>{{ $m->marks }}</td>
                    <td><span class="badge bg-{{ ['A'=>'success','B'=>'primary','C'=>'info','S'=>'secondary','W'=>'danger'][$m->grade_letter] ?? 'secondary' }}">{{ $m->grade_letter }}</span></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endforeach
@empty
<div class="alert alert-warning mt-3">No academic records found.</div>
@endforelse
@endsection
