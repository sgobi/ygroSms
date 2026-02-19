@extends('layouts.app')
@section('title', 'Donors')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h5 class="mb-0 fw-bold text-primary">Donors</h5>
    <a href="{{ route('donors.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Add Donor</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Name</th>
                        <th>Contact</th>
                        <th>Location</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donors as $donor)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-semibold text-dark">{{ $donor->title }} {{ $donor->name }}</div>
                            <small class="text-muted">{{ $donor->email }}</small>
                        </td>
                        <td>{{ $donor->phone ?? '–' }}</td>
                        <td class="text-truncate" style="max-width: 200px;">{{ $donor->address ?? '–' }}</td>
                        <td class="text-end pe-4">
                            <div class="btn-group">
                                <a href="{{ route('donors.edit', $donor) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('donors.destroy', $donor) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-start-0"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="bi bi-people d-block fs-1 mb-2 opacity-50"></i>
                            No donors found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($donors->hasPages())
    <div class="card-footer bg-white border-top-0">
        {{ $donors->links() }}
    </div>
    @endif
</div>
@endsection
