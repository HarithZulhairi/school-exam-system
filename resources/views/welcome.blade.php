<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ExSySP - SMK Seri Pekan</title>

    <!-- 1. Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- 2. Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- 3. Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        
        /* Navbar Styling */
        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }
        .nav-link {
            font-weight: 500;
            color: #555;
            transition: color 0.3s;
        }
        .nav-link:hover, .nav-link.active {
            color: #0d6efd;
        }

        /* Hero Section Styling */
        .hero-section {
            padding: 120px 0 100px;
            background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%);
            position: relative;
            overflow: hidden;
        }
        
        /* Abstract Shapes */
        .shape-blob {
            position: absolute;
            opacity: 0.1;
            z-index: 0;
        }
        .shape-1 { top: -50px; right: -50px; width: 300px; height: 300px; background: #0d6efd; border-radius: 50%; filter: blur(50px); }
        .shape-2 { bottom: -50px; left: -50px; width: 400px; height: 400px; background: #6f42c1; border-radius: 50%; filter: blur(60px); }

        /* Custom Purple Theme for Admin */
        .text-purple { color: #6f42c1 !important; }
        .bg-purple { background-color: #6f42c1 !important; }
        .border-purple { border-color: #6f42c1 !important; }
        .btn-outline-purple {
            color: #6f42c1;
            border-color: #6f42c1;
        }
        .btn-outline-purple:hover {
            background-color: #6f42c1;
            color: white;
        }
        .icon-box-purple {
            background-color: rgba(111, 66, 193, 0.1);
            color: #6f42c1;
        }

        /* Role Selection Cards */
        .role-card {
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s;
            background: white;
        }
        .role-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }
        .role-card.admin-card:hover { border-color: #6f42c1; }
        .role-card.teacher-card:hover { border-color: #0d6efd; }
        .role-card.student-card:hover { border-color: #198754; }

        .icon-box {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin: 0 auto 20px;
        }

        /* Feature Cards */
        .feature-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease;
            height: 100%;
            background: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
                <!-- School Logo -->
                <img src="{{ asset('assets/SMKSP.png') }}" alt="SMKSP Logo" class="me-2">
                <div class="d-flex flex-column lh-1">
                    <span class="fs-5 text-primary fw-bold">ExSySP</span>
                    <span class="small text-muted" style="font-size: 0.7rem;">SMK Seri Pekan</span>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#roles">Portal Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-center">
        <!-- Background Shapes -->
        <div class="shape-blob shape-1"></div>
        <div class="shape-blob shape-2"></div>

        <div class="container position-relative z-1">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="d-inline-flex align-items-center bg-white rounded-pill px-3 py-2 shadow-sm mb-4 border">
                        <img src="{{ asset('assets/SMKSP.png') }}" alt="Logo" width="24" height="24" class=" me-2">
                        <small class="fw-bold text-secondary">SMK Seri Pekan, Pahang</small>
                    </div>
                    
                    <h1 class="display-4 fw-bold mb-3 lh-sm text-dark">
                        Examination System <br> <span class="text-primary">Seri Pekan (ExSySP)</span>
                    </h1>
                    <p class="lead text-secondary mb-4">
                        The official digital assessment platform for SMK Seri Pekan. 
                        Streamlining exams for administrators, teachers, and students.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#roles" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm fw-bold">
                            Login to Portal <i class="bi bi-box-arrow-in-right ms-2"></i>
                        </a>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="row mt-5 pt-4 border-top">
                        <div class="col-4">
                            <h4 class="fw-bold mb-0 text-dark">ExSySP</h4>
                            <small class="text-muted">Official System</small>
                        </div>
                        <div class="col-4">
                            <h4 class="fw-bold mb-0 text-dark">Secure</h4>
                            <small class="text-muted">School Database</small>
                        </div>
                        <div class="col-4">
                            <h4 class="fw-bold mb-0 text-dark">Paperless</h4>
                            <small class="text-muted">Eco-Friendly</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 text-center">
                    <!-- Hero Image / Graphic -->
                    <div class="position-relative d-inline-block">
                        <div class="bg-white p-3 rounded-4 shadow-lg" style="transform: rotate(2deg);">
                            <img src="{{ asset('assets/GF1.jpg') }}" 
                                 alt="SMK Seri Pekan School" 
                                 class="img-fluid rounded-3"
                                 style="max-height: 400px; width: auto;">
                        </div>
                        
                        <!-- Floating Badge -->
                        <div class="card position-absolute border-0 shadow bg-primary text-white p-3 rounded-4" 
                             style="bottom: -20px; right: -20px; animation: float 3s ease-in-out infinite;">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-mortarboard-fill fs-3 me-3"></i>
                                <div class="text-start lh-1">
                                    <span class="fw-bold d-block">Excellence</span>
                                    <small style="font-size: 0.7rem;">in Education</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Role Selection Section -->
    <section id="roles" class="py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5">
                <small class="text-primary fw-bold text-uppercase ls-md">Access Portal</small>
                <h2 class="fw-bold mt-2">Select Your Role</h2>
                <p class="text-muted">Please log in to the specific dashboard assigned to you.</p>
            </div>

            <div class="row justify-content-center g-4">
                
                <!-- 1. Admin Card (Purple) -->
                <div class="col-md-4">
                    <a href="{{ route('admin.login') }}" class="text-decoration-none text-dark">
                        <div class="card role-card admin-card h-100 p-4 shadow-sm text-center">
                            <div class="card-body">
                                <div class="icon-box icon-box-purple mx-auto">
                                    <i class="bi bi-shield-lock-fill"></i>
                                </div>
                                <h4 class="fw-bold mt-3">Administrator</h4>
                                <p class="text-muted small mb-4">Manage school data, teachers, students, and system settings.</p>
                                <button class="btn btn-outline-purple w-100 rounded-pill fw-bold">
                                    Admin Login <i class="bi bi-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- 2. Teacher Card (Blue) -->
                <div class="col-md-4">
                    <a href="{{ route('teacher.login') }}" class="text-decoration-none text-dark">
                        <div class="card role-card teacher-card h-100 p-4 shadow-sm text-center">
                            <div class="card-body">
                                <div class="icon-box bg-primary bg-opacity-10 text-primary mx-auto">
                                    <i class="bi bi-person-video3"></i>
                                </div>
                                <h4 class="fw-bold mt-3">Teacher</h4>
                                <p class="text-muted small mb-4">Create exams, grade assessments, and view student reports.</p>
                                <button class="btn btn-outline-primary w-100 rounded-pill fw-bold">
                                    Teacher Login <i class="bi bi-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- 3. Student Card (Green) -->
                <div class="col-md-4">
                    <a href="{{ route('student.login') }}" class="text-decoration-none text-dark">
                        <div class="card role-card student-card h-100 p-4 shadow-sm text-center">
                            <div class="card-body">
                                <div class="icon-box bg-success bg-opacity-10 text-success mx-auto">
                                    <i class="bi bi-backpack4-fill"></i>
                                </div>
                                <h4 class="fw-bold mt-3">Student</h4>
                                <p class="text-muted small mb-4">Attempt assigned exams and view your performance history.</p>
                                <button class="btn btn-outline-success w-100 rounded-pill fw-bold">
                                    Student Login <i class="bi bi-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-top py-4">
        <div class="container text-center">
            <div class="mb-2">
                <img src="{{ asset('assets/SMKSP.png') }}" alt="Logo" width="30" height="30" class=" me-2">
                <span class="text-dark fw-bold">ExSySP - SMK Seri Pekan</span>
            </div>
            <p class="text-muted small mb-0">&copy; {{ date('Y') }} SMK Seri Pekan, Pahang. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Floating Animation CSS -->
    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
    </style>
</body>
</html>