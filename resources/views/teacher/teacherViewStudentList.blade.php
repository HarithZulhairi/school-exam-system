@extends('layouts.teacherLayout')

@section('title', 'View Student List')
@section('page-title', 'View Student List')

@section('content')
<div class="container-fluid">

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Header & Stats -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold text-dark mb-1">Enrolled Students</h4>
            <p class="text-muted small mb-0">View and manage all registered student accounts.</p>
        </div>
        <div>
            <span class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-sm">
                Total Students: <span class="fw-bold text-primary">{{ $students->total() }}</span>
            </span>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form action="{{ route('teacher.students.list') }}" method="GET" class="row g-2 align-items-center">
                
                <!-- Search Input (Name) -->
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 bg-light ps-0" 
                               placeholder="Search student name..." value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Filter: Form (Tingkatan) -->
                <div class="col-md-3">
                    <select name="form" class="form-select bg-light text-muted" onchange="this.form.submit()">
                        <option value="all">All Forms</option>
                        @for($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}" {{ request('form') == $i ? 'selected' : '' }}>Form {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Filter: Class Name -->
                <div class="col-md-3">
                    <select name="class_name" class="form-select bg-light text-muted" onchange="this.form.submit()">
                        <option value="all">All Classes</option>
                        {{-- Use the variable passed from controller, or hardcode if preferred --}}
                        @foreach($availableClasses as $cls)
                            <option value="{{ $cls }}" {{ request('class_name') == $cls ? 'selected' : '' }}>{{ $cls }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Button -->
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100">Search</button>
                </div>
                
                <!-- Reset Link -->
                @if(request()->anyFilled(['search', 'form', 'class_name']))
                    <div class="col-md-auto">
                        <a href="{{ route('teacher.students.list') }}" class="text-decoration-none text-muted small fw-bold">
                            <i class="bi bi-x-circle"></i> Clear Filters
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Students Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            
            @if($students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-uppercase small text-muted">
                            <tr>
                                <th scope="col" class="ps-4 py-3" style="width: 5%;">#</th>
                                <th scope="col" class="py-3" style="width: 30%;">Student Name</th>
                                <th scope="col" class="py-3" style="width: 20%;">Identity (NRIC)</th>
                                <th scope="col" class="py-3" style="width: 15%;">Class Info</th>
                                <th scope="col" class="py-3" style="width: 20%;">Contact Info</th>
                                <th scope="col" class="pe-4 py-3 text-end" style="width: 10%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $index => $student)
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">{{ $students->firstItem() + $index }}</td>
                                    
                                    <!-- Name Column -->
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <span class="fw-bold">{{ strtoupper(substr($student->user->name, 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold text-dark">{{ $student->user->name }}</h6>
                                                <small class="text-muted">Born {{ \Carbon\Carbon::parse($student->student_DOB)->format('d M Y') }} ({{ $student->student_age }} yrs)</small>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- NRIC Column -->
                                    <td>
                                        <span class="font-monospace text-dark">{{ $student->student_ic ?? 'N/A' }}</span>
                                        <div class="small text-muted">{{ $student->student_gender }}</div>
                                    </td>

                                    <!-- Class Info Column -->
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            Form {{ $student->student_form ?? '-' }}
                                        </span>
                                        <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-10 ms-1">
                                            {{ $student->student_class ?? 'No Class' }}
                                        </span>
                                    </td>

                                    <!-- Contact Column -->
                                    <td>
                                        <div class="small text-muted">
                                            <div class="mb-1"><i class="bi bi-envelope me-1"></i> {{ $student->user->email }}</div>
                                            @if($student->student_phone_number)
                                                <div class="text-truncate" style="max-width: 150px;" title="{{ $student->student_phone_number }}">
                                                    <i class="bi bi-telephone me-1"></i> {{ $student->student_phone_number }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Actions Column -->
                                    <td class="pe-4 text-end">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteStudentModal{{ $student->student_id }}"
                                                title="Delete Student">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                        <!-- Delete Confirmation Modal -->
                                        <div class="modal fade" id="deleteStudentModal{{ $student->student_id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content text-start">
                                                    <div class="modal-header border-0 pb-0">
                                                        <h5 class="modal-title fw-bold text-danger">Remove Student?</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-muted">
                                                        Are you sure you want to remove <strong>"{{ $student->user->name }}"</strong>?
                                                        <br><br>
                                                        <span class="text-danger small bg-danger bg-opacity-10 p-2 rounded d-block">
                                                            <i class="bi bi-exclamation-triangle-fill me-1"></i> 
                                                            Warning: This will delete the user account and all exam results associated with this student.
                                                        </span>
                                                    </div>
                                                    <div class="modal-footer border-0 pt-0">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('teacher.students.destroy', $student->student_id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger fw-bold">Confirm Delete</button>
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
                    <span class="small text-muted">Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} students</span>
                    <div>
                        <!-- Use appends() to keep filters during pagination -->
                        {{ $students->appends(request()->query())->links('pagination::bootstrap-5') }}
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
                    <h5 class="fw-bold text-dark">No Students Found</h5>
                    <p class="text-muted">We couldn't find any students matching your criteria.</p>
                    <a href="{{ route('teacher.students.list') }}" class="btn btn-outline-secondary px-4 fw-bold">
                        Clear Filters
                    </a>
                </div>
            @endif

        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s ease-in-out;
    }
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
</style>
@endsection