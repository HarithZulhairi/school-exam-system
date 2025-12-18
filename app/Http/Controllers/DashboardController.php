<?php

namespace App\Http\Controllers;
http://googleusercontent.com/immersive_entry_chip/10.0.0/immersive_entry_chip.js

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Redirect based on user role
        if (auth()->user()->hasRole('teacher')) {
            return redirect()->route('teacher.home');
        } elseif (auth()->user()->hasRole('student')) {
            return redirect()->route('student.home');
        }

        // Default fallback
        return redirect('/dashboard');
    }

    public function teacherHome()
    {
        return view('teacher.dashboard');
    }

    public function studentHome()
    {
        return view('student.dashboard');
    }
}