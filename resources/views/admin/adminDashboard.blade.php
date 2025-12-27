@extends('layouts.adminLayout')

@section('title', 'Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    
    <!-- Welcome Banner -->
    <div class="card border-0 shadow-sm mb-4 text-white overflow-hidden" style="background: linear-gradient(135deg, #6f42c1 0%, #4c2889 100%); border-radius: 15px;">
        <div class="card-body p-4 position-relative">
            <div class="row align-items-center position-relative z-1">
                <div class="col-md-8">
                    <h3 class="fw-bold mb-1">Welcome back, {{ Auth::user()->name }}!</h3>
                    <p class="mb-0 opacity-75">
                        <i class="bi bi-clock me-1"></i> {{ now()->format('l, d F Y') }}
                    </p>
                    <p class="mt-2 mb-0 small opacity-75">
                        Manage your school's data and users efficiently from this panel.
                    </p>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <i class="bi bi-shield-lock-fill display-1 opacity-25"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Students Card -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 feature-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <p class="text-muted small fw-bold text-uppercase mb-1">Total Students</p>
                            <h2 class="fw-bold mb-0 text-dark">{{ $totalStudents }}</h2>
                        </div>
                        <div class="icon-box bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-backpack4-fill fs-4"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center small">
                      <!--  route('admin.students.create')  -->
                        <a href="" class="text-decoration-none text-success fw-bold">
                            View All Students <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teachers Card -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 feature-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <p class="text-muted small fw-bold text-uppercase mb-1">Total Teachers</p>
                            <h2 class="fw-bold mb-0 text-dark">{{ $totalTeachers }}</h2>
                        </div>
                        <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-person-video3 fs-4"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center small">
                        <a href="" class="text-decoration-none text-primary fw-bold">
                            View All Teachers <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Exams Card -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 feature-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <p class="text-muted small fw-bold text-uppercase mb-1">Exams Created</p>
                            <h2 class="fw-bold mb-0 text-dark">{{ $totalExams }}</h2>
                        </div>
                        <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-file-earmark-text-fill fs-4"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center small">
                        <span class="text-muted">Managed by Teachers</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Registrations & Quick Actions -->
    <div class="row g-4">
        <!-- Recent Users Table -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-dark">Recently Registered Users</h6>
                    <span class="badge bg-light text-muted border">Last 5</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4">Name</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Registered</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentUsers as $user)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded-circle text-center d-flex align-items-center justify-content-center me-2 fw-bold text-secondary" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <span class="fw-bold text-dark">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($user->role === 'admin')
                                                <span class="badge bg-purple bg-opacity-10 text-purple border border-purple" style="color: #6f42c1; border-color: #6f42c1 !important;">Admin</span>
                                            @elseif($user->role === 'teacher')
                                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary">Teacher</span>
                                            @else
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success">Student</span>
                                            @endif
                                        </td>
                                        <td class="small text-muted">{{ $user->email }}</td>
                                        <td class="small text-muted">{{ $user->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold mb-0 text-dark">Quick Actions</h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-3">
                        <!--  route('admin.teachers.create')  -->
                        <a href="" class="btn btn-outline-primary py-3 fw-bold text-start">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-person-plus-fill"></i>
                                </div>
                                <div>
                                    <span class="d-block">Register New Teacher</span>
                                    <small class="fw-normal opacity-75" style="font-size: 0.75rem;">Create account for staff</small>
                                </div>
                            </div>
                        </a>

                        <!--  route('admin.students.create')  -->
                        <a href="" class="btn btn-outline-success py-3 fw-bold text-start">
                            <div class="d-flex align-items-center">
                                <div class="bg-success text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-backpack4-fill"></i>
                                </div>
                                <div>
                                    <span class="d-block">Register New Student</span>
                                    <small class="fw-normal opacity-75" style="font-size: 0.75rem;">Enroll new student</small>
                                </div>
                            </div>
                        </a>
                        
                        <div class="alert alert-light border mb-0 text-center small text-muted">
                            <i class="bi bi-info-circle me-1"></i> System Backup runs automatically every night at 12:00 AM.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .feature-card {
        transition: transform 0.2s;
    }
    .feature-card:hover {
        transform: translateY(-5px);
    }
</style>
@endsection