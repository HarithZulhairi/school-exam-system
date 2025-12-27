@extends('layouts.studentLayout')

@section('title', 'Student Dashboard')
@section('page-title', 'My Dashboard')

@section('content')
<div class="container-fluid">
    
    <!-- 1. Stats Cards -->
    <div class="row g-4 mb-5">
        <!-- Active Exams -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="bg-success bg-opacity-10 p-3 rounded-3 text-success">
                            <i class="bi bi-broadcast fs-4"></i>
                        </div>
                        <span class="badge bg-light text-muted border">Available</span>
                    </div>
                    <h2 class="display-5 fw-bold mb-1">{{ $availableExams }}</h2>
                    <p class="text-muted small mb-0">Exams Open Now</p>
                    <i class="bi bi-wifi position-absolute text-success opacity-10" style="font-size: 8rem; bottom: -20px; right: -20px;"></i>
                </div>
            </div>
        </div>

        <!-- Exams Taken -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-primary">
                            <i class="bi bi-pencil-square fs-4"></i>
                        </div>
                        <span class="badge bg-light text-muted border">Total</span>
                    </div>
                    <h2 class="display-5 fw-bold mb-1">{{ $examsTaken }}</h2>
                    <p class="text-muted small mb-0">Exams Completed</p>
                    <i class="bi bi-file-earmark-check position-absolute text-primary opacity-10" style="font-size: 8rem; bottom: -20px; right: -20px;"></i>
                </div>
            </div>
        </div>

        <!-- Average Score -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3 text-warning">
                            <i class="bi bi-trophy-fill fs-4"></i>
                        </div>
                        <span class="badge bg-light text-muted border">Performance</span>
                    </div>
                    <h2 class="display-5 fw-bold mb-1">{{ $averageScore }}%</h2>
                    <p class="text-muted small mb-0">Average Score</p>
                    <i class="bi bi-bar-chart-fill position-absolute text-warning opacity-10" style="font-size: 8rem; bottom: -20px; right: -20px;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Chart & Actions -->
    <div class="row g-4">
        
        <!-- Left: Activity Chart -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">My Exam Activity</h5>
                    <span class="badge bg-light text-dark border">Year {{ date('Y') }}</span>
                </div>
                <div class="card-body">
                    <canvas id="myActivityChart" height="120"></canvas>
                </div>
            </div>
        </div>

        <!-- Right: Quick Actions -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold text-dark">What to do next?</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('student.exams.index') }}" class="btn btn-success py-3 text-start px-4 rounded-3 d-flex align-items-center justify-content-between transition-hover text-white">
                            <span><i class="bi bi-play-circle me-2"></i> Take an Exam</span>
                            <i class="bi bi-chevron-right small"></i>
                        </a>
                        <a href="{{ route('student.exams.history') }}" class="btn btn-outline-success py-3 text-start px-4 rounded-3 d-flex align-items-center justify-content-between transition-hover">
                            <span><i class="bi bi-clock-history me-2"></i> View History</span>
                            <i class="bi bi-chevron-right small"></i>
                        </a>
                        <a href="{{ route('student.profile') }}" class="btn btn-light py-3 text-start px-4 rounded-3 d-flex align-items-center justify-content-between transition-hover">
                            <span><i class="bi bi-person-badge me-2"></i> Update Profile</span>
                            <i class="bi bi-chevron-right small"></i>
                        </a>
                    </div>

                    <div class="mt-4 p-3 bg-light rounded-3 border border-dashed">
                        <h6 class="fw-bold text-dark mb-2">My Profile Status</h6>
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>Class</span>
                            <span class="text-dark fw-bold">{{ Auth::user()->student->student_class ?? 'N/A' }}</span>
                        </div>
                        <div class="d-flex justify-content-between small text-muted">
                            <span>IC Number</span>
                            <span>{{ Auth::user()->student->student_ic ?? 'N/A' }}</span>
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
        const ctx = document.getElementById('myActivityChart').getContext('2d');
        
        const labels = @json($labels);
        const data = @json($data);

        new Chart(ctx, {
            type: 'line', 
            data: {
                labels: labels,
                datasets: [{
                    label: 'Exams Completed',
                    data: data,
                    // Green Theme for Students
                    backgroundColor: 'rgba(25, 135, 84, 0.1)', 
                    borderColor: '#198754', 
                    borderWidth: 2,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#198754',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#198754',
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
                        grid: { color: '#f0f0f0' },
                        ticks: { stepSize: 1 }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>

<style>
    .transition-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.15); /* Green shadow */
    }
</style>
@endsection