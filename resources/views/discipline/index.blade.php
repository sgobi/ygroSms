@extends('layouts.app')
@section('title', 'Disciplinary History')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">Disciplinary Tracking</h4>
        <p class="text-muted small mb-0">Monitor parent-student compliance and meeting participation.</p>
    </div>
    <div class="d-flex gap-3">
        <a href="{{ route('meetings.index') }}" class="btn btn-outline-primary shadow-sm px-4 rounded-3 d-flex align-items-center gap-2">
            <i class="bi bi-calendar3"></i> Meeting Calendar
        </a>
        <a href="{{ route('discipline.create') }}" class="btn btn-primary shadow px-4 rounded-3 d-flex align-items-center gap-2" style="background: #1e3a5f;">
            <i class="bi bi-plus-lg"></i> Record Entry
        </a>
    </div>
</div>

{{-- Filters --}}
<div class="card mb-4 border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <form method="GET" action="{{ route('discipline.index') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-bold text-uppercase text-muted ls-wide">Grade</label>
                <select name="grade" class="form-select bg-light border-0">
                    <option value="">All Grades</option>
                    @foreach(range(1, 13) as $g)
                        <option value="{{ $g }}" {{ request('grade') == $g ? 'selected' : '' }}>Grade {{ $g }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-uppercase text-muted ls-wide">Month</label>
                <select name="month" class="form-select bg-light border-0">
                    <option value="">All Months</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-uppercase text-muted ls-wide">Year</label>
                <select name="year" class="form-select bg-light border-0">
                    <option value="">All Years</option>
                    @foreach($academicYears as $ay)
                        <option value="{{ $ay->year }}" {{ request('year') == $ay->year ? 'selected' : '' }}>{{ $ay->year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 rounded-3" style="background: #1e3a5f;">Filter Results</button>
                <a href="{{ route('discipline.index') }}" class="btn btn-light w-100 rounded-3 border">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Records Table --}}
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">Student</th>
                        <th>Year</th>
                        <th>Month</th>
                        <th class="text-center">Meeting</th>
                        <th class="text-center">Bill</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $rec)
                        <tr class="{{ $rec->status === 'Warning' ? 'warning-row' : '' }}">
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle {{ $rec->status === 'Warning' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary' }}">
                                        {{ substr($rec->student->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold {{ $rec->status === 'Warning' ? 'text-danger' : 'text-dark' }}">{{ $rec->student->name }}</div>
                                        <div class="text-muted small">Grade {{ $rec->student->current_grade }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $rec->academicYear->year }}</td>
                            <td><span class="badge bg-light text-dark border fw-medium px-2 py-1">{{ $rec->month_name }}</span></td>
                            <td class="text-center">
                                @if($rec->meeting_calendar_id)
                                    @if($rec->meeting_participated)
                                        <div class="status-icon bg-success-subtle text-success mx-auto" title="Participated"><i class="bi bi-people-fill"></i></div>
                                    @else
                                        <div class="status-icon bg-danger-subtle text-danger mx-auto" title="Missed"><i class="bi bi-people"></i></div>
                                    @endif
                                @else
                                    <span class="text-muted small opacity-50">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($rec->bill_submitted)
                                    <div class="status-icon bg-success-subtle text-success mx-auto"><i class="bi bi-receipt-cutoff"></i></div>
                                @else
                                    <div class="status-icon bg-danger-subtle text-danger mx-auto animate-jiggle"><i class="bi bi-receipt"></i></div>
                                @endif
                            </td>
                            <td>
                                @if($rec->status === 'Good')
                                    <span class="badge bg-success shadow-sm px-3 py-2 rounded-pill fw-semibold">
                                        <i class="bi bi-check-circle me-1"></i>Good
                                    </span>
                                @else
                                    <span class="badge bg-danger shadow-sm px-3 py-2 rounded-pill fw-semibold animate-pulse">
                                        <i class="bi bi-exclamation-triangle me-1"></i>Warning
                                    </span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                                    <a href="{{ route('discipline.show', $rec) }}" class="btn btn-white btn-sm px-3" title="View Detail"><i class="bi bi-eye text-primary"></i></a>
                                    <a href="{{ route('discipline.edit', $rec) }}" class="btn btn-white btn-sm px-3 border-start" title="Edit Record"><i class="bi bi-pencil text-muted"></i></a>
                                    <form action="{{ route('discipline.destroy', $rec) }}" method="POST" class="d-inline" onsubmit="return confirm('Permanently delete this record?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-white btn-sm px-3 border-start" title="Delete"><i class="bi bi-trash text-danger"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-inbox-fill fs-1 text-muted opacity-25 d-block mb-3"></i>
                                    <h6 class="text-muted fw-normal">No tracking records matching your criteria.</h6>
                                    <a href="{{ route('discipline.create') }}" class="btn btn-sm btn-outline-primary mt-2">Record First Entry</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($records->hasPages())
        <div class="card-footer bg-white border-top-0 py-3">
            {{ $records->links() }}
        </div>
    @endif
</div>

<style>
    .ls-wide { letter-spacing: 0.1em; }
    .avatar-circle { width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: .9rem; }
    .status-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1rem; transition: transform .2s; }
    .status-icon:hover { transform: scale(1.1); }
    .warning-row { background-color: rgba(220, 53, 69, 0.02) !important; }
    .warning-row:hover { background-color: rgba(220, 53, 69, 0.05) !important; }
    .btn-white { background: #fff; border: 1px solid #f0f4f8; }
    .btn-white:hover { background: #f8fafc; }
    
    .animate-pulse { animation: pulse 2s infinite; }
    @keyframes pulse { 0% { transform: scale(1); opacity: 1; } 50% { transform: scale(0.96); opacity: 0.8; } 100% { transform: scale(1); opacity: 1; } }
    
    .animate-jiggle { animation: jiggle 3s infinite linear; }
    @keyframes jiggle { 0%, 90% { transform: rotate(0); } 92% { transform: rotate(10deg); } 94% { transform: rotate(-10deg); } 96% { transform: rotate(10deg); } 98% { transform: rotate(-10deg); } 100% { transform: rotate(0); } }
</style>
@endsection
