@extends('layouts.app')
@section('title', 'Manage Divisions')

@section('content')
<div class="d-flex align-items-center mb-4">
    <h5 class="mb-0 fw-bold text-primary">Regional Divisions</h5>
</div>

<div class="row g-4">
    {{-- GN Divisions --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header fw-semibold py-2">GN Divisions</div>
            <div class="card-body">
                <form action="{{ route('divisions.storeGn') }}" method="POST" class="d-flex gap-2 mb-3">
                    @csrf
                    <input type="text" name="name" class="form-control form-control-sm" placeholder="Add New GN Division" required>
                    <button class="btn btn-sm btn-primary"><i class="bi bi-plus"></i></button>
                </form>

                <div class="list-group list-group-flush border rounded overflow-auto" style="max-height: 400px;">
                    @forelse($gnDivisions as $gn)
                        <div class="list-group-item d-flex justify-content-between align-items-center py-2">
                            <span>{{ $gn->name }}</span>
                            <form action="{{ route('divisions.destroyGn', $gn) }}" method="POST" onsubmit="return confirm('Delete this division?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-xs text-danger border-0 bg-transparent p-0"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    @empty
                        <div class="p-3 text-center text-muted small">No GN Divisions found.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- GS Divisions --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header fw-semibold py-2">GS Divisions</div>
            <div class="card-body">
                <form action="{{ route('divisions.storeGs') }}" method="POST" class="d-flex gap-2 mb-3">
                    @csrf
                    <input type="text" name="name" class="form-control form-control-sm" placeholder="Add New GS Division" required>
                    <button class="btn btn-sm btn-primary"><i class="bi bi-plus"></i></button>
                </form>

                <div class="list-group list-group-flush border rounded overflow-auto" style="max-height: 400px;">
                    @forelse($gsDivisions as $gs)
                        <div class="list-group-item d-flex justify-content-between align-items-center py-2">
                            <span>{{ $gs->name }}</span>
                            <form action="{{ route('divisions.destroyGs', $gs) }}" method="POST" onsubmit="return confirm('Delete this division?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-xs text-danger border-0 bg-transparent p-0"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    @empty
                        <div class="p-3 text-center text-muted small">No GS Divisions found.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
