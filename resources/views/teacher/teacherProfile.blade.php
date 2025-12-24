@extends('layouts.teacherLayout')

@section('title', 'My Profile')
@section('page-title', 'Teacher Profile')

@section('content')
<div class="container-fluid">

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
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

    <form action="{{ route('teacher.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">
            
            <!-- LEFT COLUMN: Profile Card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-5">
                        <div class="position-relative d-inline-block mb-4">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-lg" style="width: 120px; height: 120px; font-size: 3rem;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="position-absolute bottom-0 end-0 bg-success border border-4 border-white rounded-circle p-2"></div>
                        </div>
                        <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                        <p class="text-muted mb-3">{{ $teacher->teacher_qualifications ?? 'Education Professional' }}</p>
                        
                        <div class="d-flex justify-content-center gap-2 mb-4">
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                {{ $teacher->teacher_status ?? 'Active' }}
                            </span>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">
                                {{ $user->role }}
                            </span>
                        </div>

                        <hr class="my-4 opacity-10">

                        <div class="text-start">
                            <p class="small text-uppercase text-muted fw-bold mb-2">Teaching Subjects</p>
                            <div class="d-flex flex-wrap gap-2">
                                @forelse($currentSubjects as $subject)
                                    <span class="badge bg-light text-dark border">{{ $subject }}</span>
                                @empty
                                    <span class="text-muted small">No subjects assigned.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Edit Form -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-person-gear me-2"></i>Edit Profile Details</h5>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- Section: Personal Info -->
                        <h6 class="text-uppercase text-muted fw-bold small mb-3">User Information</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Full Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Email Address</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Age</label>
                                <input type="number" name="age" class="form-control" value="{{ old('age', $teacher->teacher_age) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Date of Birth</label>
                                <input type="date" name="DOB" class="form-control" value="{{ old('DOB', $teacher->teacher_DOB) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="Male" {{ (old('gender', $teacher->teacher_gender) == 'Male') ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ (old('gender', $teacher->teacher_gender) == 'Female') ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                        </div>

                        <!-- Section: Professional Info -->
                        <h6 class="text-uppercase text-muted fw-bold small mb-3 border-top pt-3">Professional Details</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">NRIC / IC Number</label>
                                <input type="text" name="nric" class="form-control" value="{{ old('nric', $teacher->teacher_ic) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Employment Status</label>
                                <select name="status" class="form-select">
                                    <option value="Permanent" {{ (old('status', $teacher->teacher_status) == 'Permanent') ? 'selected' : '' }}>Permanent</option>
                                    <option value="Contract" {{ (old('status', $teacher->teacher_status) == 'Contract') ? 'selected' : '' }}>Contract</option>
                                    <option value="Internship" {{ (old('status', $teacher->teacher_status) == 'Internship') ? 'selected' : '' }}>Internship</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Phone Number</label>
                                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $teacher->teacher_phone_number ?? '') }}" placeholder="+60...">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small">Mailing Address</label>
                                <textarea name="address" class="form-control" rows="2" required>{{ old('address', $teacher->teacher_address) }}</textarea>
                            </div>
                        </div>

                        <!-- Section: Subjects & Qualifications -->
                        <h6 class="text-uppercase text-muted fw-bold small mb-3 border-top pt-3">Academic Info</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <label class="form-label fw-bold small">Subjects Taught (Hold Ctrl/Cmd to select multiple)</label>
                                <select name="subjects[]" class="form-select" multiple size="5" required>
                                    @php $allSubjects = ['Bahasa Melayu', 'English', 'Mathematics', 'Science', 'History', 'Geography', 'Physics', 'Chemistry', 'Biology', 'Pendidikan Islam', 'Moral']; @endphp
                                    @foreach($allSubjects as $sub)
                                        <option value="{{ $sub }}" {{ in_array($sub, old('subjects', $currentSubjects)) ? 'selected' : '' }}>
                                            {{ $sub }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Selected: {{ implode(', ', $currentSubjects) }}</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small">Form teaching</label>
                                <select type="number" name="form_class" class="form-control" value="{{ old('form_class', $teacher->teacher_form_class) }}" required>
                                    <option value="">{{ old('form_class', $teacher->teacher_form_class) }}</option>
                                    @php $allClasses = ['1 Bestari', '1 Cerdik', '1 Amanah', '1 Dedikasi', '2 Bestari', '2 Cerdik', '2 Amanah', '2 Dedikasi', '3 Bestari', '3 Cerdik', '3 Amanah', '3 Dedikasi', '4 Bestari', '4 Cerdik', '4 Amanah', '4 Dedikasi', '5 Bestari', '5 Cerdik', '5 Amanah', '5 Dedikasi']; @endphp
                                    @foreach($allClasses as $cls)
                                        <option value="{{ $cls }}" {{ old('form_class', $teacher->teacher_form_class) == $cls ? 'selected' : '' }}> {{ $cls }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small">Academic Qualifications</label>
                                <textarea name="qualifications" class="form-control" rows="2" placeholder="e.g. Bachelor of Education (Mathematics)" required>{{ old('qualifications', $teacher->teacher_qualifications) }}</textarea>
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
                            <button type="reset" class="btn btn-light border">Reset</button>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">Save Changes</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection