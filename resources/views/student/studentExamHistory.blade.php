@extends('layouts.studentLayout')

@section('title', 'Exam History')
@section('page-title', 'My Exam History')

@section('content')
<div class="container-fluid">

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-0">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <h5 class="fw-bold mb-0 text-dark">Completed Exams</h5>
                </div>
                
                <!-- Search & Filter Form -->
                <div class="col-md-8">
                    <form action="{{ route('student.exams.history') }}" method="GET" class="row g-2 justify-content-md-end">
                        
                        <!-- Filter Dropdown -->
                        <div class="col-auto">
                            <select name="subject" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">All Subjects</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject }}" {{ request('subject') == $subject ? 'selected' : '' }}>
                                        {{ $subject }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Search Input -->
                        <div class="col-auto">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control" placeholder="Search title..." value="{{ request('search') }}">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4">Date Taken</th>
                            <th>Exam Title</th>
                            <th>Subject</th>
                            <th class="text-center">Score</th>
                            <th class="text-center">Status</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($results as $result)
                            @php
                                $percentage = ($result->score / $result->total_questions) * 100;
                                $badgeClass = $percentage >= 80 ? 'bg-success' : ($percentage >= 50 ? 'bg-primary' : 'bg-danger');
                            @endphp
                            <tr>
                                <td class="ps-4 text-muted small">
                                    {{ $result->created_at->format('d M Y, h:i A') }}
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $result->exam->title }}</div>
                                    <small class="text-muted">{{ $result->exam->exam_paper }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $result->exam->exam_subject }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold {{ $percentage >= 50 ? 'text-dark' : 'text-danger' }}">
                                        {{ $result->score }} / {{ $result->total_questions }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $badgeClass }} rounded-pill">
                                        {{ number_format($percentage, 0) }}%
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('student.exams.history.details', $result->result_id) }}" class="btn btn-sm btn-outline-primary fw-bold">
                                        <i class="bi bi-eye-fill me-1"></i> View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-clipboard-data display-6 mb-3 d-block opacity-50"></i>
                                    No exam history found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($results->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                <div class="d-flex justify-content-end">
                    {{ $results->links() }}
                </div>
            </div>
        @endif
    </div>

</div>
@endsection