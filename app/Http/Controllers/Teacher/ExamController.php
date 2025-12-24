<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
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
            'exam_form' => 'required|integer|between:1,5',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        // Create the Exam
        $exam = Exam::create([
            'teacher_id' => Auth::user()->teacher->teacher_id,
            'title' => $request->title,
            'exam_date' => $request->exam_date,
            'exam_form' => $request->exam_form,
            'duration_minutes' => $request->duration_minutes,
            'is_active' => true,
        ]);

        return redirect()->route('teacher.exams.questions.create', $exam)
                         ->with('success', 'Exam created! Now add your questions below.');
    }
    
    public function index(Request $request)
    {
        $query = Exam::where('teacher_id', Auth::user()->teacher->teacher_id);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('is_active', $request->status);
        }

        $exams = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('teacher.teacherManageExam', compact('exams')); 
    }

    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->delete(); // This also deletes questions due to onDelete('cascade') in migration

        return redirect()->route('teacher.exams.index')
                         ->with('success', 'Exam deleted successfully!');
    }

    public function edit($id)
    {
        $exam = Exam::findOrFail($id);

        return view('teacher.teacherEditExam', compact('exam'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'exam_date' => 'required|date',
            'exam_form' => 'required|integer|between:1,5',
            'duration_minutes' => 'required|integer|min:1',
            'is_active' => 'required|boolean', 
        ]);

        $exam = Exam::findOrFail($id);
        
        $exam->update([
            'title' => $request->title,
            'exam_date' => $request->exam_date,
            'exam_form' => $request->exam_form,
            'duration_minutes' => $request->duration_minutes,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('teacher.exams.index')
                         ->with('success', 'Exam updated successfully!');
    }
}