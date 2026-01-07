<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Result;
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
            'exam_description' => 'nullable|string',
            'exam_start_time' => 'required|date_format:H:i',
            'exam_end_time' => 'required|date_format:H:i|after:exam_start_time',
            'exam_subject' => 'required|string|max:255',
            'exam_type' => 'required|string|max:255',
            'exam_paper' => 'required|string|max:255',
        ]);

        // Create the Exam
        $exam = Exam::create([
            'teacher_id' => Auth::user()->teacher->teacher_id,
            'title' => $request->title,
            'exam_date' => $request->exam_date,
            'exam_form' => $request->exam_form,
            'duration_minutes' => $request->duration_minutes,
            'is_active' => true,
            'exam_description' => $request->exam_description,
            'exam_start_time' => $request->exam_start_time,
            'exam_end_time' => $request->exam_end_time,
            'exam_subject' => $request->exam_subject,
            'exam_type' => $request->exam_type,
            'exam_paper' => $request->exam_paper,
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
        $exam->delete(); 

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
            'exam_description' => 'nullable|string',
            'exam_start_time' => 'required|date_format:H:i',
            'exam_end_time' => 'required|date_format:H:i|after:exam_start_time',
            'exam_subject' => 'required|string|max:255',
            'exam_type' => 'required|string|max:255',
            'exam_paper' => 'required|string|max:255',
        ]);

        $exam = Exam::findOrFail($id);
        
        $exam->update([
            'title' => $request->title,
            'exam_date' => $request->exam_date,
            'exam_form' => $request->exam_form,
            'duration_minutes' => $request->duration_minutes,
            'is_active' => $request->is_active,
            'exam_description' => $request->exam_description,
            'exam_start_time' => $request->exam_start_time,
            'exam_end_time' => $request->exam_end_time,
            'exam_subject' => $request->exam_subject,
            'exam_type' => $request->exam_type,
            'exam_paper' => $request->exam_paper,
        ]);

        return redirect()->route('teacher.exams.index')
                         ->with('success', 'Exam updated successfully!');
    }

    public function showResultDetails($result_id)
    {
        
        $result = Result::with(['exam.questions', 'student.user'])->findOrFail($result_id);

        $exam = $result->exam;
        $student = $result->student;
        
        
        $storedAnswers = json_decode($result->answers_json, true) ?? [];

        $detailedResults = [];
        foreach ($exam->questions as $question) {
            $studentAnswer = $storedAnswers[$question->question_id] ?? null;
            
            
            $isCorrect = ($studentAnswer && strtolower($studentAnswer) === strtolower($question->correct_answer));
            
            $detailedResults[] = [
                'question' => $question,
                'student_answer' => $studentAnswer,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect
            ];
        }

    
        return view('teacher.teacherViewExamResultDetails', [
            'exam' => $exam,
            'student' => $student,
            'score' => $result->score,
            'totalQuestions' => $result->total_questions,
            'detailedResults' => $detailedResults
        ]);
    }
}