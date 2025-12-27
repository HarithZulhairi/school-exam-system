@extends('layouts.studentLayout')

@section('title', 'Available Exams')
@section('page-title', 'Enroll in Exam')

@section('content')
<div class="container-fluid">

    <!-- Header Banner -->
    <div class="card border-0 shadow-sm mb-4 bg-success text-white overflow-hidden">
        <div class="card-body p-4 position-relative">
            <div class="row align-items-center position-relative z-1">
                <div class="col-md-8">
                    <h4 class="fw-bold mb-1">Form {{ $student->student_form }} Examinations</h4>
                    <p class="mb-0 opacity-75">
                        These are the assessments currently scheduled for your form level.
                        Please ensure you are ready before the start time.
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="bg-white bg-opacity-25 rounded-3 p-2 d-inline-block text-center px-4">
                        <span class="d-block small text-uppercase fw-bold opacity-75">Current Time</span>
                        <span class="h5 fw-bold mb-0" id="clock">{{ \Carbon\Carbon::now()->format('h:i A') }}</span>
                        <div class="small">{{ \Carbon\Carbon::now()->format('d M Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Exam Grid -->
    @if($exams->count() > 0)
        <div class="row g-4">
            @foreach($exams as $exam)
                @php
                    // Time Logic using Carbon
                    $now = \Carbon\Carbon::now();
                    
                    // Parse Date and Times
                    $examDate = \Carbon\Carbon::parse($exam->exam_date);
                    $startTime = \Carbon\Carbon::parse($exam->exam_date . ' ' . $exam->exam_start_time);
                    $endTime = \Carbon\Carbon::parse($exam->exam_date . ' ' . $exam->exam_end_time);
                    
                    // Determine Status
                    $isToday = $examDate->isToday();
                    $isRunning = $now->between($startTime, $endTime);
                    $isUpcoming = $now->lt($startTime);
                    $isEnded = $now->gt($endTime);
                @endphp

                <div class="col-md-6 col-xl-4">
                    <div class="card border-0 shadow-sm h-100 hover-card {{ $isEnded ? 'opacity-75 bg-light' : '' }}">
                        <!-- Card Header Status -->
                        <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-start {{ $isEnded ? 'bg-light' : '' }}">
                            <div>
                                <span class="badge {{ $isRunning ? 'bg-success' : ($isEnded ? 'bg-secondary' : 'bg-primary') }} bg-opacity-10 text-{{ $isRunning ? 'success' : ($isEnded ? 'secondary' : 'primary') }} px-3 py-2 rounded-pill mb-2">
                                    {{ $exam->exam_subject }}
                                </span>
                                <div class="small text-muted fw-bold">{{ $exam->exam_paper }}</div>
                            </div>
                            
                            @if($isRunning)
                                <span class="badge bg-danger animate-pulse">LIVE NOW</span>
                            @elseif($isUpcoming)
                                <span class="badge bg-info text-dark">UPCOMING</span>
                            @else
                                <span class="badge bg-secondary">CLOSED</span>
                            @endif
                        </div>

                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-2">{{ $exam->title }}</h5>
                            <p class="text-muted small mb-3">{{ Str::limit($exam->exam_description, 60) }}</p>
                            
                            <!-- Exam Details List -->
                            <div class="v-stack gap-2 small">
                                <div class="d-flex align-items-center text-muted">
                                    <i class="bi bi-calendar-event me-2 text-primary"></i> 
                                    <span class="fw-bold me-1">Date:</span> {{ $examDate->format('d M, Y') }}
                                </div>
                                <div class="d-flex align-items-center {{ $isRunning ? 'text-success fw-bold' : 'text-muted' }}">
                                    <i class="bi bi-clock me-2 {{ $isRunning ? 'text-success' : 'text-primary' }}"></i> 
                                    <span class="fw-bold me-1">Time:</span> 
                                    {{ $startTime->format('h:i A') }} - {{ $endTime->format('h:i A') }}
                                </div>
                                <div class="d-flex align-items-center text-muted">
                                    <i class="bi bi-hourglass-split me-2 text-primary"></i> 
                                    <span class="fw-bold me-1">Duration:</span> {{ $exam->duration_minutes }} Minutes
                                </div>
                            </div>

                            <hr class="border-light my-3">

                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                    <i class="bi bi-person-fill text-muted"></i>
                                </div>
                                <span class="small text-muted fw-bold">{{ $exam->teacher->user->name ?? 'Instructor' }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons based on Time -->
                        <div class="card-footer bg-white border-0 p-4 pt-0 {{ $isEnded ? 'bg-light' : '' }}">
                            @if($isRunning)
                                <!-- Case 1: Exam is LIVE -->
                                <a href="{{ route('student.exams.show', $exam->exam_id) }}" class="btn btn-success w-100 py-2 fw-bold shadow-sm">
                                    <i class="bi bi-play-circle-fill me-2"></i> Start Exam
                                </a>
                            @elseif($isUpcoming)
                                <!-- Case 2: Exam is in Future -->
                                <button disabled class="btn btn-light text-muted border w-100 py-2 fw-bold">
                                    <i class="bi bi-lock-fill me-2"></i> Opens at {{ $startTime->format('h:i A') }}
                                </button>
                                @if($isToday)
                                    <small class="d-block text-center text-primary mt-2 fw-bold">Starting Soon</small>
                                @endif
                            @else
                                <!-- Case 3: Exam Ended -->
                                <button disabled class="btn btn-secondary w-100 py-2 fw-bold">
                                    <i class="bi bi-x-circle me-2"></i> Exam Ended
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="mb-4">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                    <i class="bi bi-journal-x text-muted opacity-50 display-4"></i>
                </div>
            </div>
            <h4 class="fw-bold text-dark">No Exams Found</h4>
            <p class="text-muted col-md-6 mx-auto">
                There are currently no exams scheduled for <strong>Form {{ $student->student_form }}</strong>.
            </p>
        </div>
    @endif

</div>

<script>
    // Simple clock to show user the system time is moving
    setInterval(() => {
        const now = new Date();
        document.getElementById('clock').innerText = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }, 1000);
</script>

<style>
    .hover-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .hover-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
    .animate-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: .5; } }
</style>
@endsection