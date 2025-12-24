<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Teacher\ProfileController;
use App\Http\Controllers\Teacher\ExamController;
use App\Http\Controllers\Teacher\QuestionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Teacher\StudentController as TeacherStudentController;


// Public Landing Page
Route::get('/', function () {
    return view('welcome');
});

if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}

// ===========================
// GUEST ROUTES (Login Pages)
// ===========================
Route::middleware('guest')->group(function () {
    
    Route::get('/teacher/login', function () {
        return view('teacher.teacherLogin');
    })->name('teacher.login');

    Route::get('/student/login', function () {
        return view('student.studentLogin');
    })->name('student.login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
});

// ===========================
// LOGOUT ROUTE
// ===========================
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

// ===========================
Route::middleware(['auth'])->group(function () {

    // Main Dashboard Redirect (Decides if user is Teacher or Student)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ===========================
    // TEACHER ROUTES
    // ===========================
    Route::prefix('teacher')->name('teacher.')->group(function () {

        // Login
        // Route::get('/teacher/login', function () {
        //     return view('teacher.teacherLogin');
        // })->name('login');

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'teacherHome'])->name('teacherDashboard');

        // Profile
        // Route::get('/profile', function () {
        //     return view('teacher.teacherProfile');
        // })->name('profile');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        // Exam Management
        // Route::get('/exam/create-question', function () {
        //     return view('teacher.teacherCreateExamQuestion');
        // })->name('exam.createQuestion');

        // Route::get('/exam/edit', function () {
        //     return view('teacher.teacherEditExam');
        // })->name('exam.edit');

        // Route::get('/exam/view', function () {
        //     return view('teacher.teacherViewExam');
        // })->name('exam.view');


        Route::resource('exams', ExamController::class);
        Route::resource('exams.questions', QuestionController::class)->shallow();

        Route::get('/results', [ExamController::class, 'studentResults'])->name('results.index');

        // View Student List
        // Route::get('/students', function () {
        //     return view('teacher.teacherViewStudentList');
        // })->name('students.list');

        Route::get('/students', [TeacherStudentController::class, 'index'])->name('students.list');
        Route::get('/students/{id}', [TeacherStudentController::class, 'show'])->name('students.show');
        Route::delete('/students/{id}', [TeacherStudentController::class, 'destroy'])->name('students.destroy');
    });

    // ===========================
    // STUDENT ROUTES
    // ===========================
    Route::prefix('student')->name('student.')->group(function () {

        // Login
        // Route::get('/student/login', function () {
        //     return view('studentLogin');
        // })->name('login');

        // Route::get('/login', [StudentExamController::class, 'index'])->name('exams.index');

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'studentHome'])->name('studentDashboard');

        // Profile
        Route::get('/profile', function () {
            return view('student.studentProfile');
        })->name('profile');

        // Exams
        Route::get('/exam/take', function () {
            return view('student.studentTakeExam');
        })->name('exam.take');

        Route::get('/exam/view', function () {
            return view('student.studentViewExam');
        })->name('exam.view');

        Route::get('/result', function () {
            return view('student.studentViewResult');
        })->name('result');
    });

});