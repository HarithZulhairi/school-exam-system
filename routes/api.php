<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;

// Student Endpoints
Route::get('/students', [StudentController::class, 'index']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::post('/students', [StudentController::class, 'store']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::delete('/students/{id}', [StudentController::class, 'destroy']);

// Teacher Endpoints
Route::get('/teachers', [TeacherController::class, 'index']);
Route::post('/teachers', [TeacherController::class, 'store']);
Route::put('/teachers/{id}', [TeacherController::class, 'update']);
Route::get('/teachers/{id}', [TeacherController::class, 'show']);
Route::delete('/teachers/{id}', [TeacherController::class, 'destroy']);

// Fallback for unauthorized/test (optional)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});