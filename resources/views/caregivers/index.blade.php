@extends('layouts.app')

@section('title', 'Main Caregivers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold text-primary">Main Caregivers</h5>
    <a href="{{ route('caregivers.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Add Caregiver
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Name</th>
                        <th>Relationship</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($caregivers as $caregiver)
                        <tr>
                            <td>{{ $caregiver->title }}</td>
                            <td class="fw-semibold">{{ $caregiver->name }}</td>
                            <td>{{ $caregiver->relationship_to_student }}</td>
                            <td>{{ $caregiver->mobile }}</td>
                            <td>{{ $caregiver->email }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('caregivers.edit', $caregiver->id) }}">Edit</a></li>
                                        <li>
                                            <form action="{{ route('caregivers.destroy', $caregiver->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No caregivers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $caregivers->links() }}
        </div>
    </div>
</div>
@endsection
