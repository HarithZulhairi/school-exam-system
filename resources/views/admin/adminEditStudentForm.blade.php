@extends('layouts.adminLayout')

@section('title', 'Edit Student')
@section('page-title', 'Edit Student Details')

@section('content')

<style>
    .btn-primary {
        background-color: #6f42c1;
        border-color: #6f42c1;
        color: white;
        transition: all 0.3s;
    }
    .btn-primary:hover {
        background-color: #4c2889;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(111, 66, 193, 0.2);
    }
</style>

<div class="container-fluid">

    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('admin.students.index') }}" class="btn btn-light border text-muted">
            <i class="bi bi-arrow-left me-2"></i> Back to Student List
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3 text-purple" style="color: #6f42c1;">
                            <i class="bi bi-pencil-square fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">Edit Student Profile</h5>
                            <small class="text-muted">Update information for {{ $student->user->name }}</small>
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

                    <!-- Update Form -->
                    <form action="{{ route('admin.students.update', $student->student_id) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Crucial for Update Requests -->

                        <!-- Section 1: Account Login -->
                        <h6 class="text-uppercase text-muted fw-bold small mb-3">Account Information</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-muted">Full Name</label>
                                <input type="text" name="name" class="form-control" 
                                       value="{{ old('name', $student->user->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Email Address</label>
                                <input type="email" name="email" class="form-control" 
                                       value="{{ old('email', $student->user->email) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
                                <small class="text-muted fst-italic" style="font-size: 0.75rem;">Only fill this if you want to change it.</small>
                            </div>
                        </div>

                        <hr class="border-light my-4">

                        <!-- Section 2: Personal Details -->
                        <h6 class="text-uppercase text-muted fw-bold small mb-3">Personal & Academic Details</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">IC Number (NRIC)</label>
                                <input type="text" name="student_ic" class="form-control" 
                                       value="{{ old('student_ic', $student->student_ic) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Date of Birth</label>
                                <input type="date" name="student_dob" class="form-control" 
                                       value="{{ old('student_dob', $student->student_DOB) }}" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Gender</label>
                                <select name="student_gender" class="form-select" required>
                                    <option value="Male" {{ old('student_gender', $student->student_gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('student_gender', $student->student_gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Phone Number</label>
                                <input type="text" name="student_phone_number" class="form-control" 
                                       value="{{ old('student_phone_number', $student->student_phone_number) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Form Level</label>
                                <select name="student_form" class="form-select" required>
                                    @for($i = 1; $i <= 6; $i++)
                                        <option value="{{ $i }}" {{ old('student_form', $student->student_form) == $i ? 'selected' : '' }}>Form {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Class Name</label>
                                <input type="text" name="student_class" class="form-control" 
                                       value="{{ old('student_class', $student->student_class) }}" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">Home Address</label>
                                <textarea name="student_address" class="form-control" rows="2" required>{{ old('student_address', $student->student_address) }}</textarea>
                            </div>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm">
                                <i class="bi bi-save me-2"></i> Save Changes
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection