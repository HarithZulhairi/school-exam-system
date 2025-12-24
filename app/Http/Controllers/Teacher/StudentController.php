<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $query = Student::with('user');

        // 1. View Type Logic
        $viewType = $request->input('view_type', 'all');

        if ($viewType === 'my_class') {
            $teacherClass = $teacher->teacher_form_class;
            if ($teacherClass) {
                // Normalize: Remove "Form " to match student data (e.g. "5 Bestari")
                $targetClass = trim(str_ireplace('Form ', '', $teacherClass));
                $query->where('student_class', $targetClass);
            } else {
                $query->where('student_id', -1);
            }
        }

        // 2. Search Logic
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('user', function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }

        // 3. Filters
        if ($viewType !== 'my_class') {
            if ($request->filled('form') && $request->form !== 'all') {
                $query->where('student_form', $request->form);
            }
            if ($request->filled('class_name') && $request->class_name !== 'all') {
                $query->where('student_class', $request->class_name);
            }
        }

        $availableClasses = Student::select('student_class')->distinct()->pluck('student_class');
        $students = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('teacher.teacherViewStudentList', compact('students', 'availableClasses', 'viewType'));
    }

    /**
     * Display the specified student details.
     */
    public function show($id)
    {
        // Fetch student with User info and Results (including the Exam details for those results)
        $student = Student::with(['user', 'results.exam'])->findOrFail($id);

        return view('teacher.teacherViewStudentDetails', compact('student'));
    }

}