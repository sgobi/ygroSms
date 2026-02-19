@extends('layouts.app')
@section('title', 'Add Donor')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom-0">
                <div class="d-flex align-items-center">
                    <a href="{{ route('donors.index') }}" class="btn btn-sm btn-light me-3"><i class="bi bi-arrow-left"></i></a>
                    <h5 class="mb-0 fw-bold text-primary">Add New Donor</h5>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('donors.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted">Title</label>
                            <select name="title" class="form-select">
                                <option value="">Select</option>
                                <option value="Mr.">Mr.</option>
                                <option value="Mrs.">Mrs.</option>
                                <option value="Miss.">Miss.</option>
                                <option value="Dr.">Dr.</option>
                                <option value="Rev.">Rev.</option>
                                <option value="Hon.">Hon.</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-semibold text-muted">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-muted">Address</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="123 Main St, City"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Telephone (TP)</label>
                            <input type="text" name="phone" class="form-control" placeholder="+94 7X XXX XXXX">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="john@example.com">
                        </div>

                        <div class="col-12 mt-4 text-end">
                            <a href="{{ route('donors.index') }}" class="btn btn-light me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check2-circle me-1"></i> Save Donor
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
