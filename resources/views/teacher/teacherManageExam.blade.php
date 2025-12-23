@extends('layouts.teacherLayout')

@section('title', 'Manage Exams')
@section('page-title', 'Exam Management')

@section('content')
<div class="container-fluid">

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Header Actions -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold text-dark mb-1">My Examinations</h4>
            <p class="text-muted small mb-0">Manage, edit, and track your created assessments.</p>
        </div>
        <a href="{{ route('teacher.exams.create') }}" class="btn btn-primary px-4 fw-bold shadow-sm">
            <i class="bi bi-plus-lg me-2"></i> Create New Exam
        </a>
    </div>

    <!-- Search & Filter Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form action="{{ route('teacher.exams.index') }}" method="GET" class="row g-2 align-items-center">
                
                <!-- Search Input -->
                <div class="col-md-6 col-lg-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 bg-light ps-0" 
                               placeholder="Search exam title..." value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="col-md-4 col-lg-3">
                    <select name="status" class="form-select bg-light text-muted" onchange="this.form.submit()">
                        <option value="all">Filter by Status: All</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active (Published)</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Draft (Hidden)</option>
                    </select>
                </div>

                <!-- Filter Buttons -->
                <div class="col-md-2 col-lg-2">
                    <button type="submit" class="btn btn-dark w-100">Search</button>
                </div>
                
                <!-- Reset Link -->
                @if(request()->anyFilled(['search', 'status']))
                    <div class="col-md-auto">
                        <a href="{{ route('teacher.exams.index') }}" class="text-decoration-none text-muted small fw-bold">
                            <i class="bi bi-x-circle"></i> Clear
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Exam List Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            
            @if($exams->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-uppercase small text-muted">
                            <tr>
                                <th scope="col" class="ps-4 py-3" style="width: 5%;">#</th>
                                <th scope="col" class="py-3" style="width: 35%;">Exam Details</th>
                                <th scope="col" class="py-3" style="width: 15%;">Date & Duration</th>
                                <th scope="col" class="py-3 text-center" style="width: 15%;">Questions</th>
                                <th scope="col" class="py-3 text-center" style="width: 10%;">Status</th>
                                <th scope="col" class="pe-4 py-3 text-center" style="width: 20%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($exams as $index => $exam)
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">{{ $exams->firstItem() + $index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-3 d-none d-md-block">
                                                <i class="bi bi-file-earmark-text fs-5"></i>
                                            </div>
                                            <div>
                                                <!-- Highlight search term logic could go here, keeping simple for now -->
                                                <h6 class="mb-0 fw-bold text-dark">{{ Str::limit($exam->title, 50) }}</h6>
                                                <small class="text-muted">Created {{ $exam->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small text-muted">
                                            <div class="mb-1"><i class="bi bi-calendar-event me-2"></i> {{ \Carbon\Carbon::parse($exam->exam_date)->format('d M, Y') }}</div>
                                            <div><i class="bi bi-clock me-2"></i> {{ $exam->duration_minutes }} Mins</div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                            {{ $exam->questions->count() }} Qs
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($exam->is_active)
                                            <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill small">Active</span>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-1 rounded-pill small">Draft</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-center">
                                        <div class="btn-group">
                                            <!-- Add/Edit Questions Button -->
                                            <a href="{{ route('teacher.exams.questions.create', $exam->exam_id) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               data-bs-toggle="tooltip" title="Manage Questions">
                                                <i class="bi bi-list-check"></i>
                                            </a>
                                            
                                            <!-- Edit Exam Details Button -->
                                            <a href="{{ route('teacher.exams.edit', $exam->exam_id) }}" 
                                               class="btn btn-sm btn-outline-secondary"
                                               data-bs-toggle="tooltip" title="Edit Details">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <!-- Delete Exam Button -->
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal{{ $exam->exam_id }}"
                                                    title="Delete Exam">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Delete Confirmation Modal -->
                                        <div class="modal fade" id="deleteModal{{ $exam->exam_id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content text-start">
                                                    <div class="modal-header border-0 pb-0">
                                                        <h5 class="modal-title fw-bold text-danger">Delete Exam?</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-muted">
                                                        Are you sure you want to delete <strong>"{{ $exam->title }}"</strong>? 
                                                        <br><br>
                                                        <span class="text-danger small"><i class="bi bi-exclamation-triangle-fill me-1"></i> This creates an irreversible action. All {{ $exam->questions->count() }} questions attached will also be deleted.</span>
                                                    </div>
                                                    <div class="modal-footer border-0 pt-0">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('teacher.exams.destroy', $exam->exam_id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger fw-bold">Yes, Delete Exam</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Footer -->
                <div class="d-flex justify-content-between align-items-center p-3 bg-light border-top">
                    <span class="small text-muted">Showing {{ $exams->firstItem() }} to {{ $exams->lastItem() }} of {{ $exams->total() }} results</span>
                    <div>
                        <!-- IMPORTANT: appends(request()->query()) keeps search params when switching pages -->
                        {{ $exams->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="mb-3">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="bi bi-search text-muted display-6"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold text-dark">No Exams Found</h5>
                    <p class="text-muted mb-4">We couldn't find any exams matching your search criteria.</p>
                    <a href="{{ route('teacher.exams.index') }}" class="btn btn-outline-secondary px-4 fw-bold">
                        Clear Filters
                    </a>
                </div>
            @endif

        </div>
    </div>
</div>

<style>
    /* Custom hover effect for rows */
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }
    .badge {
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
</style>
@endsection