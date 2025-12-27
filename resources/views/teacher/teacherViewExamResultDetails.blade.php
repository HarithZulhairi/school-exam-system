@extends('layouts.teacherLayout')

@section('title', 'Exam Results')
@section('page-title', 'Exam Results: ' . $exam->title)

@section('content')
<div class="container-fluid">
    
    <!-- Score Card -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-6 text-center">
            @php
                $percentage = ($score / $totalQuestions) * 100;
                $gradeColor = $percentage >= 80 ? 'success' : ($percentage >= 50 ? 'primary' : 'danger');
                $gradeText = $percentage >= 80 ? 'Excellent!' : ($percentage >= 50 ? 'Good Job!' : 'Keep Trying!');
            @endphp

            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <div class="mb-3">
                        <i class="bi bi-trophy-fill text-{{ $gradeColor }}" style="font-size: 4rem;"></i>
                    </div>
                    <h2 class="fw-bold mb-1">{{ $gradeText }}</h2>
                    @if ($student->student_gender == 'Male')
                    <p class="text-muted mb-4">He has completed the exam.</p>
                    @else
                    <p class="text-muted mb-4">She has completed the exam.</p>
                    @endif

                    <div class="display-1 fw-bold text-{{ $gradeColor }} mb-2">
                        {{ $score }} <span class="fs-4 text-muted">/ {{ $totalQuestions }}</span>
                    </div>
                    <div class="progress mb-3" style="height: 10px;">
                        <div class="progress-bar bg-{{ $gradeColor }}" role="progressbar" style="width: {{ $percentage }}%"></div>
                    </div>
                    <p class="mb-4 fw-bold">Score: {{ number_format($percentage, 0) }}%</p>
                    <div class="d-grid">
                        <a href="{{ route('teacher.students.show', $student->student_id) }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-left me-2"></i> Back to student details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Answer Review -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h5 class="fw-bold mb-3 text-muted">Answer Review</h5>
            
            @foreach($detailedResults as $index => $result)
                <div class="card border-0 shadow-sm mb-3 {{ $result['is_correct'] ? 'border-start border-success border-5' : 'border-start border-danger border-5' }}">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="badge bg-light text-dark border">Q{{ $index + 1 }}</span>
                            @if($result['is_correct'])
                                <span class="badge bg-success"><i class="bi bi-check-lg me-1"></i> Correct</span>
                            @else
                                <span class="badge bg-danger"><i class="bi bi-x-lg me-1"></i> Incorrect</span>
                            @endif
                        </div>
                        
                        <h6 class="fw-bold mb-3">{{ $result['question']->question_text }}</h6>

                        <div class="row g-2 small">
                            <div class="col-md-6">
                                <div class="p-3 rounded {{ $result['student_answer'] == $result['correct_answer'] ? 'bg-success bg-opacity-10 border border-success' : 'bg-light border' }}">
                                    <span class="d-block text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Your Answer</span>
                                    <span class="fw-bold">
                                        {{ $result['student_answer'] ? strtoupper($result['student_answer']) . '. ' . $result['question']->{'option_'.$result['student_answer']} : 'No Answer' }}
                                    </span>
                                </div>
                            </div>
                            
                            @if(!$result['is_correct'])
                                <div class="col-md-6">
                                    <div class="p-3 rounded bg-white border border-success">
                                        <span class="d-block text-success text-uppercase fw-bold" style="font-size: 0.7rem;">Correct Answer</span>
                                        <span class="fw-bold text-success">
                                            {{ strtoupper($result['correct_answer']) }}. {{ $result['question']->{'option_'.$result['correct_answer']} }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
@endsection