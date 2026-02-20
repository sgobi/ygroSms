@extends('layouts.app')
@section('title', 'Meeting Calendar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">Meeting Calendar</h4>
        <p class="text-muted small mb-0">Define months where parent-teacher meetings are mandatory.</p>
    </div>
    <a href="{{ route('meetings.create') }}" class="btn btn-primary shadow px-4 rounded-3 d-flex align-items-center gap-2" style="background: #1e3a5f;">
        <i class="bi bi-calendar-plus"></i> Add Meeting Month
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">Period</th>
                        <th>Meeting Title</th>
                        <th>Scheduled Date</th>
                        <th class="text-center">Active Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($meetings as $meeting)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="calendar-icon bg-primary text-white">
                                        <div class="mon text-uppercase">{{ substr($meeting->month_name, 0, 3) }}</div>
                                        <div class="yr">{{ $meeting->year }}</div>
                                    </div>
                                    <div class="fw-bold text-dark">{{ $meeting->month_name }} {{ $meeting->year }}</div>
                                </div>
                            </td>
                            <td>{{ $meeting->meeting_title ?? '<span class="text-muted italic small">General Monthly Meeting</span>' }}</td>
                            <td>
                                @if($meeting->meeting_date)
                                    <span class="badge bg-light text-dark border fw-medium">
                                        <i class="bi bi-clock me-1 text-primary"></i> {{ $meeting->meeting_date->format('d M, Y') }}
                                    </span>
                                @else
                                    <span class="text-muted small">TBD</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">Mandatory</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                                    <a href="{{ route('meetings.edit', $meeting) }}" class="btn btn-white btn-sm px-3" title="Edit"><i class="bi bi-pencil text-muted"></i></a>
                                    <form action="{{ route('meetings.destroy', $meeting) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this month from mandatory calendar?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-white btn-sm px-3 border-start" title="Delete"><i class="bi bi-trash text-danger"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-calendar-x fs-1 text-muted opacity-25 d-block mb-3"></i>
                                    <h6 class="text-muted fw-normal">No meeting months defined yet.</h6>
                                    <a href="{{ route('meetings.create') }}" class="btn btn-sm btn-outline-primary mt-2">Initialize Calendar</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($meetings->hasPages())
        <div class="card-footer bg-white border-top-0 py-3">
            {{ $meetings->links() }}
        </div>
    @endif
</div>

<style>
    .calendar-icon { width: 45px; height: 48px; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; line-height: 1; }
    .calendar-icon .mon { font-size: .65rem; font-weight: 800; opacity: .8; margin-bottom: 2px; }
    .calendar-icon .yr { font-size: .95rem; font-weight: 700; }
    .btn-white { background: #fff; border: 1px solid #f0f4f8; }
    .btn-white:hover { background: #f8fafc; }
    .italic { font-style: italic; }
</style>
@endsection
