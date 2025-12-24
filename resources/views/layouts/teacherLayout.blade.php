<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Teacher Portal') - SchoolExams</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f6f9; }
        
        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s;
        }
        
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateX(5px);
        }
        
        .nav-link i { margin-right: 10px; font-size: 1.1rem; }

        /* Main Content Styling */
        .main-content {
            margin-left: 260px;
            padding: 20px;
            min-height: 100vh;
        }
        
        /* Top Navbar */
        .top-navbar {
            background: white;
            padding: 15px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        /* Responsive Mobile */
        @media (max-width: 768px) {
            .sidebar { margin-left: -260px; }
            .sidebar.active { margin-left: 0; }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <nav class="sidebar d-flex flex-column">
        <div class="sidebar-header">
            <h4 class="fw-bold mb-0"><i class="bi bi-mortarboard-fill me-2"></i>SchoolExams</h4>
            <small class="opacity-75">Teacher Panel</small>
        </div>

        <ul class="nav flex-column mt-4">
            <li class="nav-item">
                <a href="{{ route('teacher.teacherDashboard') }}" class="nav-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('teacher.profile') }}" class="nav-link {{ request()->routeIs('teacher.profile') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i> My Profile
                </a>
            </li>

            <li class="nav-header text-uppercase small fw-bold text-white-50 px-4 mt-3 mb-1">Exams</li>

            <!-- UPDATED LINKS START HERE -->
            
            <!-- 1. Create New Exam -->
            <li class="nav-item">
                <a href="{{ route('teacher.exams.create') }}" class="nav-link {{ request()->routeIs('teacher.exams.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-square"></i> Create New Exam
                </a>
            </li>

            <!-- 2. Manage Exams (List View) -->
            <!-- This replaces the old "Edit" and "View" links. You edit/view from the list. -->
            <li class="nav-item">
                <a href="{{ route('teacher.exams.index') }}" class="nav-link {{ request()->routeIs('teacher.exams.index') ? 'active' : '' }}">
                    <i class="bi bi-list-check"></i> Manage Exams
                </a>
            </li>
            
            <!-- UPDATED LINKS END HERE -->

            <li class="nav-header text-uppercase small fw-bold text-white-50 px-4 mt-3 mb-1">Students</li>

            <li class="nav-item">
                <a href="{{ route('teacher.students.list') }}" class="nav-link {{ request()->routeIs('teacher.students.list') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Student List
                </a>
            </li>
        </ul>

        <!-- Logout Button (Bottom) -->
        <div class="mt-auto p-3 mb-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger w-100 bg-opacity-25 border-0 text-white d-flex align-items-center justify-content-center">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content Wrapper -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="btn btn-light d-md-none me-3" onclick="document.querySelector('.sidebar').classList.toggle('active')">
                    <i class="bi bi-list"></i>
                </button>
                <h5 class="mb-0 fw-bold text-dark">@yield('page-title', 'Dashboard')</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-sm-block">
                    <p class="mb-0 fw-bold text-dark">{{ Auth::user()->name ?? 'Teacher' }}</p>
                    <small class="text-muted">ID: {{ Auth::user()->teacher->teacher_ic ?? 'N/A' }}</small>
                </div>
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-person-fill"></i>
                </div>
            </div>
        </div>

        <!-- Dynamic Content -->
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>