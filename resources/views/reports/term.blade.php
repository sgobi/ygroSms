@extends('layouts.app')
@section('title', 'Term Report')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold text-primary">Term {{ $request->term }} Report — {{ $student->name }}</h5>
    <a href="{{ route('reports.term', array_merge(request()->all(), ['pdf'=>1])) }}" class="btn btn-outline-danger btn-sm ms-auto">
        <i class="bi bi-file-pdf me-1"></i>Download PDF
    </a>
</div>
<div class="alert alert-info text-sm py-2">
    <strong>Grade:</strong> {{ $marks->first()?->grade ?? $student->current_grade }} &nbsp;·&nbsp;
    <strong>Stream:</strong> {{ $student->stream?->name ?? 'N/A' }} &nbsp;·&nbsp;
    <strong>Academic Year:</strong> {{ $academicYear->year }}
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>#</th><th>Subject</th><th>Marks</th><th>Grade</th><th>Remarks</th></tr></thead>
            <tbody>
            @php $total = 0; $count = 0; @endphp
            @forelse($marks as $i => $m)
                @php $total += $m->marks; $count++; @endphp
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $m->subject->name }}</td>
                    <td class="fw-semibold">{{ $m->marks }}</td>
                    <td><span class="badge bg-{{ ['A'=>'success','B'=>'primary','C'=>'info','S'=>'secondary','W'=>'danger'][$m->grade_letter] ?? 'secondary' }}">{{ $m->grade_letter }}</span></td>
                    <td class="text-muted small">{{ $m->remarks ?? '–' }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No marks recorded for this term.</td></tr>
            @endforelse
            @if($count > 0)
            <tr class="table-light fw-bold">
                <td colspan="2">Total / Average</td>
                <td>{{ $total }} / {{ round($total/$count, 1) }}</td>
                <td colspan="2"></td>
            </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
