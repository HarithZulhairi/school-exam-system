@extends('layouts.adminLayout')

@section('title', 'Edit Teacher')
@section('page-title', 'Edit Teacher Details')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <a href="{{ route('admin.teachers.index') }}" class="btn btn-light border text-muted">
            <i class="bi bi-arrow-left me-2"></i> Back to Teacher List
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 p-2 rounded-circle me-3 text-warning">
                            <i class="bi bi-pencil-square fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">Edit Teacher Profile</h5>
                            <small class="text-muted">Update information for {{ $teacher->user->name }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.teachers.update', $teacher->teacher_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Account Info -->
                        <h6 class="text-uppercase text-muted fw-bold small mb-3">Account Information</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-muted">Full Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $teacher->user->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Email Address</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $teacher->user->email) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
                                <small class="text-muted fst-italic">Only fill if changing.</small>
                            </div>
                        </div>

                        <hr class="border-light my-4">

                        <!-- Personal Details -->
                        <h6 class="text-uppercase text-muted fw-bold small mb-3">Personal Details</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">IC Number</label>
                                <input type="text" name="teacher_ic" class="form-control" value="{{ old('teacher_ic', $teacher->teacher_ic) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Date of Birth</label>
                                <input type="date" name="teacher_dob" class="form-control" value="{{ old('teacher_dob', $teacher->teacher_DOB) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Gender</label>
                                <select name="teacher_gender" class="form-select" required>
                                    <option value="Male" {{ old('teacher_gender', $teacher->teacher_gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('teacher_gender', $teacher->teacher_gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Phone Number</label>
                                <input type="text" name="teacher_phone_number" class="form-control" value="{{ old('teacher_phone_number', $teacher->teacher_phone_number) }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">Home Address</label>
                                <textarea name="teacher_address" class="form-control" rows="2" required>{{ old('teacher_address', $teacher->teacher_address) }}</textarea>
                            </div>
                        </div>

                        <hr class="border-light my-4">

                        <!-- Professional Details -->
                        <h6 class="text-uppercase text-muted fw-bold small mb-3">Professional Details</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Qualifications</label>
                                <input type="text" name="teacher_qualifications" class="form-control" value="{{ old('teacher_qualifications', $teacher->teacher_qualifications) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Employment Status</label>
                                <select name="teacher_status" class="form-select" required>
                                    <option value="Permanent" {{ old('teacher_status', $teacher->teacher_status) == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                                    <option value="Contract" {{ old('teacher_status', $teacher->teacher_status) == 'Contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="Internship" {{ old('teacher_status', $teacher->teacher_status) == 'Internship' ? 'selected' : '' }}>Internship</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-muted">Subjects Taught</label>
                                <input type="text" name="teacher_subjects" class="form-control" value="{{ old('teacher_subjects', $teacher->teacher_subjects) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Class Teacher Assigned</label>
                                <input type="text" name="teacher_form_class" class="form-control" value="{{ old('teacher_form_class', $teacher->teacher_form_class) }}" placeholder="e.g. 5 Bestari">
                            </div>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn fw-bold py-2 shadow-sm text-white" style="background-color: #6f42c1;">
                                <i class="bi bi-save me-2"></i> Update Changes
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection