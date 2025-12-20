<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class StudentExamController extends Controller
{

    public function create()
    {
        return view('teacher.teacherCreateExamQuestion');
    }

 
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'exam_date' => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        // Create the Exam linked to the current teacher
        $exam = Exam::create([
            'teacher_id' => Auth::user()->teacher->teacher_id,
            'title' => $request->title,
            'exam_date' => $request->exam_date,
            'duration_minutes' => $request->duration_minutes,
            'is_active' => true,
        ]);

        return redirect()->route('teacher.exams.questions.create', $exam->id)
                         ->with('success', 'Exam created! Now add your questions below.');
    }
}