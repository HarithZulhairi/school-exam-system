@extends('layouts.teacherLayout')

@section('title', 'Edit Exam')
@section('page-title', 'Edit Exam Details')

@section('content')
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">Update Exam Details</h5>
                    <a href="{{ route('teacher.exams.index') }}" class="btn btn-sm btn-light border">Cancel</a>
                </div>
                <div class="card-body p-4">
                    
                    <!-- Update Form -->
                    <form action="{{ route('teacher.exams.update', $exam->getKey()) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Important for Updates -->

                        <div class="row g-3">
                            <!-- Title -->
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">Exam Title</label>
                                <input type="text" name="title" class="form-control form-control-lg" 
                                       value="{{ old('title', $exam->title) }}" required>
                            </div>

                            <!-- Date -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Date of Exam</label>
                                <input type="date" name="exam_date" class="form-control" 
                                       value="{{ old('exam_date', $exam->exam_date) }}" required>
                            </div>

                            <!-- Duration -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Duration (Minutes)</label>
                                <div class="input-group">
                                    <input type="number" name="duration_minutes" class="form-control" 
                                           value="{{ old('duration_minutes', $exam->duration_minutes) }}" required>
                                    <span class="input-group-text bg-light text-muted">min</span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-muted">Form for the Exam</label>
                                <select name="exam_form" class="form-control" required>
                                    <option value="{{ old('exam_form', $exam->exam_form) }}" disabled selected>Form {{ old('exam_form', $exam->exam_form) }}</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">Form {{ $i }}</option>
                                    @endfor
                                </select>   
                            </div>

                            <!-- Status Toggle -->
                            <div class="col-12 mt-3">
                                <label class="form-label fw-bold small text-muted">Exam Status</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check border rounded p-3 px-4 flex-fill">
                                        <input class="form-check-input" type="radio" name="is_active" value="1" id="statusActive" 
                                               {{ $exam->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label w-100" for="statusActive">
                                            <strong class="text-success">Active</strong> <br>
                                            <small class="text-muted">Students can see and take this exam.</small>
                                        </label>
                                    </div>
                                    <div class="form-check border rounded p-3 px-4 flex-fill">
                                        <input class="form-check-input" type="radio" name="is_active" value="0" id="statusDraft" 
                                               {{ !$exam->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label w-100" for="statusDraft">
                                            <strong class="text-secondary">Draft / Closed</strong> <br>
                                            <small class="text-muted">Hidden from students.</small>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 text-end mt-4">
                                <button type="submit" class="btn btn-primary px-4 fw-bold">
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
@endsection