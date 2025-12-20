<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>School Examination Management System</title>

    <!-- 1. Google Fonts: Poppins for a modern look -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
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
            padding: 100px 0;
            background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%);
            position: relative;
            overflow: hidden;
        }
        
        /* Abstract Shapes for Background */
        .shape-blob {
            position: absolute;
            opacity: 0.1;
            z-index: 0;
        }
        .shape-1 { top: -50px; right: -50px; width: 300px; height: 300px; background: #0d6efd; border-radius: 50%; filter: blur(50px); }
        .shape-2 { bottom: -50px; left: -50px; width: 400px; height: 400px; background: #6610f2; border-radius: 50%; filter: blur(60px); }

        /* Feature Cards */
        .feature-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: white;
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        /* Role Selection Cards */
        .role-card {
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s;
        }
        .role-card:hover {
            border-color: #0d6efd;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 text-primary" href="#">
                <i class="bi bi-mortarboard-fill me-2"></i>School<span class="text-dark">Exams</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#roles">Log in</a></li>
                    <!-- Auth Links Check -->
                    <!-- @if (Route::has('login'))
                        @auth
                            <li class="nav-item ms-2">
                                <a href="{{ url('/dashboard') }}" class="btn btn-primary rounded-pill px-4">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item ms-2">
                                <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-4 me-2">Log in</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-4">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif -->
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
                    <span class="badge bg-light text-primary border border-primary px-3 py-2 rounded-pill mb-3 fw-normal">
                        <i class="bi bi-stars me-1"></i> Smart Examination System
                    </span>
                    <h1 class="display-3 fw-bold mb-3 lh-sm text-dark">
                        Exams Made <br> <span class="text-primary">Simple & Secure</span>
                    </h1>
                    <p class="lead text-secondary mb-4">
                        A complete digital assessment platform for Malaysian Schools. 
                        Teachers create exams effortlessly, and students get instant results.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#roles" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">
                            Get Started <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="#features" class="btn btn-outline-secondary btn-lg rounded-pill px-4">
                            Learn More
                        </a>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="row mt-5 pt-4 border-top">
                        <div class="col-4">
                            <h4 class="fw-bold mb-0">100%</h4>
                            <small class="text-muted">Paperless</small>
                        </div>
                        <div class="col-4">
                            <h4 class="fw-bold mb-0">Instant</h4>
                            <small class="text-muted">Grading</small>
                        </div>
                        <div class="col-4">
                            <h4 class="fw-bold mb-0">Secure</h4>
                            <small class="text-muted">Platform</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 text-center">
                    <!-- Placeholder for Hero Image -->
                    <div class="position-relative">
                        <img src="https://img.freepik.com/free-vector/online-test-concept-illustration_114360-5474.jpg" 
                             alt="Online Exam Illustration" 
                             class="img-fluid rounded-4 shadow-lg"
                             style="max-width: 90%; transform: rotate(2deg);">
                        
                        <!-- Floating Card Effect -->
                        <div class="card position-absolute border-0 shadow-lg p-3 rounded-4" style="bottom: -20px; left: 20px; width: 200px; animation: float 3s ease-in-out infinite;">
                            <div class="d-flex align-items-center">
                                <div class="bg-success text-white rounded-circle p-2 me-3">
                                    <i class="bi bi-check-lg"></i>
                                </div>
                                <div class="text-start">
                                    <h6 class="mb-0 fw-bold">Exam Submitted</h6>
                                    <small class="text-success">Score: 95/100</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Role Selection Section -->
    <section id="roles" class="py-5 bg-white">
        <div class="container py-5">
            <div class="text-center mb-5">
                <small class="text-primary fw-bold text-uppercase ls-md">Get Started</small>
                <h2 class="fw-bold mt-2">Who are you?</h2>
                <p class="text-muted">Select your role to login or register.</p>
            </div>

            <div class="row justify-content-center g-4">
                <!-- Teacher Card -->
                <div class="col-md-5 col-lg-4">
                    <a href="{{ route('teacher.login') }}" class="text-decoration-none text-dark">
                        <div class="card role-card h-100 p-4 shadow-sm text-center">
                            <div class="card-body">
                                <div class="icon-box bg-primary bg-opacity-10 text-primary mx-auto rounded-circle" style="width: 80px; height: 80px;">
                                    <i class="bi bi-person-video3 display-5"></i>
                                </div>
                                <h4 class="fw-bold mt-4">I am a Teacher</h4>
                                <p class="text-muted small">Create exams, manage questions, and view student performance reports.</p>
                                <button class="btn btn-outline-primary w-100 rounded-pill mt-2">Teacher Login</button>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Student Card -->
                <div class="col-md-5 col-lg-4">
                    <a href="{{ route('student.login') }}" class="text-decoration-none text-dark">
                        <div class="card role-card h-100 p-4 shadow-sm text-center">
                            <div class="card-body">
                                <div class="icon-box bg-success bg-opacity-10 text-success mx-auto rounded-circle" style="width: 80px; height: 80px;">
                                    <i class="bi bi-backpack4 display-5"></i>
                                </div>
                                <h4 class="fw-bold mt-4">I am a Student</h4>
                                <p class="text-muted small">Access your exams, submit answers, and check your result history.</p>
                                <button class="btn btn-outline-success w-100 rounded-pill mt-2">Student Login</button>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5" style="background-color: #f8f9fa;">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Why Choose This System?</h2>
                <p class="text-muted">Designed efficiently for the Malaysian school curriculum.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card p-4">
                        <div class="icon-box bg-info bg-opacity-10 text-info">
                            <i class="bi bi-stopwatch"></i>
                        </div>
                        <h5 class="fw-bold">Timed Assessments</h5>
                        <p class="text-muted">Exams automatically close when the duration ends, ensuring fairness for all students.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4">
                        <div class="icon-box bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-bar-chart-line"></i>
                        </div>
                        <h5 class="fw-bold">Instant Results</h5>
                        <p class="text-muted">Students get their scores immediately after submission. No more waiting for manual marking.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4">
                        <div class="icon-box bg-danger bg-opacity-10 text-danger">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <h5 class="fw-bold">Secure Access</h5>
                        <p class="text-muted">Role-based security ensures students only see their own exams and results.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-top py-4">
        <div class="container text-center">
            <div class="mb-3">
                <span class="text-primary fw-bold fs-5"><i class="bi bi-mortarboard-fill"></i> SchoolExams</span>
            </div>
            <p class="text-muted small mb-0">&copy; {{ date('Y') }} Integrated Application Development Framework (BCS3453). All rights reserved.</p>
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