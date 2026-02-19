@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
{{-- Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#1e3a5f,#2563eb);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value">{{ $totalStudents }}</div>
                    <div class="stat-label">Total Students</div>
                </div>
                <i class="bi bi-people stat-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#065f46,#059669);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value">{{ $totalSchools }}</div>
                    <div class="stat-label">Schools</div>
                </div>
                <i class="bi bi-building stat-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#78350f,#d97706);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value">{{ $totalDistributions }}</div>
                    <div class="stat-label">Distributions</div>
                </div>
                <i class="bi bi-gift stat-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#4c1d95,#7c3aed);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value">Rs. {{ number_format($totalExpense, 0) }}</div>
                    <div class="stat-label">Total Welfare Spend</div>
                </div>
                <i class="bi bi-currency-dollar stat-icon"></i>
            </div>
        </div>
    </div>
</div>

{{-- Active Year Banner --}}
@if($activeYear)
<div class="alert alert-info d-flex align-items-center gap-2 mb-4">
    <i class="bi bi-calendar-check fs-5"></i>
    <span>Active Academic Year: <strong>{{ $activeYear->year }}</strong></span>
</div>
@endif

<div class="row g-3">
    {{-- Grade Distribution --}}
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2 py-3">
                <i class="bi bi-bar-chart text-primary"></i>
                <span class="fw-semibold">Students by Grade</span>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Grade</th><th>Group</th><th>Students</th></tr></thead>
                    <tbody>
                    @foreach($gradeDistribution as $row)
                        <tr>
                            <td><span class="badge-grade">Grade {{ $row->current_grade }}</span></td>
                            <td class="text-muted small">
                                @if($row->current_grade <= 5) Primary
                                @elseif($row->current_grade <= 11) O/L
                                @else A/L @endif
                            </td>
                            <td><strong>{{ $row->count }}</strong></td>
                        </tr>
                    @endforeach
                    @if($gradeDistribution->isEmpty())
                        <tr><td colspan="3" class="text-center text-muted py-3">No data yet</td></tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Recent Students --}}
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <span class="fw-semibold"><i class="bi bi-person-plus me-2 text-primary"></i>Recent Students</span>
                <a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Name</th><th>Grade</th><th>Stream</th></tr></thead>
                    <tbody>
                    @foreach($recentStudents as $s)
                        <tr>
                            <td><a href="{{ route('students.show', $s) }}" class="text-decoration-none">{{ $s->name }}</a></td>
                            <td><span class="badge-grade">{{ $s->current_grade }}</span></td>
                            <td class="text-muted small">{{ $s->stream?->name ?? '–' }}</td>
                        </tr>
                    @endforeach
                    @if($recentStudents->isEmpty())
                        <tr><td colspan="3" class="text-center text-muted py-3">No students yet</td></tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <span class="fw-semibold"><i class="bi bi-gift me-2 text-warning"></i>Recent Distributions</span>
                <a href="{{ route('distributions.index') }}" class="btn btn-sm btn-outline-warning">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Student</th><th>Product</th><th>Qty</th><th>Date</th></tr></thead>
                    <tbody>
                    @foreach($recentDistributions as $d)
                        <tr>
                            <td>{{ $d->student->name }}</td>
                            <td>{{ $d->product->name }}</td>
                            <td>{{ $d->quantity }}</td>
                            <td class="text-muted small">{{ $d->date_given->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                    @if($recentDistributions->isEmpty())
                        <tr><td colspan="4" class="text-center text-muted py-3">No distributions yet</td></tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
