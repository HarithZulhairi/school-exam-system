@extends('layouts.adminLayout')

@section('title', 'My Profile')
@section('page-title', 'Admin Profile')

@section('content')

<!-- Custom Purple Button Style for this page -->
<style>
    .btn-purple {
        background-color: #6f42c1;
        border-color: #6f42c1;
        color: white;
        transition: all 0.3s;
    }
    .btn-purple:hover {
        background-color: #5a32a3;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(111, 66, 193, 0.2);
    }
    .text-purple {
        color: #6f42c1 !important;
    }
    .bg-purple-light {
        background-color: rgba(111, 66, 193, 0.1);
        color: #6f42c1;
    }
</style>

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

    <form action="{{ route('admin.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">
            
            <!-- LEFT COLUMN: Profile Card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-5">
                        <!-- Avatar -->
                        <div class="position-relative d-inline-block mb-4">
                            <div class="bg-purple-light rounded-circle d-flex align-items-center justify-content-center shadow-sm border border-2 border-white" style="width: 120px; height: 120px; font-size: 3rem;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="position-absolute bottom-0 end-0 bg-success border border-4 border-white rounded-circle p-2" title="Online"></div>
                        </div>
                        
                        <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                        <p class="text-muted mb-3">{{ $admin->admin_position ?? 'Administrator' }}</p>
                        
                        <div class="d-flex justify-content-center gap-2 mb-4">
                            <span class="badge bg-purple-light px-3 py-2 rounded-pill border border-purple">
                                <i class="bi bi-shield-lock-fill me-1"></i> Admin
                            </span>
                            <span class="badge bg-light text-dark px-3 py-2 rounded-pill border">
                                ID: {{ $admin->admin_id }}
                            </span>
                        </div>

                        <hr class="my-4 opacity-10">

                        <div class="text-start">
                            <p class="small text-uppercase text-muted fw-bold mb-3">Contact Information</p>
                            
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-light rounded-circle p-2 me-3 text-purple">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Email Address</small>
                                    <span class="fw-bold text-dark">{{ $user->email }}</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-light rounded-circle p-2 me-3 text-purple">
                                    <i class="bi bi-telephone"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Phone Number</small>
                                    <span class="fw-bold text-dark">{{ $admin->admin_phone_number ?? '-' }}</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle p-2 me-3 text-purple">
                                    <i class="bi bi-calendar-event"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Joined</small>
                                    <span class="fw-bold text-dark">{{ $user->created_at->format('M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Edit Form -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-0 d-flex align-items-center">
                        <div class="bg-purple-light p-2 rounded-circle me-3">
                            <i class="bi bi-person-gear fs-4"></i>
                        </div>
                        <h5 class="fw-bold mb-0 text-dark">Edit Profile Details</h5>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- Section: Personal Info -->
                        <h6 class="text-uppercase text-muted fw-bold small mb-3">Personal Information</h6>
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
                                <label class="form-label fw-bold small">Phone Number</label>
                                <input type="text" name="admin_phone_number" class="form-control" value="{{ old('admin_phone_number', $admin->admin_phone_number) }}" placeholder="+60...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Age</label>
                                <input type="number" name="admin_age" class="form-control" value="{{ old('admin_age', $admin->admin_age) }}" required>
                            </div>
                        </div>

                        <!-- Section: Role Info -->
                        <h6 class="text-uppercase text-muted fw-bold small mb-3 border-top pt-3">Role Information</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label fw-bold small">Official Position</label>
                                <input type="text" name="admin_position" class="form-control" value="{{ old('admin_position', $admin->admin_position) }}" required placeholder="e.g. Senior Administrator">
                            </div>
                        </div>

                        <!-- Section: Security -->
                        <h6 class="text-uppercase text-muted fw-bold small mb-3 border-top pt-3 text-danger">Security (Change Password)</h6>
                        <div class="alert alert-light border mb-3 small">
                            <i class="bi bi-info-circle me-2"></i> Leave the password fields blank if you do not wish to change your password.
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">New Password</label>
                                <input type="password" name="password" class="form-control" placeholder="New password">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="reset" class="btn btn-light border fw-bold px-4">Reset</button>
                            <button type="submit" class="btn btn-purple px-4 fw-bold shadow-sm">
                                <i class="bi bi-check-circle-fill me-2"></i> Save Changes
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection