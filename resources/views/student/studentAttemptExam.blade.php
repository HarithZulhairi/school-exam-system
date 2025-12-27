@extends('layouts.studentLayout')

@section('title', 'Attempting Exam')
@section('page-title', $exam->title)

@section('content')
<div class="container-fluid">
    
    <form action="{{ route('student.exams.store', $exam->exam_id) }}" method="POST" id="examForm">
        @csrf

        <div class="row">
            <!-- Left Column: Questions -->
            <div class="col-lg-9">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="fw-bold mb-0 text-primary">
                            <i class="bi bi-pencil-square me-2"></i>Answer All Questions
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @foreach($exam->questions as $index => $question)
                            <div class="mb-5 question-block" id="q{{ $question->question_id }}">
                                <div class="d-flex mb-3">
                                    <span class="badge bg-light text-dark border me-3 h-100 fs-6">Q{{ $index + 1 }}</span>
                                    <div>
                                        <h6 class="fw-bold text-dark lh-base">{{ $question->question_text }}</h6>
                                    </div>
                                </div>

                                <div class="ms-5">
                                    <!-- Option A -->
                                    <div class="form-check mb-2 p-3 border rounded hover-bg-light">
                                        <input class="form-check-input cursor-pointer" type="radio" 
                                               name="answers[{{ $question->question_id }}]" 
                                               id="q{{ $question->question_id }}_a" value="a">
                                        <label class="form-check-label w-100 cursor-pointer" for="q{{ $question->question_id }}_a">
                                            <strong class="me-2 text-primary">A.</strong> {{ $question->option_a }}
                                        </label>
                                    </div>

                                    <!-- Option B -->
                                    <div class="form-check mb-2 p-3 border rounded hover-bg-light">
                                        <input class="form-check-input cursor-pointer" type="radio" 
                                               name="answers[{{ $question->question_id }}]" 
                                               id="q{{ $question->question_id }}_b" value="b">
                                        <label class="form-check-label w-100 cursor-pointer" for="q{{ $question->question_id }}_b">
                                            <strong class="me-2 text-primary">B.</strong> {{ $question->option_b }}
                                        </label>
                                    </div>

                                    <!-- Option C -->
                                    <div class="form-check mb-2 p-3 border rounded hover-bg-light">
                                        <input class="form-check-input cursor-pointer" type="radio" 
                                               name="answers[{{ $question->question_id }}]" 
                                               id="q{{ $question->question_id }}_c" value="c">
                                        <label class="form-check-label w-100 cursor-pointer" for="q{{ $question->question_id }}_c">
                                            <strong class="me-2 text-primary">C.</strong> {{ $question->option_c }}
                                        </label>
                                    </div>

                                    <!-- Option D -->
                                    <div class="form-check mb-2 p-3 border rounded hover-bg-light">
                                        <input class="form-check-input cursor-pointer" type="radio" 
                                               name="answers[{{ $question->question_id }}]" 
                                               id="q{{ $question->question_id }}_d" value="d">
                                        <label class="form-check-label w-100 cursor-pointer" for="q{{ $question->question_id }}_d">
                                            <strong class="me-2 text-primary">D.</strong> {{ $question->option_d }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @if(!$loop->last) <hr class="border-light my-4"> @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column: Timer & Submit -->
            <div class="col-lg-3">
                <div class="sticky-top" style="top: 20px; z-index: 100;">
                    <!-- Timer Card -->
                    <div class="card border-0 shadow-sm mb-3 bg-dark text-white text-center">
                        <div class="card-body py-3">
                            <small class="text-uppercase opacity-75 fw-bold letter-spacing-1">Time Remaining</small>
                            <div class="h2 fw-bold mb-0 mt-1 font-monospace" id="timer">Loading...</div>
                        </div>
                    </div>

                    <!-- Info Card -->
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body small">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Questions:</span>
                                <span class="fw-bold">{{ $exam->questions->count() }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Ends At:</span>
                                <span class="fw-bold">{{ \Carbon\Carbon::parse($endTime)->format('h:i A') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="button" class="btn btn-success w-100 fw-bold py-3 shadow-sm" onclick="confirmSubmit()">
                        <i class="bi bi-check-circle-fill me-2"></i> Submit Exam
                    </button>
                    <div class="text-center mt-2">
                        <small class="text-muted fst-italic">Double check before submitting!</small>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .hover-bg-light:hover { background-color: #f8f9fa; border-color: #dee2e6 !important; }
    .cursor-pointer { cursor: pointer; }
</style>

<script>
    // 1. Timer Logic
    const endTime = new Date("{{ $endTime->format('Y-m-d H:i:s') }}").getTime();

    const timerInterval = setInterval(function() {
        const now = new Date().getTime();
        const distance = endTime - now;

        // Calculations
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display
        document.getElementById("timer").innerHTML = 
            (hours < 10 ? "0" + hours : hours) + ":" + 
            (minutes < 10 ? "0" + minutes : minutes) + ":" + 
            (seconds < 10 ? "0" + seconds : seconds);

        // If time is up
        if (distance < 0) {
            clearInterval(timerInterval);
            document.getElementById("timer").innerHTML = "00:00:00";
            document.getElementById("timer").classList.add("text-danger");
            alert("Time is up! Your exam will be submitted automatically.");
            document.getElementById("examForm").submit();
        }
    }, 1000);

    // 2. Submit Confirmation
    function confirmSubmit() {
        // Optional: Check if all questions are answered
        // const totalQuestions = {{ $exam->questions->count() }};
        // const answered = document.querySelectorAll('input[type="radio"]:checked').length;
        
        if (confirm("Are you sure you want to submit?\nYou will not be able to change your answers after this.")) {
            document.getElementById("examForm").submit();
        }
    }

    // 3. Prevent accidental leave
    window.onbeforeunload = function() {
        return "Are you sure you want to leave? Your progress will be lost.";
    };
    
    // Allow submit to bypass the warning
    document.getElementById("examForm").addEventListener("submit", function() {
        window.onbeforeunload = null;
    });
</script>
@endsection