@extends('layouts.app')
@section('title', 'Add Subject')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <h5 class="mb-0 fw-bold text-primary">Add Subject</h5>
</div>
<div class="card" style="max-width:540px;">
    <div class="card-body">
        <form method="POST" action="{{ route('subjects.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold small">Subject Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="row g-2 mb-3">
                <div class="col-6">
                    <label class="form-label fw-semibold small">Grade From <span class="text-danger">*</span></label>
                    <select name="grade_from" class="form-select" required>
                        @for($g=1;$g<=13;$g++)<option value="{{ $g }}" @selected(old('grade_from')==$g)>Grade {{ $g }}</option>@endfor
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold small">Grade To <span class="text-danger">*</span></label>
                    <select name="grade_to" class="form-select" required>
                        @for($g=1;$g<=13;$g++)<option value="{{ $g }}" @selected(old('grade_to')==$g)>Grade {{ $g }}</option>@endfor
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold small">A/L Stream (leave blank for all)</label>
                <select name="stream_id" class="form-select">
                    <option value="">All Streams</option>
                    @foreach(\App\Models\Stream::all() as $s)
                        <option value="{{ $s->id }}" @selected(old('stream_id')==$s->id)>{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="is_optional" name="is_optional" value="1" @checked(old('is_optional'))>
                <label class="form-check-label" for="is_optional">Optional subject</label>
            </div>
            <button class="btn btn-primary"><i class="bi bi-check-circle me-1"></i>Save Subject</button>
            <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
