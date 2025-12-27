@extends('layouts.adminLayout')

@section('title', 'Student Details')
@section('page-title', 'Student Profile')

@section('content')
<div class="container-fluid">

    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('admin.students.index') }}" class="btn btn-light border text-muted">
            <i class="bi bi-arrow-left me-2"></i> Back to Student List
        </a>
    </div>

    <div class="row g-4">
        <!-- LEFT COLUMN: Student Bio -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; font-size: 2.5rem;">
                            {{ strtoupper(substr($student->user->name, 0, 1)) }}
                        </div>
                    </div>
                    <h4 class="fw-bold text-dark mb-1">{{ $student->user->name }}</h4>
                    <p class="text-muted small">{{ $student->user->email }}</p>
                    
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mt-2">
                        Form {{ $student->student_form }} - {{ $student->student_class }}
                    </span>

                    <hr class="my-4 opacity-10">

                    <div class="text-start">
                        <h6 class="text-uppercase text-muted fw-bold small mb-3">Personal Details</h6>
                        
                        <div class="mb-3">
                            <label class="small text-muted d-block">IC / NRIC</label>
                            <span class="fw-bold text-dark font-monospace">{{ $student->student_ic }}</span>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="small text-muted d-block">Age</label>
                                <span class="fw-bold text-dark">{{ $student->student_age }} Years</span>
                            </div>
                            <div class="col-6">
                                <label class="small text-muted d-block">Gender</label>
                                <span class="fw-bold text-dark">{{ $student->student_gender }}</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small text-muted d-block">Date of Birth</label>
                            <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($student->student_DOB)->format('d F, Y') }}</span>
                        </div>

                        <div class="mb-3">
                            <label class="small text-muted d-block">Phone Number</label>
                            <span class="fw-bold text-dark">{{ $student->student_phone_number ?? '-' }}</span>
                        </div>

                        <div class="mb-3">
                            <label class="small text-muted d-block">Address</label>
                            <span class="fw-bold text-dark">{{ $student->student_address }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Exam Results -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-trophy me-2"></i>Exam Results History</h5>
                    <span class="badge bg-light text-dark border">Total Exams: {{ $student->results->count() }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-uppercase small text-muted">
                                <tr>
                                    <th scope="col" class="ps-4 py-3">Exam Title</th>
                                    <th scope="col" class="py-3">Date</th>
                                    <th scope="col" class="py-3 text-center">Score</th>
                                    <th scope="col" class="py-3 text-center">Total</th>
                                    <th scope="col" class="py-3 text-center">Grade</th>
                                    <th scope="col" class="pe-4 py-3 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($student->results as $result)
                                    @php
                                        // Calculate Percentage
                                        $percentage = ($result->total_questions > 0) ? ($result->score / $result->total_questions) * 100 : 0;
                                        
                                        // Simple Grading Logic
                                        $grade = 'F';
                                        $badgeClass = 'bg-danger text-white';
                                        
                                        if($percentage >= 80) { $grade = 'A'; $badgeClass = 'bg-success text-white'; }
                                        elseif($percentage >= 70) { $grade = 'B'; $badgeClass = 'bg-primary text-white'; }
                                        elseif($percentage >= 60) { $grade = 'C'; $badgeClass = 'bg-info text-dark'; }
                                        elseif($percentage >= 50) { $grade = 'D'; $badgeClass = 'bg-warning text-dark'; }
                                        elseif($percentage >= 40) { $grade = 'E'; $badgeClass = 'bg-secondary text-white'; }
                                    @endphp
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $result->exam->title ?? 'Unknown Exam' }}</div>
                                            <div class="small text-muted">Form {{ $result->exam->exam_form ?? '-' }}</div>
                                        </td>
                                        <td>
                                            @if(isset($result->exam->exam_date))
                                                <i class="bi bi-calendar-event me-1 text-muted"></i> 
                                                {{ \Carbon\Carbon::parse($result->exam->exam_date)->format('d M, Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center fw-bold text-primary fs-5">
                                            {{ $result->score }}
                                        </td>
                                        <td class="text-center text-muted">
                                            / {{ $result->total_questions }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ $badgeClass }} rounded-pill px-3" style="width: 40px;">
                                                {{ $grade }}
                                            </span>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <a href="{{ route('admin.exams.result.details', $result->result_id) }}" class="btn btn-sm btn-outline-primary fw-bold">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="bi bi-clipboard-x display-6 mb-3 d-block"></i>
                                            No exam results found for this student.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection