@extends('layouts.teacherLayout')

@section('title', 'Teacher Dashboard')
@section('page-title', 'Overview')

@section('content')
<div class="container-fluid">
    
    <!-- 1. Stats Cards Row -->
    <div class="row g-4 mb-5">
        <!-- Total Students Card -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-primary">
                            <i class="bi bi-people-fill fs-4"></i>
                        </div>
                        <span class="badge bg-light text-muted border">Annual</span>
                    </div>
                    <h2 class="display-5 fw-bold mb-1">{{ $totalStudents }}</h2>
                    <p class="text-muted small mb-0">Total Students Enrolled</p>
                    <!-- Decorative Shape -->
                    <i class="bi bi-people position-absolute text-primary opacity-10" style="font-size: 8rem; bottom: -20px; right: -20px;"></i>
                </div>
            </div>
        </div>

        <!-- Active Exams Card -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="bg-success bg-opacity-10 p-3 rounded-3 text-success">
                            <i class="bi bi-file-earmark-text-fill fs-4"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-25 text-success-emphasis">Active Now</span>
                    </div>
                    <h2 class="display-5 fw-bold mb-1">{{ $activeExams }}</h2>
                    <p class="text-muted small mb-0">Exams Currently Open</p>
                    <i class="bi bi-stopwatch position-absolute text-success opacity-10" style="font-size: 8rem; bottom: -20px; right: -20px;"></i>
                </div>
            </div>
        </div>

        <!-- Total Exams Created Card -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3 text-warning">
                            <i class="bi bi-archive-fill fs-4"></i>
                        </div>
                        <span class="badge bg-light text-muted border">Total</span>
                    </div>
                    <h2 class="display-5 fw-bold mb-1">{{ $totalExams }}</h2>
                    <p class="text-muted small mb-0">Exams Created in Total</p>
                    <i class="bi bi-folder position-absolute text-warning opacity-10" style="font-size: 8rem; bottom: -20px; right: -20px;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Chart & Recent Activity Row -->
    <div class="row g-4">
        
        <!-- Left Column: Student Growth Chart -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">Student Growth Analytics</h5>
                    <select class="form-select form-select-sm w-auto">
                        <option>Year {{ date('Y') }}</option>
                    </select>
                </div>
                <div class="card-body">
                    <canvas id="studentChart" height="120"></canvas>
                </div>
            </div>
        </div>

        <!-- Right Column: Quick Actions -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold text-dark">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('teacher.exams.create') }}" class="btn btn-primary py-3 text-start px-4 rounded-3 d-flex align-items-center justify-content-between transition-hover">
                            <span><i class="bi bi-plus-circle me-2"></i> Create New Exam</span>
                            <i class="bi bi-chevron-right small"></i>
                        </a>
                        <a href="{{ route('teacher.exams.create') }}" class="btn btn-outline-primary py-3 text-start px-4 rounded-3 d-flex align-items-center justify-content-between transition-hover">
                            <span><i class="bi bi-question-circle me-2"></i> Add Questions</span>
                            <i class="bi bi-chevron-right small"></i>
                        </a>
                        <a href="{{ route('teacher.students.list') }}" class="btn btn-light py-3 text-start px-4 rounded-3 d-flex align-items-center justify-content-between transition-hover">
                            <span><i class="bi bi-person-lines-fill me-2"></i> Manage Students</span>
                            <i class="bi bi-chevron-right small"></i>
                        </a>
                    </div>

                    <div class="mt-4 p-3 bg-light rounded-3 border border-dashed">
                        <h6 class="fw-bold text-dark mb-2">System Status</h6>
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>Database</span>
                            <span class="text-success fw-bold">Connected</span>
                        </div>
                        <div class="d-flex justify-content-between small text-muted">
                            <span>Last Backup</span>
                            <span>Today, 08:00 AM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- CHART.JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('studentChart').getContext('2d');
        
        // Data passed from Controller
        const labels = @json($labels);
        const data = @json($data);

        new Chart(ctx, {
            type: 'line', // Can be 'bar', 'line', 'pie'
            data: {
                labels: labels,
                datasets: [{
                    label: 'New Students Joined',
                    data: data,
                    backgroundColor: 'rgba(13, 110, 253, 0.1)', // Light Blue fill
                    borderColor: '#0d6efd', // Primary Blue line
                    borderWidth: 2,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#0d6efd',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4 // Makes the line curved
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false // Hide legend for cleaner look
                    },
                    tooltip: {
                        backgroundColor: '#0d6efd',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f0f0f0'
                        },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>

<style>
    .transition-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
</style>
@endsection