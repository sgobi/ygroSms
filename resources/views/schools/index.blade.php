@extends('layouts.app')
@section('title', 'Schools')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-building me-2"></i>Schools</h5>
    <a href="{{ route('schools.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> Add School</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>School Name</th><th>Address</th><th>Contact</th><th>Principal</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($schools as $school)
                <tr>
                    <td class="fw-semibold">{{ $school->name }}</td>
                    <td class="text-muted small">{{ $school->address ?? '–' }}</td>
                    <td class="text-muted small">{{ $school->contact ?? '–' }}</td>
                    <td class="text-muted small">{{ $school->principal_name ?? '–' }}</td>
                    <td>
                        <a href="{{ route('schools.edit', $school) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('schools.destroy', $school) }}" class="d-inline" onsubmit="return confirm('Delete school?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No schools yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($schools->hasPages())<div class="card-footer">{{ $schools->links() }}</div>@endif
</div>
@endsection
