<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Login - SchoolExams</title>

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            height: 100vh;
            overflow: hidden;
        }

        .login-container {
            height: 100vh;
            display: flex;
            flex-wrap: wrap;
        }

        /* LEFT SIDE: Green Gradient for Students */
        .login-sidebar {
            background: linear-gradient(135deg, #198754 0%, #0f5132 100%); /* Success Green */
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            overflow: hidden;
        }
        
        .login-sidebar::before {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            /* Different pattern for variety */
            background: url('https://img.freepik.com/free-vector/hand-drawn-back-school-background_23-2149464866.jpg'); 
            background-size: cover;
            opacity: 0.1;
            mix-blend-mode: overlay;
            animation: pulse 10s infinite alternate;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            100% { transform: scale(1.05); }
        }

        .sidebar-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 2rem;
        }

        /* RIGHT SIDE: Form */
        .login-form-section {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            position: relative;
        }

        .login-card {
            width: 100%;
            max-width: 450px;
            padding: 2rem;
        }

        /* Green Focus States */
        .form-floating > .form-control:focus ~ label {
            color: #198754;
        }
        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.15);
        }

        .btn-success-custom {
            background-color: #198754;
            border-color: #198754;
            color: white;
            transition: all 0.3s;
        }
        .btn-success-custom:hover {
            background-color: #157347;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(25, 135, 84, 0.2);
        }

        .btn-back {
            position: absolute;
            top: 20px;
            left: 20px;
            text-decoration: none;
            color: #6c757d;
            font-size: 0.9rem;
            transition: color 0.3s;
        }
        .btn-back:hover {
            color: #198754;
        }

        @media (max-width: 768px) {
            .login-sidebar { display: none; }
            .login-form-section { width: 100%; height: 100vh; }
        }
    </style>
</head>
<body>

    <div class="container-fluid p-0">
        <div class="row g-0 login-container">
            
            <!-- LEFT SIDE: Student Branding -->
            <div class="col-lg-6 login-sidebar">
                <div class="sidebar-content">
                    <div class="mb-4">
                        <i class="bi bi-backpack4-fill display-1"></i>
                    </div>
                    <h2 class="fw-bold mb-3">Student Portal</h2>
                    <p class="lead opacity-75">
                        Access your exams, check your results, <br> and achieve your academic goals.
                    </p>
                    <div class="mt-5">
                        <span class="badge bg-white text-success px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-check-circle-fill me-1"></i> Ready for Exam
                        </span>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE: Login Form -->
            <div class="col-lg-6 login-form-section">
                <a href="{{ url('/') }}" class="btn-back">
                    <i class="bi bi-arrow-left me-1"></i> Back to Home
                </a>

                <div class="login-card">
                    <div class="text-start mb-5">
                        <h3 class="fw-bold text-dark">Hello, Student! <span class="fs-4">👋</span></h3>
                        <p class="text-muted">Enter your details to start your exam session.</p>
                    </div>

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf 

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" placeholder="name@school.edu.my" 
                                   value="{{ old('email') }}" required autofocus>
                            <label for="email">Email Address</label>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" placeholder="Password" required>
                            <label for="password">Password</label>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                <label class="form-check-label text-muted small" for="remember_me">
                                    Remember me
                                </label>
                            </div>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-success-custom btn-lg rounded-3 py-3 fw-bold">
                                Login to Portal
                            </button>
                        </div>

                        <!-- Switch to Teacher -->
                        <div class="text-center border-top pt-4">
                            <p class="text-muted small mb-2">Are you a teacher?</p>
                            <a href="{{ route('teacher.login') }}" class="btn btn-outline-secondary rounded-pill px-4 btn-sm">
                                <i class="bi bi-person-video3 me-1"></i> Switch to Teacher Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>