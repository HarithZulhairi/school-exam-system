<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StudentExamController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Public Landing Page
Route::get('/', function () {
    return view('welcome');
});

// 2. Authentication Routes (Assuming you are using Laravel Breeze or UI)
// If you don't have this file, you can rely on standard auth routes.
if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}

// 3. Protected Application Routes
Route::middleware(['auth'])->group(function () {

    // Main Dashboard Redirect (Decides if user is Teacher or Student)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ===========================
    // TEACHER ROUTES
    // ===========================
    Route::prefix('teacher')->name('teacher.')->group(function () {
        
        // Teacher Specific Dashboard
        Route::get('/home', [DashboardController::class, 'teacherHome'])->name('home');

        // Manage Exams (Create, Edit, Delete)
        Route::resource('exams', ExamController::class);

        // Manage Questions (Nested inside Exams: /teacher/exams/{exam}/questions/create)
        Route::resource('exams.questions', QuestionController::class)->shallow();
        
        // View Student Results
        Route::get('/results', [ExamController::class, 'studentResults'])->name('results.index');
    });

    // ===========================
    // STUDENT ROUTES
    // ===========================
    Route::prefix('student')->name('student.')->group(function () {
        
        // Student Specific Dashboard
        Route::get('/home', [DashboardController::class, 'studentHome'])->name('home');

        // View Available Exams
        Route::get('/exams', [StudentExamController::class, 'index'])->name('exams.index');
        
        // Take an Exam
        Route::get('/exams/{exam}/start', [StudentExamController::class, 'show'])->name('exams.show');
        Route::post('/exams/{exam}/submit', [StudentExamController::class, 'store'])->name('exams.submit');

        // View My History
        Route::get('/history', [StudentExamController::class, 'history'])->name('history');
    });

});