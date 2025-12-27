@extends('layouts.adminLayout')

@section('title', 'Teacher Management')
@section('page-title', 'Manage Teachers')

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
            <h4 class="fw-bold text-dark mb-1">Teacher Registry</h4>
            <p class="text-muted small mb-0">View and manage all registered teacher accounts.</p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-sm">
                Total Teachers: <span class="fw-bold text-primary">{{ $teachers->total() }}</span>
            </span>
            <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary fw-bold shadow-sm" style="background-color: #6f42c1; border-color: #6f42c1;">
                <i class="bi bi-person-plus-fill me-2"></i> Add Teacher
            </a>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="card border-0 shadow-sm mb-4 bg-white">
        <div class="card-body p-3">
            <form action="{{ route('admin.teachers.index') }}" method="GET" class="row g-2 align-items-center">
                
                <!-- Search Input -->
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 bg-light ps-0" 
                               placeholder="Search name or IC..." value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Class Assigned Filter -->
                <div class="col-md-4">
                    <select name="class_assigned" class="form-select bg-light text-muted" onchange="this.form.submit()">
                        <option value="all">All Class Teachers</option>
                        @foreach($availableClasses as $cls)
                            <option value="{{ $cls }}" {{ request('class_assigned') == $cls ? 'selected' : '' }}>{{ $cls }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Search Button -->
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100 fw-bold" style="background-color: #6f42c1; border-color: #6f42c1;">Filter</button>
                </div>
                
                @if(request()->anyFilled(['search', 'class_assigned']))
                    <div class="col-md-auto ms-auto">
                        <a href="{{ route('admin.teachers.index') }}" class="text-decoration-none text-danger small fw-bold">
                            <i class="bi bi-x-circle"></i> Clear Filters
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Teachers Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            
            @if($teachers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-uppercase small text-muted">
                            <tr>
                                <th scope="col" class="ps-4 py-3" style="width: 5%;">#</th>
                                <th scope="col" class="py-3" style="width: 30%;">Teacher Name</th>
                                <th scope="col" class="py-3" style="width: 20%;">Identity (NRIC)</th>
                                <th scope="col" class="py-3" style="width: 15%;">Class Teacher</th>
                                <th scope="col" class="py-3" style="width: 20%;">Contact Info</th>
                                <th scope="col" class="pe-4 py-3 text-end" style="width: 10%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $index => $teacher)
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">{{ $teachers->firstItem() + $index }}</td>
                                    
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <span class="fw-bold">{{ strtoupper(substr($teacher->user->name, 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold text-dark">{{ $teacher->user->name }}</h6>
                                                <small class="text-muted">{{ Str::limit($teacher->teacher_subjects, 30) }}</small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="font-monospace text-dark fw-bold">{{ $teacher->teacher_ic ?? 'N/A' }}</span>
                                        <div class="small text-muted">{{ $teacher->teacher_gender }}</div>
                                    </td>

                                    <td>
                                        @if($teacher->teacher_form_class)
                                            <span class="badge bg-light text-dark border">
                                                {{ $teacher->teacher_form_class }}
                                            </span>
                                        @else
                                            <span class="text-muted small fst-italic">Not Assigned</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="small text-muted">
                                            <div class="mb-1 text-truncate" style="max-width: 180px;">
                                                <i class="bi bi-envelope me-1"></i> {{ $teacher->user->email }}
                                            </div>
                                            @if($teacher->teacher_phone_number)
                                                <div><i class="bi bi-telephone me-1"></i> {{ $teacher->teacher_phone_number }}</div>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="pe-4 text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                                <!--
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="bi bi-eye me-2 text-primary"></i> View Details
                                                    </a>
                                                </li>
                                                -->
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.teachers.edit', $teacher->teacher_id) }}">
                                                        <i class="bi bi-pencil me-2 text-warning"></i> Edit Details
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('admin.teachers.destroy', $teacher->teacher_id) }}" method="POST" onsubmit="return confirm('Are you sure? This will remove the teacher account.');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="bi bi-trash me-2"></i> Delete Teacher
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center p-3 bg-light border-top">
                    <span class="small text-muted">Showing {{ $teachers->firstItem() }} to {{ $teachers->lastItem() }} of {{ $teachers->total() }} teachers</span>
                    <div>
                        {{ $teachers->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="bi bi-person-x text-muted display-6"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold text-dark">No Teachers Found</h5>
                    <p class="text-muted">Try adjusting your search or filters.</p>
                    <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-secondary px-4 fw-bold">Clear Filters</a>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection