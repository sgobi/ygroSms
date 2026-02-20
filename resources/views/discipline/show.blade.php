@extends('layouts.app')
@section('title', 'Tracking Record Detail')

@section('content')
<div class="row justify-content-center pt-4">
    <div class="col-md-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('discipline.index') }}" class="btn btn-outline-secondary btn-sm rounded-3 shadow-sm px-3 py-2"><i class="bi bi-arrow-left"></i></a>
                <h5 class="mb-0 fw-bold border-start ps-3" style="border-width: 3px !important; border-color: var(--primary) !important;">Tracking Detail</h5>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('discipline.edit', $discipline) }}" class="btn btn-primary shadow-sm px-4 rounded-3 d-flex align-items-center gap-2" style="background: #1e3a5f;">
                    <i class="bi bi-pencil"></i> Edit Record
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-light py-4 px-5 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-large {{ $discipline->status === 'Warning' ? 'bg-danger text-white' : 'bg-primary text-white' }}">
                            {{ substr($discipline->student->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold">{{ $discipline->student->name }}</h4>
                            <span class="badge bg-white text-dark shadow-sm border border-light-subtle px-3 py-2 rounded-pill fw-medium">
                                <i class="bi bi-mortarboard me-2"></i>Grade {{ $discipline->student->current_grade }}
                            </span>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="small fw-bold text-uppercase text-muted ls-wide mb-1">Status</div>
                        @if($discipline->status === 'Good')
                            <span class="badge bg-success shadow-sm px-4 py-2 fs-6 rounded-pill">
                                <i class="bi bi-patch-check-fill me-2"></i>Enrolled & Good
                            </span>
                        @else
                            <span class="badge bg-danger shadow-sm px-4 py-2 fs-6 rounded-pill animate-pulse">
                                <i class="bi bi-exclamation-octagon-fill me-2"></i>Warning State
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body p-5">
                <div class="row g-5">
                    <div class="col-md-6 border-end">
                        <div class="d-flex align-items-center gap-4">
                            <div class="feature-icon bg-blue-soft text-primary">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            <div>
                                <div class="small text-muted text-uppercase fw-bold ls-wide mb-1">Tracking Period</div>
                                <div class="fs-5 fw-bold">{{ $discipline->month_name }} {{ $discipline->academicYear->year }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-4">
                            <div class="feature-icon {{ $discipline->bill_submitted ? 'bg-success-soft text-success' : 'bg-danger-soft text-danger' }}">
                                <i class="bi bi-receipt-cutoff"></i>
                            </div>
                            <div>
                                <div class="small text-muted text-uppercase fw-bold ls-wide mb-1">Bill Submission</div>
                                <div class="fs-5 fw-bold">{{ $discipline->bill_submitted ? 'Verified & Submitted' : 'Pending Submission' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="p-4 rounded-4 {{ $discipline->meeting_calendar_id ? ($discipline->meeting_participated ? 'bg-success-soft' : 'bg-danger-soft') : 'bg-light' }}">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <h5 class="mb-0 fw-bold"><i class="bi bi-people me-2"></i>Meeting Attendance</h5>
                                    @if($discipline->meeting_calendar_id)
                                        <span class="badge bg-white text-primary border shadow-sm small">Mandatory Month</span>
                                    @else
                                        <span class="badge bg-white text-muted border small">No Scheduled Meeting</span>
                                    @endif
                                </div>
                                <div class="fs-4">
                                    @if($discipline->meeting_calendar_id)
                                        @if($discipline->meeting_participated)
                                            <i class="bi bi-check-circle-fill text-success"></i>
                                        @else
                                            <i class="bi bi-x-circle-fill text-danger"></i>
                                        @endif
                                    @else
                                        <i class="bi bi-dash-circle text-muted opacity-50"></i>
                                    @endif
                                </div>
                            </div>
                            <hr class="my-3 opacity-10">
                            @if($discipline->meeting_calendar_id)
                                <p class="mb-0 {{ $discipline->meeting_participated ? 'text-success-emphasis' : 'text-danger-emphasis' }}">
                                    @if($discipline->meeting_participated)
                                        The parent/student satisfied the mandatory meeting requirement for this period.
                                    @else
                                        <strong>ATTENTION:</strong> The mandatory parent-teacher meeting for this period was missed. This record is flagged.
                                    @endif
                                </p>
                            @else
                                <p class="mb-0 text-muted">No specific parent meeting was scheduled in the Meeting Calendar for this tracking month.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light p-4 text-center border-0">
                <small class="text-muted">Record created on {{ $discipline->created_at->format('d M, Y \a\t h:i A') }} • Last updated {{ $discipline->updated_at->diffForHumans() }}</small>
            </div>
        </div>
    </div>
</div>

<style>
    .ls-wide { letter-spacing: 0.1em; }
    .avatar-large { width: 64px; height: 64px; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 800; }
    .feature-icon { width: 54px; height: 54px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
    .bg-blue-soft { background-color: rgba(30, 58, 95, 0.1); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }
    .animate-pulse { animation: pulse 2s infinite; }
    @keyframes pulse { 0% { transform: scale(1); opacity: 1; } 50% { transform: scale(0.98); opacity: 0.9; } 100% { transform: scale(1); opacity: 1; } }
</style>
@endsection
