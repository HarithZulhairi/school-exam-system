@extends('layouts.teacherLayout')

@section('title', 'Student List')
@section('page-title', 'Manage Students')

@section('content')
<div class="container-fluid">

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Error Message -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $errors->first() }}
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

    <!-- TABS NAVIGATION -->
    <ul class="nav nav-tabs mb-4 border-bottom-0">
        <li class="nav-item">
            <a class="nav-link {{ (request('view_type') == 'all' || !request()->has('view_type')) ? 'active fw-bold' : 'text-muted' }}" 
               href="{{ route('teacher.students.list', ['view_type' => 'all']) }}">
                <i class="bi bi-people me-2"></i>View All Students
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('view_type') == 'my_class' ? 'active fw-bold text-primary' : 'text-muted' }}" 
               href="{{ route('teacher.students.list', ['view_type' => 'my_class']) }}">
                <i class="bi bi-person-badge me-2"></i>My Class Students 
                <span class="badge bg-primary bg-opacity-10 text-primary ms-1 small">
                    {{ Auth::user()->teacher->teacher_form_class ?? 'No Class Assigned' }}
                </span>
            </a>
        </li>
    </ul>

    <!-- Search & Filter Card -->
    <div class="card border-0 shadow-sm mb-4 bg-white">
        <div class="card-body p-3">
            <!-- Ensure the form keeps the current view_type when submitting -->
            <form action="{{ route('teacher.students.list') }}" method="GET" class="row g-2 align-items-center">
                
                <!-- Hidden Input to Maintain Tab State -->
                <input type="hidden" name="view_type" value="{{ request('view_type', 'all') }}">

                <!-- Search Input (Name) -->
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 bg-light ps-0" 
                               placeholder="Search student name..." value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Filters (Disabled on 'My Class' tab to prevent confusion) -->
                <div class="col-md-3">
                    <select name="form" class="form-select bg-light text-muted" onchange="this.form.submit()" 
                            {{ request('view_type') == 'my_class' ? 'disabled' : '' }}>
                        <option value="all">All Forms</option>
                        @for($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}" {{ request('form') == $i ? 'selected' : '' }}>Form {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="class_name" class="form-select bg-light text-muted" onchange="this.form.submit()" 
                            {{ request('view_type') == 'my_class' ? 'disabled' : '' }}>
                        <option value="all">All Classes</option>
                        @foreach($availableClasses as $cls)
                            <option value="{{ $cls }}" {{ request('class_name') == $cls ? 'selected' : '' }}>{{ $cls }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100">Search</button>
                </div>
                
                @if(request()->anyFilled(['search', 'form', 'class_name']))
                    <div class="col-md-auto">
                        <a href="{{ route('teacher.students.list', ['view_type' => request('view_type', 'all')]) }}" class="text-decoration-none text-muted small fw-bold">
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
                                <!-- LOGIC: Check if this student belongs to the teacher -->
                                @php
                                    $teacherClass = Auth::user()->teacher->teacher_form_class;
                                    
                                    $teacherClassNormalized = trim(str_ireplace('Form ', '', $teacherClass));

                                    $studentClassNormalized = trim($student->student_class);

                                    $canDelete = ($teacherClassNormalized === $studentClassNormalized);
                                @endphp

                                <tr class="{{ $canDelete ? 'bg-white' : 'bg-light bg-opacity-50' }}">
                                    <td class="ps-4 fw-bold text-muted">{{ $students->firstItem() + $index }}</td>
                                    
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <span class="fw-bold">{{ strtoupper(substr($student->user->name, 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold text-dark">
                                                    {{ $student->user->name }}
                                                    @if($canDelete) 
                                                        <i class="bi bi-star-fill text-warning small ms-1" title="My Student"></i> 
                                                    @endif
                                                </h6>
                                                <small class="text-muted">Born {{ \Carbon\Carbon::parse($student->student_DOB)->format('d M Y') }} ({{ $student->student_age }} yrs)</small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="font-monospace text-dark">{{ $student->student_ic ?? 'N/A' }}</span>
                                        <div class="small text-muted">{{ $student->student_gender }}</div>
                                    </td>

                                    <td>
                                        <!-- Display Class Name directly since it contains "5 Bestari" -->
                                        <span class="badge {{ $canDelete ? 'bg-primary' : 'bg-secondary bg-opacity-25 text-dark' }}">
                                            {{ $student->student_class ?? 'No Class' }}
                                        </span>
                                    </td>

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

                                    <td class="pe-4 text-end">
                                        
                                        <!-- NEW: View Details Button -->
                                        <a href="{{ route('teacher.students.show', $student->student_id) }}" 
                                           class="btn btn-sm btn-outline-primary shadow-sm me-1"
                                           data-bs-toggle="tooltip" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        @if($canDelete)
                                            <!-- Enabled Delete Button -->
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger shadow-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteStudentModal{{ $student->student_id }}"
                                                    title="Delete Student">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            
                                            <!-- ... (Keep your existing Delete Modal code here) ... -->
                                        @else
                                            <!-- Disabled Delete Button -->
                                            <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="You can only delete students from your own class">
                                                <button type="button" class="btn btn-sm btn-light text-muted border" style="cursor: not-allowed;" disabled>
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center p-3 bg-light border-top">
                    <span class="small text-muted">Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} students</span>
                    <div>
                        <!-- Use appends() to keep filters (including view_type) during pagination -->
                        {{ $students->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="bi bi-person-x text-muted display-6"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold text-dark">No Students Found</h5>
                    <p class="text-muted">No students found in this category.</p>
                    <a href="{{ route('teacher.students.list', ['view_type' => 'all']) }}" class="btn btn-outline-secondary px-4 fw-bold">
                        View All Students
                    </a>
                </div>
            @endif

        </div>
    </div>
</div>

<style>
    .nav-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        padding-bottom: 12px;
        color: #6c757d;
    }
    .nav-tabs .nav-link:hover {
        border-color: transparent;
        color: #0d6efd;
    }
    .nav-tabs .nav-link.active {
        border-color: #0d6efd;
        color: #0d6efd;
        background: transparent;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s ease-in-out;
    }
</style>
@endsection