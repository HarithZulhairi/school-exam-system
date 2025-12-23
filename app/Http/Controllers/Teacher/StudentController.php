<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{

    public function index(Request $request)
    {
        $query = Student::with('user');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('user', function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }


        if ($request->filled('form') && $request->form !== 'all') {
            $query->where('student_form', $request->form);
        }

        if ($request->filled('class_name') && $request->class_name !== 'all') {
            $query->where('student_class', $request->class_name);
        }


        $availableClasses = Student::select('student_class')->distinct()->pluck('student_class');

        $students = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('teacher.teacherViewStudentList', compact('students', 'availableClasses'));
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        
        $student->user->delete();

        return back()->with('success', 'Student account deleted successfully.');
    }
}