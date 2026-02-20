@extends('layouts.app')
@section('title', isset($meeting) ? 'Edit Meeting Month' : 'Add Meeting Month')

@section('content')
<div class="row justify-content-center pt-4">
    <div class="col-md-7">
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('meetings.index') }}" class="btn btn-outline-secondary btn-sm rounded-3 shadow-sm px-3 py-2">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h5 class="mb-0 fw-bold border-start ps-3" style="border-width: 3px !important; border-color: var(--primary) !important;">
                {{ isset($meeting) ? 'Edit Meeting Month' : 'Add Meeting Month' }}
            </h5>
        </div>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-5">
                <form action="{{ isset($meeting) ? route('meetings.update', $meeting) : route('meetings.store') }}" method="POST">
                    @csrf
                    @if(isset($meeting)) @method('PUT') @endif

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted ls-wide">Year</label>
                            <input type="number" name="year" class="form-control form-control-lg bg-light border-0 @error('year') is-invalid @enderror" value="{{ old('year', $meeting->year ?? date('Y')) }}" required>
                            @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted ls-wide">Month</label>
                            <select name="month" class="form-select form-select-lg bg-light border-0 @error('month') is-invalid @enderror" required>
                                <option value="">Select Month...</option>
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ (old('month', $meeting->month ?? '') == $m) ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('month') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-uppercase text-muted ls-wide">Meeting Title (Optional)</label>
                            <input type="text" name="meeting_title" class="form-control form-control-lg bg-light border-0" value="{{ old('meeting_title', $meeting->meeting_title ?? '') }}" placeholder="e.g. Annual Parent-Teacher Meeting">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-uppercase text-muted ls-wide">Meeting Date (Optional)</label>
                            <input type="date" name="meeting_date" class="form-control form-control-lg bg-light border-0" value="{{ old('meeting_date', isset($meeting->meeting_date) ? $meeting->meeting_date->format('Y-m-d') : '') }}">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('meetings.index') }}" class="btn btn-lg btn-outline-secondary border-secondary-subtle px-5 rounded-3">Cancel</a>
                        <button type="submit" class="btn btn-lg btn-primary px-5 rounded-3 shadow" style="background: #1e3a5f;">
                            <i class="bi bi-calendar-check me-2"></i>{{ isset($meeting) ? 'Update Calendar' : 'Add to Calendar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .ls-wide { letter-spacing: 0.1em; }
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(30, 58, 95, 0.1);
        border: 1px solid #1e3a5f !important;
    }
</style>
@endsection
