<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Exam;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'teacher') {
            return redirect()->route('teacher.teacherDashboard');
        } elseif ($user->role === 'student') {
            return redirect()->route('student.studentDashboard');
        }

        return redirect('/'); 
    }

    public function teacherHome()
    {
        // 1. Get Basic Stats
        $totalStudents = Student::count();
        $activeExams = Exam::where('is_active', true)->count();
        $totalExams = Exam::count();

        // 2. Get Student Registration Data for Graph (Group by Month)
        // This query counts students created in the current year, grouped by month
        $studentsData = Student::select(DB::raw("COUNT(*) as count"), DB::raw("MONTH(created_at) as month_name"))
                    ->whereYear('created_at', date('Y'))
                    ->groupBy(DB::raw("month_name"))
                    ->orderBy('month_name')
                    ->pluck('count', 'month_name');
        
        // 3. Format Data for Chart.js (Ensure all 12 months exist)
        $labels = [];
        $data = [];
        for ($m = 1; $m <= 12; $m++) {
            $month = date('F', mktime(0, 0, 0, $m, 1)); // Jan, Feb, Mar...
            $labels[] = $month;
            // If data exists for month $m, use it, otherwise 0
            $data[] = $studentsData->has($m) ? $studentsData->get($m) : 0;
        }

        return view('teacher.teacherDashboard', compact('totalStudents', 'activeExams', 'totalExams', 'labels', 'data'));
    }

    public function studentHome()
    {
        return view('student.studentDashboard');
    }
}