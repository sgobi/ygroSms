@extends('layouts.app')
@section('title', 'Edit Donor')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom-0">
                <div class="d-flex align-items-center">
                    <a href="{{ route('donors.index') }}" class="btn btn-sm btn-light me-3"><i class="bi bi-arrow-left"></i></a>
                    <h5 class="mb-0 fw-bold text-primary">Edit Donor</h5>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('donors.update', $donor) }}" method="POST">
                    @csrf @method('PUT')
                    
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted">Title</label>
                            <select name="title" class="form-select">
                                <option value="">Select</option>
                                @foreach(['Mr.','Mrs.','Miss.','Dr.','Rev.','Hon.'] as $t)
                                    <option value="{{ $t }}" @selected(old('title', $donor->title) == $t)>{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-semibold text-muted">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $donor->name) }}" required>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-muted">Address</label>
                            <textarea name="address" class="form-control" rows="3">{{ old('address', $donor->address) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Telephone (TP)</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $donor->phone) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $donor->email) }}">
                        </div>

                        <div class="col-12 mt-4 text-end">
                            <a href="{{ route('donors.index') }}" class="btn btn-light me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check2-circle me-1"></i> Update Donor
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
