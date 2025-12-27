@extends('layouts.studentLayout')

@section('title', 'My Profile')
@section('page-title', 'Student Profile')

@section('content')
<div class="container-fluid">

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('student.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">
            
            <!-- LEFT COLUMN: Profile Card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-5">
                        <div class="position-relative d-inline-block mb-4">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center shadow-lg" style="width: 120px; height: 120px; font-size: 3rem;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="position-absolute bottom-0 end-0 bg-primary border border-4 border-white rounded-circle p-2"></div>
                        </div>
                        <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                        <p class="text-muted mb-3">{{ $user->email }}</p>
                        
                        <div class="d-flex justify-content-center gap-2 mb-4">
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                Form {{ $student->student_form ?? 'N/A' }}
                            </span>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">
                                Student
                            </span>
                        </div>

                        <hr class="my-4 opacity-10">

                        <div class="text-start">
                            <p class="small text-uppercase text-muted fw-bold mb-2">Class Information</p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold text-dark"><i class="bi bi-mortarboard-fill me-2 text-success"></i>Current Class</span>
                                <span class="badge bg-light text-dark border">{{ $student->student_class ?? 'Not Assigned' }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark"><i class="bi bi-card-heading me-2 text-success"></i>IC Number</span>
                                <span class="font-monospace text-muted">{{ $student->student_ic ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Edit Form -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="fw-bold mb-0 text-success"><i class="bi bi-person-gear me-2"></i>Edit Profile Details</h5>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- Section: Personal Info -->
                        <h6 class="text-uppercase text-muted fw-bold small mb-3">User Information</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Full Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Email Address</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Age</label>
                                <input type="number" name="age" class="form-control" value="{{ old('age', $student->student_age) }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Date of Birth</label>
                                <input type="date" name="DOB" class="form-control" value="{{ old('DOB', $student->student_DOB) }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Gender</label>
                                <input type="text" name="gender" class="form-control" value="{{ old('gender', $student->student_gender) }}" readonly>
                                <!-- <select name="gender" class="form-select">
                                    <option value="Male" {{ (old('gender', $student->student_gender) == 'Male') ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ (old('gender', $student->student_gender) == 'Female') ? 'selected' : '' }}>Female</option>
                                </select> -->
                            </div>
                        </div>

                        <!-- Section: Contact Info -->
                        <h6 class="text-uppercase text-muted fw-bold small mb-3 border-top pt-3">Contact Details</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">NRIC / IC Number</label>
                                <input type="text" name="nric" class="form-control" value="{{ old('nric', $student->student_ic) }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Phone Number</label>
                                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $student->student_phone_number ?? '') }}" placeholder="+60...">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small">Home Address</label>
                                <textarea name="address" class="form-control" rows="2" required>{{ old('address', $student->student_address) }}</textarea>
                            </div>
                        </div>

                        <!-- Section: Academic Info -->
                        <h6 class="text-uppercase text-muted fw-bold small mb-3 border-top pt-3">Academic Info</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Form Level</label>
                                <input type="text" name="form" class="form-control" value="{{ old('form', $student->student_form) }}" readonly>
                                <!-- <select name="form" class="form-select">
                                    @for($i=1; $i<=6; $i++)
                                        <option value="{{ $i }}" {{ (old('form', $student->student_form) == $i) ? 'selected' : '' }}>Form {{ $i }}</option>
                                    @endfor
                                </select> -->
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Class Name</label>
                                <input type="text" name="class_name" class="form-control" value="{{ old('class_name', $student->student_class) }}" readonly>
                                <!-- <select name="class_name" class="form-select">
                                    @php $classes = ['Bestari', 'Cerdik', 'Amanah', 'Dedikasi', 'Efisien', 'Fikrah']; @endphp
                                    @foreach($classes as $cls)
                                        <option value="{{ $cls }}" {{ (str_contains($student->student_class, $cls)) ? 'selected' : '' }}>{{ $cls }}</option>
                                    @endforeach 
                                </select> -->
                            </div>
                        </div>

                        <!-- Section: Security -->
                        <h6 class="text-uppercase text-muted fw-bold small mb-3 border-top pt-3 text-danger">Security (Optional)</h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">New Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn btn-success px-4 fw-bold">Save Changes</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection