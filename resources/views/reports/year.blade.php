@extends('layouts.app')
@section('title', 'Year Report')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold text-primary">{{ $academicYear->year }} Annual Report — {{ $student->name }}</h5>
    <a href="{{ route('reports.year', array_merge(request()->all(), ['pdf'=>1])) }}" class="btn btn-outline-danger btn-sm ms-auto">
        <i class="bi bi-file-pdf me-1"></i>Download PDF
    </a>
</div>
@forelse($marks as $term => $termMarks)
<h6 class="fw-bold text-primary mb-2">Term {{ $term }}</h6>
<div class="card mb-3">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>Subject</th><th>Marks</th><th>Grade</th></tr></thead>
            <tbody>
            @foreach($termMarks as $m)
                <tr>
                    <td>{{ $m->subject->name }}</td>
                    <td class="fw-semibold">{{ $m->marks }}</td>
                    <td><span class="badge bg-{{ ['A'=>'success','B'=>'primary','C'=>'info','S'=>'secondary','W'=>'danger'][$m->grade_letter] ?? 'secondary' }}">{{ $m->grade_letter }}</span></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@empty
<div class="alert alert-warning">No marks recorded for {{ $academicYear->year }}.</div>
@endforelse
@endsection
