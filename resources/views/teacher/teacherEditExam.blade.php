@extends('layouts.teacherLayout')

@section('title', 'Edit Exam')
@section('page-title', 'Edit Exam Details')

@section('content')
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-lg-10"> <!-- Increased width to match Create form -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">Update Exam Configuration</h5>
                    <a href="{{ route('teacher.exams.index') }}" class="btn btn-sm btn-light border">Cancel</a>
                </div>
                <div class="card-body p-4">
                    
                    <!-- Update Form -->
                    <form action="{{ route('teacher.exams.update', $exam->getKey()) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            
                            <!-- Title -->
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">Exam Title</label>
                                <input type="text" name="title" class="form-control form-control-lg" 
                                       value="{{ old('title', $exam->title) }}" placeholder="e.g. Peperiksaan Akhir Tahun Matematik 2025" required>
                            </div>

                            <!-- Subject -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Subject</label>
                                <select name="exam_subject" class="form-select" required>
                                    <option value="" disabled>Select Subject</option>
                                    @php
                                        $subjects = [
                                            'Bahasa Melayu', 'Bahasa Inggeris', 'Matematik', 'Pendidikan Islam', 
                                            'Pendidikan Moral', 'Sejarah', 'Pendidikan Jasmani dan Kesihatan', 
                                            'Biologi', 'Fizik', 'Kimia', 'Matematik Tambahan'
                                        ];
                                    @endphp
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject }}" {{ old('exam_subject', $exam->exam_subject) == $subject ? 'selected' : '' }}>
                                            {{ $subject }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Exam Type -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Exam Type</label>
                                <select name="exam_type" class="form-select" required>
                                    <option value="" disabled>Select Type</option>
                                    @php
                                        $types = [
                                            'Ujian Bertulis 1', 'Ujian Bertulis 2', 'Ujian Bertulis 3',
                                            'Peperiksaan Pertengahan Tahun', 'Peperiksaan Akhir Tahun', 'Peperiksaan Percubaan SPM'
                                        ];
                                    @endphp
                                    @foreach($types as $type)
                                        <option value="{{ $type }}" {{ old('exam_type', $exam->exam_type) == $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Paper -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-muted">Paper (Kertas)</label>
                                <select name="exam_paper" class="form-select" required>
                                    <option value="" disabled>Select Paper</option>
                                    @php $papers = ['Kertas 1', 'Kertas 2', 'Kertas 3', 'Kertas 4']; @endphp
                                    @foreach($papers as $paper)
                                        <option value="{{ $paper }}" {{ old('exam_paper', $exam->exam_paper) == $paper ? 'selected' : '' }}>
                                            {{ $paper }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Form Level -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-muted">Form Level</label>
                                <select name="exam_form" class="form-select" required>
                                    <option value="" disabled>Select Form</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('exam_form', $exam->exam_form) == $i ? 'selected' : '' }}>
                                            Form {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Exam Date -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-muted">Date</label>
                                <input type="date" name="exam_date" class="form-control" 
                                       value="{{ old('exam_date', $exam->exam_date) }}" required>
                            </div>

                            <!-- Timing Configuration -->
                            <div class="col-md-12">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="fw-bold text-muted mb-3 small text-uppercase">Timing Configuration</h6>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label small">Start Time</label>
                                                <!-- Format time to H:i for HTML5 time input -->
                                                <input type="time" name="exam_start_time" id="startTime" class="form-control" 
                                                       value="{{ old('exam_start_time', \Carbon\Carbon::parse($exam->exam_start_time)->format('H:i')) }}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label small">End Time</label>
                                                <input type="time" name="exam_end_time" id="endTime" class="form-control" 
                                                       value="{{ old('exam_end_time', \Carbon\Carbon::parse($exam->exam_end_time)->format('H:i')) }}" required>
                                                <div class="invalid-feedback" id="timeError">
                                                    End time must be after start time.
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label small">Duration (Minutes)</label>
                                                <div class="input-group">
                                                    <input type="number" name="duration_minutes" id="durationCalc" class="form-control bg-white" 
                                                           value="{{ old('duration_minutes', $exam->duration_minutes) }}" readonly>
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
                                <textarea name="exam_description" class="form-control" rows="3" placeholder="Enter specific instructions for students...">{{ old('exam_description', $exam->exam_description) }}</textarea>
                            </div>

                            <!-- Status Toggle -->
                            <div class="col-12 mt-3">
                                <label class="form-label fw-bold small text-muted">Exam Status</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check border rounded p-3 px-4 flex-fill bg-white">
                                        <input class="form-check-input" type="radio" name="is_active" value="1" id="statusActive" 
                                               {{ $exam->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label w-100 cursor-pointer" for="statusActive">
                                            <strong class="text-success">Active</strong> <br>
                                            <small class="text-muted">Students can see and take this exam.</small>
                                        </label>
                                    </div>
                                    <div class="form-check border rounded p-3 px-4 flex-fill bg-white">
                                        <input class="form-check-input" type="radio" name="is_active" value="0" id="statusDraft" 
                                               {{ !$exam->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label w-100 cursor-pointer" for="statusDraft">
                                            <strong class="text-secondary">Draft / Closed</strong> <br>
                                            <small class="text-muted">Hidden from students.</small>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 text-end mt-4">
                                <button type="submit" class="btn btn-primary px-5 fw-bold" id="btnUpdateExam">
                                    <i class="bi bi-save me-2"></i> Update Changes
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Auto Calculation Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startTimeInput = document.getElementById('startTime');
        const endTimeInput = document.getElementById('endTime');
        const durationInput = document.getElementById('durationCalc');
        const submitBtn = document.getElementById('btnUpdateExam');

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