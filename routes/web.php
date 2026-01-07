<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Teacher\ProfileController as TeacherProfileController;
use App\Http\Controllers\Teacher\ExamController as TeacherExamController;
use App\Http\Controllers\Teacher\QuestionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Teacher\StudentController as TeacherStudentController;

use App\Http\Controllers\Student\ProfileController as StudentProfileController;
use App\Http\Controllers\Student\ExamController as StudentExamController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\ExamController as AdminExamController;


// Public Landing Page
Route::get('/', function () {
    return view('welcome');
});

if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}

// ===========================
// LOGIN ROUTES
// ===========================
Route::middleware('guest')->group(function () {
    
    Route::get('/teacher/login', function () {
        return view('teacher.teacherLogin');
    })->name('teacher.login');

    Route::get('/student/login', function () {
        return view('student.studentLogin');
    })->name('student.login');

    Route::get('/admin/login', function () {
        return view('admin.adminLogin');
    })->name('admin.login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
});

// ===========================
// LOGOUT ROUTE
// ===========================
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

// ===========================
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ===========================
    // TEACHER ROUTES
    // ===========================
    Route::middleware(['user-access:teacher'])->prefix('teacher')->name('teacher.')->group(function () {

   
        Route::get('/dashboard', [DashboardController::class, 'teacherHome'])->name('teacherDashboard');

 
        Route::get('/profile', [TeacherProfileController::class, 'edit'])->name('profile');
        Route::put('/profile', [TeacherProfileController::class, 'update'])->name('profile.update');

        Route::resource('exams', TeacherExamController::class);
        Route::resource('exams.questions', QuestionController::class)->shallow();

        Route::get('/results', [TeacherExamController::class, 'studentResults'])->name('results.index');


        Route::get('/students', [TeacherStudentController::class, 'index'])->name('students.list');
        Route::get('/students/{id}', [TeacherStudentController::class, 'show'])->name('students.show');
        Route::delete('/students/{id}', [TeacherStudentController::class, 'destroy'])->name('students.destroy');

        Route::get('students/exam/details/{id}', [TeacherExamController::class, 'showResultDetails'])->name('exams.result.details');
    });

    // ===========================
    // STUDENT ROUTES
    // ===========================
    Route::middleware(['user-access:student'])->prefix('student')->name('student.')->group(function () {

 
        Route::get('/dashboard', [DashboardController::class, 'studentHome'])->name('studentDashboard');

   
        Route::get('/profile', [StudentProfileController::class, 'edit'])->name('profile');
        Route::put('/profile', [StudentProfileController::class, 'update'])->name('profile.update');



        Route::get('/exams', [StudentExamController::class, 'index'])->name('exams.index');
        Route::get('/exams/{id}', [StudentExamController::class, 'show'])->name('exams.show');
        Route::post('/exams/{id}', [StudentExamController::class, 'store'])->name('exams.store');

        Route::get('/history', [StudentExamController::class, 'history'])->name('exams.history');
        Route::get('/history/{id}', [StudentExamController::class, 'historyDetails'])->name('exams.history.details');

    });

    // ===========================
    // ADMIN ROUTES
    // ===========================
    Route::middleware(['user-access:admin'])->prefix('admin')->name('admin.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('adminDashboard');
        
        // Profile (Placeholder route for now)
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
        Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');

        // Student Management Routes
        Route::get('/students/create', [AdminStudentController::class, 'create'])->name('students.create');
        Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
        Route::post('/students', [AdminStudentController::class, 'store'])->name('students.store');
        Route::get('/students/{id}', [AdminStudentController::class, 'show'])->name('students.show');
        Route::delete('/students/{id}', [AdminStudentController::class, 'destroy'])->name('students.destroy');
        Route::get('/students/{id}/edit', [AdminStudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{id}', [AdminStudentController::class, 'update'])->name('students.update');
        Route::get('/students/exam/details/{id}', [AdminExamController::class, 'showResultDetails'])->name('exams.result.details');

        // Teacher Management Routes
        Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
        Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
        Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
        Route::get('/teachers/{id}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
        Route::put('/teachers/{id}', [TeacherController::class, 'update'])->name('teachers.update');
        Route::delete('/teachers/{id}', [TeacherController::class, 'destroy'])->name('teachers.destroy');

    });

});