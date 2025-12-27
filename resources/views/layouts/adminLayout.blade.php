<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Portal') - ExSySP</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f1fa; /* Light purple tint */ }
        
        /* Sidebar Styling - Admin Purple Theme */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #6f42c1 0%, #4c2889 100%); /* Purple Gradient */
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s;
            box-shadow: 4px 0 10px rgba(111, 66, 193, 0.1);
        }
        
        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 12px 20px;
            margin: 5px 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateX(5px);
            font-weight: 600;
        }
        
        .nav-link i { margin-right: 12px; font-size: 1.2rem; }

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
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.03);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #f0f0f0;
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
            <!-- Using the school logo asset -->
            <img src="{{ asset('assets/SMKSP.png') }}" alt="SMKSP Logo" width="70" height="70" >
            <h4 class="fw-bold mb-0">ExSySP</h4>
            <span class="badge bg-white text-purple bg-opacity-75 text-dark rounded-pill px-3 py-1 mt-1" style="font-size: 0.75rem; color: #6f42c1 !important;">Admin Panel</span>
        </div>

        <ul class="nav flex-column mt-4">
            <li class="nav-item">
                <a href="{{ route('admin.adminDashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-fill"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.profile') }}" class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                    <i class="bi bi-person-gear"></i> My Profile
                </a>
            </li>
            
            <li class="nav-header text-uppercase small fw-bold text-white-50 px-4 mt-3 mb-1">User Management</li>

            <li class="nav-item">
                <a href="{{ route('admin.teachers.index') }}" class="nav-link {{ request()->routeIs('admin.teachers.index') ? 'active' : '' }}">
                    <i class="bi bi-person-video3"></i> Teachers
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.students.index') }}" class="nav-link {{ request()->routeIs('admin.students.index') ? 'active' : '' }}">
                    <i class="bi bi-backpack4-fill"></i> Students
                </a>
            </li>    
        </ul>

        <!-- Logout Button (Bottom) -->
        <div class="mt-auto p-3 mb-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-light w-100 fw-bold d-flex align-items-center justify-content-center shadow-sm">
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
                <button class="btn btn-light d-md-none me-3 text-purple" onclick="document.querySelector('.sidebar').classList.toggle('active')">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <h5 class="mb-0 fw-bold text-dark">@yield('page-title', 'Admin Dashboard')</h5>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-sm-block">
                    <p class="mb-0 fw-bold text-dark">{{ Auth::user()->name ?? 'Administrator' }}</p>
                    <small class="text-muted">{{ Auth::user()->admin->position ?? 'Admin' }}</small>
                </div>
                <div class="bg-white border border-2 border-purple text-purple rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                     style="width: 45px; height: 45px; color: #6f42c1;">
                    <i class="bi bi-person-fill-gear fs-5"></i>
                </div>
            </div>
        </div>

        <!-- Dynamic Content -->
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>