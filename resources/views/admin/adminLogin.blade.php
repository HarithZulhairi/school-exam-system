<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - ExSySP</title>

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
            overflow: hidden; /* Prevent scroll on full screen */
        }

        /* Split Screen Layout */
        .login-container {
            height: 100vh;
            display: flex;
            flex-wrap: wrap;
        }

        /* Left Side: Image & Branding */
        .login-sidebar {
            background: linear-gradient(135deg, #6f42c1 0%, #4c2889 100%);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            overflow: hidden;
        }
        
        /* Abstract Background Pattern */
        .login-sidebar::before {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            background: url('https://img.freepik.com/free-vector/education-pattern-background-doodle-style_53876-115365.jpg');
            background-size: 400px;
            opacity: 0.05;
            animation: rotate 60s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .sidebar-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 2rem;
        }

        /* Right Side: Form */
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

        /* Floating Inputs Styling */
        .form-floating > .form-control:focus ~ label {
            color: #6f42c1;
        }
        .form-control:focus {
            border-color: #6f42c1;
            box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.15);
        }

        .btn-primary {
            background-color: #6f42c1;
            border-color: #6f42c1;
            color: white;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background-color: #4c2889;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(25, 135, 84, 0.2);
        }

        /* Back Button */
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
            color: #6f42c1;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .login-sidebar {
                display: none; /* Hide image on mobile */
            }
            .login-form-section {
                width: 100%;
                height: 100vh;
            }
        }
    </style>
</head>
<body>

    <div class="container-fluid p-0">
        <div class="row g-0 login-container">
            
            <!-- LEFT SIDE: Branding & Image -->
            <div class="col-lg-6 login-sidebar">
                <div class="sidebar-content">
                    <div class="mb-4">
                        <i class="bi bi-mortarboard-fill display-1"></i>
                    </div>
                    <h2 class="fw-bold mb-3">Admin Portal</h2>
                    <p class="lead opacity-75">
                        Manage school data, teachers, students,  <br> and system settings.
                    </p>
                    <div class="mt-5">
                        <span class="badge bg-white text-primary px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-shield-lock-fill me-1"></i> Secure Admin Access
                        </span>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE: Login Form -->
            <div class="col-lg-6 login-form-section">
                <!-- Back to Home Link -->
                <a href="{{ url('/') }}" class="btn-back">
                    <i class="bi bi-arrow-left me-1"></i> Back to Home
                </a>

                <div class="login-card">
                    <div class="text-start mb-5">
                        <h3 class="fw-bold text-dark">Welcome back, Admin!</h3>
                        <p class="text-muted">Please enter your credentials to access the dashboard.</p>
                    </div>

                    <!-- Login Form -->
                    <!-- Assuming standard Laravel Auth route is 'login' -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf 

                        <!-- Email Input -->
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" placeholder="name@school.edu.my" 
                                   value="{{ old('email') }}" required autofocus>
                            <label for="email">Email Address</label>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" placeholder="Password" required>
                            <label for="password">Password</label>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                <label class="form-check-label text-muted small" for="remember_me">
                                    Remember me
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-decoration-none text-primary small fw-semibold">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 py-3 fw-bold shadow-sm">
                                Login to Dashboard
                            </button>
                        </div>

                        <!-- Switch to Student -->
                        <div class="text-center border-top pt-4">
                            <p class="text-muted small mb-2">Are you a teacher?</p>
                            <a href="{{ url('/teacher/login') }}" class="btn btn-outline-secondary rounded-pill px-4 btn-sm">
                                <i class="bi bi-backpack me-1"></i> Switch to Teacher Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>