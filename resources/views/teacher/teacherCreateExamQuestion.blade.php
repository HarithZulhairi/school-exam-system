@extends('layouts.teacherLayout')

@section('title', isset($exam) ? 'Add Questions' : 'Create New Exam')
@section('page-title', isset($exam) ? 'Exam Builder' : 'Create New Exam')

@section('content')
<div class="container-fluid">

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-10">

            <!-- =========================================================
                 STEP 1: CREATE EXAM FORM (Only show if $exam is NOT set) 
                 ========================================================= -->
            @if (!isset($exam))
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-2 rounded me-3 text-primary">
                                <span class="fw-bold">01</span>
                            </div>
                            <h5 class="fw-bold mb-0 text-dark">Exam Configuration</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('teacher.exams.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                
                                <!-- Title -->
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small text-muted">Exam Title</label>
                                    <input type="text" name="title" class="form-control form-control-lg" placeholder="e.g. Peperiksaan Akhir Tahun Matematik 2025" required>
                                </div>

                                <!-- Subject -->
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">Subject</label>
                                    <select name="exam_subject" class="form-select" required>
                                        <option value="" disabled selected>Select Subject</option>
                                        <option value="Bahasa Melayu">Bahasa Melayu</option>
                                        <option value="Bahasa Inggeris">Bahasa Inggeris</option>
                                        <option value="Matematik">Matematik</option>
                                        <option value="Pendidikan Islam">Pendidikan Islam</option>
                                        <option value="Pendidikan Moral">Pendidikan Moral</option>
                                        <option value="Sejarah">Sejarah</option>
                                        <option value="Pendidikan Jasmani dan Kesihatan">Pendidikan Jasmani dan Kesihatan</option>
                                        <option value="Biologi">Biologi</option>
                                        <option value="Fizik">Fizik</option>
                                        <option value="Kimia">Kimia</option>
                                        <option value="Matematik Tambahan">Matematik Tambahan</option>
                                    </select>
                                </div>

                                <!-- Exam Type -->
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">Exam Type</label>
                                    <select name="exam_type" class="form-select" required>
                                        <option value="" disabled selected>Select Type</option>
                                        <option value="Ujian Bertulis 1">Ujian Bertulis 1</option>
                                        <option value="Ujian Bertulis 2">Ujian Bertulis 2</option>
                                        <option value="Ujian Bertulis 3">Ujian Bertulis 3</option>
                                        <option value="Peperiksaan Pertengahan Tahun">Peperiksaan Pertengahan Tahun</option>
                                        <option value="Peperiksaan Akhir Tahun">Peperiksaan Akhir Tahun</option>
                                        <option value="Peperiksaan Percubaan SPM">Peperiksaan Percubaan SPM</option>
                                    </select>
                                </div>

                                <!-- Paper -->
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small text-muted">Paper (Kertas)</label>
                                    <select name="exam_paper" class="form-select" required>
                                        <option value="" disabled selected>Select Paper</option>
                                        <option value="Kertas 1">Kertas 1</option>
                                        <option value="Kertas 2">Kertas 2</option>
                                        <option value="Kertas 3">Kertas 3</option>
                                        <option value="Kertas 4">Kertas 4</option>
                                    </select>
                                </div>

                                <!-- Form Level -->
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small text-muted">Form Level</label>
                                    <select name="exam_form" class="form-select" required>
                                        <option value="" disabled selected>Select Form</option>
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}">Form {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <!-- Exam Date -->
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small text-muted">Date</label>
                                    <input type="date" name="exam_date" class="form-control" required>
                                </div>

                                <!-- Timing Row -->
                                <div class="col-md-12">
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <h6 class="fw-bold text-muted mb-3 small text-uppercase">Timing Configuration</h6>
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <label class="form-label small">Start Time</label>
                                                    <input type="time" name="exam_start_time" id="startTime" class="form-control" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label small">End Time</label>
                                                    <input type="time" name="exam_end_time" id="endTime" class="form-control" required>
                                                    <div class="invalid-feedback" id="timeError">
                                                        End time must be after start time.
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label small">Duration (Minutes)</label>
                                                    <div class="input-group">
                                                        <input type="number" name="duration_minutes" id="durationCalc" class="form-control bg-white" readonly placeholder="Auto-calculated">
                                                        <span class="input-group-text">min</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small text-muted">Description & Instructions</label>
                                    <textarea name="exam_description" class="form-control" rows="3" placeholder="Enter specific instructions for students..."></textarea>
                                </div>

                                <div class="col-12 text-end mt-4">
                                    <button type="submit" class="btn btn-primary px-5 fw-bold" id="btnCreateExam">
                                        Next: Add Questions <i class="bi bi-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- =========================================================
                 STEP 2: ADD QUESTIONS FORM (Only show if $exam IS set) 
                 ========================================================= -->
            @if (isset($exam))
                <!-- Exam Summary Header -->
                <div class="card bg-primary text-white border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-white text-primary mb-2">{{ $exam->exam_subject }} - Form {{ $exam->exam_form }}</span>
                                <h3 class="fw-bold mb-1">{{ $exam->title }}</h3>
                                <p class="mb-2 opacity-75">{{ $exam->exam_type }} &bull; {{ $exam->exam_paper }}</p>
                                
                                <div class="d-flex gap-3 text-white small opacity-75">
                                    <span><i class="bi bi-calendar me-1"></i> {{ $exam->exam_date }}</span>
                                    <span><i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($exam->exam_start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($exam->exam_end_time)->format('H:i') }}</span>
                                    <span><i class="bi bi-hourglass-split me-1"></i> {{ $exam->duration_minutes }} Mins</span>
                                </div>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('teacher.exams.index') }}" class="btn btn-light text-primary fw-bold btn-sm">Done / Finish</a>
                            </div>
                        </div>
                        @if($exam->exam_description)
                            <hr class="border-white opacity-25">
                            <p class="mb-0 small opacity-75"><i class="bi bi-info-circle me-2"></i>{{ $exam->exam_description }}</p>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <!-- Left: Add New Question -->
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white py-3 border-0">
                                <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-plus-circle me-2"></i>Add New Question</h5>
                            </div>
                            <div class="card-body p-4">
                                <form action="{{ route('teacher.exams.questions.store', $exam->exam_id) }}" method="POST">
                                    @csrf
                                    
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Question Text</label>
                                        <textarea name="question_text" class="form-control" rows="3" placeholder="Type your question here..." required></textarea>
                                    </div>

                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-text bg-light fw-bold text-muted">A</span>
                                                <input type="text" name="option_a" class="form-control" placeholder="Option A" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-text bg-light fw-bold text-muted">B</span>
                                                <input type="text" name="option_b" class="form-control" placeholder="Option B" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-text bg-light fw-bold text-muted">C</span>
                                                <input type="text" name="option_c" class="form-control" placeholder="Option C" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-text bg-light fw-bold text-muted">D</span>
                                                <input type="text" name="option_d" class="form-control" placeholder="Option D" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-success">Select Correct Answer</label>
                                        <div class="d-flex gap-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="correct_answer" value="a" id="ansA" required>
                                                <label class="form-check-label fw-bold" for="ansA">Option A</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="correct_answer" value="b" id="ansB">
                                                <label class="form-check-label fw-bold" for="ansB">Option B</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="correct_answer" value="c" id="ansC">
                                                <label class="form-check-label fw-bold" for="ansC">Option C</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="correct_answer" value="d" id="ansD">
                                                <label class="form-check-label fw-bold" for="ansD">Option D</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary fw-bold py-2">
                                            <i class="bi bi-save me-2"></i> Save Question
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Existing Questions Preview -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white py-3 border-0">
                                <h6 class="fw-bold mb-0 text-muted text-uppercase small">Questions Added: {{ $exam->questions->count() }}</h6>
                            </div>
                            <div class="card-body p-0 overflow-auto" style="max-height: 500px;">
                                <ul class="list-group list-group-flush">
                                    @forelse($exam->questions as $index => $q)
                                        <li class="list-group-item px-4 py-3">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <span class="badge bg-light text-dark border mb-1">Q{{ $index + 1 }}</span>
                                                    <p class="mb-1 fw-bold small text-truncate" style="max-width: 200px;">{{ $q->question_text }}</p>
                                                    <small class="text-success"><i class="bi bi-check-circle-fill me-1"></i> Answer: {{ strtoupper($q->correct_answer) }}</small>
                                                </div>
                                                
                                                <form action="{{ route('teacher.questions.destroy', $q->question_id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm text-danger"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="list-group-item text-center py-5 text-muted">
                                            <i class="bi bi-clipboard-x display-6 mb-3 d-block"></i>
                                            No questions added yet.
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

<!-- Auto Calculation Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startTimeInput = document.getElementById('startTime');
        const endTimeInput = document.getElementById('endTime');
        const durationInput = document.getElementById('durationCalc');
        const submitBtn = document.getElementById('btnCreateExam');

        function calculateDuration() {
            const startVal = startTimeInput.value;
            const endVal = endTimeInput.value;

            if (startVal && endVal) {
                // Create dates for today with the time values to compare
                const startDate = new Date(`2000-01-01T${startVal}`);
                const endDate = new Date(`2000-01-01T${endVal}`);

                // Calculate difference in minutes
                let diffMs = endDate - startDate;
                let diffMins = Math.floor(diffMs / 60000);

                if (diffMins <= 0) {
                    // Invalid time range
                    endTimeInput.classList.add('is-invalid');
                    durationInput.value = '';
                    submitBtn.disabled = true;
                } else {
                    // Valid time range
                    endTimeInput.classList.remove('is-invalid');
                    durationInput.value = diffMins;
                    submitBtn.disabled = false;
                }
            }
        }

        if(startTimeInput && endTimeInput) {
            startTimeInput.addEventListener('change', calculateDuration);
            endTimeInput.addEventListener('change', calculateDuration);
        }
    });
</script>
@endsection