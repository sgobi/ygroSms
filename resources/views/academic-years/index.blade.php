@extends('layouts.app')
@section('title', 'Academic Years')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-calendar3 me-2"></i>Academic Years</h5>
    <a href="{{ route('academic-years.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> Add Year</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>Year</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($years as $year)
                <tr>
                    <td class="fw-semibold">{{ $year->year }}</td>
                    <td>
                        @if($year->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <form method="POST" action="{{ route('academic-years.setActive', $year) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-outline-secondary">Set Active</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('academic-years.edit', $year) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('academic-years.destroy', $year) }}" class="d-inline" onsubmit="return confirm('Delete year?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center text-muted py-4">No academic years yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($years->hasPages())<div class="card-footer">{{ $years->links() }}</div>@endif
</div>
@endsection
