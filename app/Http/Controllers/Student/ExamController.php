<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExamController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        if (!$student) return redirect()->route('student.profile');

        $takenExamIds = Result::where('student_id', $student->student_id)->pluck('exam_id');

        $exams = Exam::with('teacher.user')
                     ->where('is_active', true)
                     ->where('exam_form', $student->student_form)
                     ->whereNotIn('exam_id', $takenExamIds)
                     ->whereDate('exam_date', '>=', Carbon::today('Asia/Kuala_Lumpur'))
                     ->orderBy('exam_date', 'asc')
                     ->get();

        return view('student.studentTakeExam', compact('exams', 'student'));
    }

    public function show($id)
    {
        $exam = Exam::with('questions')->findOrFail($id);
        $student = Auth::user()->student;
        
        
        if($exam->exam_form != $student->student_form) {
            abort(403, 'This exam is not available for your form level.');
        }

        
        $timezone = 'Asia/Kuala_Lumpur';
        $now = Carbon::now($timezone);
        $startTime = Carbon::parse($exam->exam_date . ' ' . $exam->exam_start_time, $timezone);
        
        
        $endTime = Carbon::parse($exam->exam_date . ' ' . $exam->exam_end_time, $timezone);

        
        if ($now->lt($startTime)) {
            return redirect()->route('student.exams.index')->with('error', 'This exam has not started yet.');
        }

        if ($now->gt($endTime)) {
             return redirect()->route('student.exams.index')->with('error', 'This exam has already ended.');
        }

        
        $existingResult = Result::where('student_id', $student->student_id)
                                ->where('exam_id', $exam->exam_id)
                                ->first();
        
        if ($existingResult) {
            return redirect()->route('student.exams.index')->with('info', 'You have already taken this exam.');
        }

        
        return view('student.studentAttemptExam', compact('exam', 'endTime')); 
    }

    public function store(Request $request, $id)
    {
        $exam = Exam::with('questions')->findOrFail($id);
        $student = Auth::user()->student;

        $score = 0;
        $totalQuestions = $exam->questions->count();
        $submittedAnswers = $request->input('answers', []); 
        
        $detailedResults = [];

        foreach ($exam->questions as $question) {
            $studentAnswer = $submittedAnswers[$question->question_id] ?? null;
            $isCorrect = false;

            if ($studentAnswer && strtolower($studentAnswer) === strtolower($question->correct_answer)) {
                $score++;
                $isCorrect = true;
            }

            $detailedResults[] = [
                'question' => $question,
                'student_answer' => $studentAnswer,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect
            ];
        }

        Result::create([
            'student_id' => $student->student_id,
            'exam_id' => $exam->exam_id,
            'score' => $score,
            'total_questions' => $totalQuestions,
            'answers_json' => json_encode($submittedAnswers),
        ]);

        return view('student.studentExamResult', compact('exam', 'score', 'totalQuestions', 'detailedResults'));
    }

    
    public function history(Request $request)
    {
        $student = Auth::user()->student;
        $query = Result::with(['exam.teacher.user'])->where('student_id', $student->student_id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('exam', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }
        if ($request->filled('subject')) {
            $subject = $request->subject;
            $query->whereHas('exam', function($q) use ($subject) {
                $q->where('exam_subject', $subject);
            });
        }

        $results = $query->latest()->paginate(10)->withQueryString();
        $subjects = Exam::select('exam_subject')->distinct()->pluck('exam_subject');

        return view('student.studentExamHistory', compact('results', 'subjects'));
    }

    public function historyDetails($result_id)
    {
        $student = Auth::user()->student;
        $result = Result::with(['exam.questions'])->where('student_id', $student->student_id)->findOrFail($result_id);
        $exam = $result->exam;
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

        return view('student.studentExamResult', [
            'exam' => $exam,
            'score' => $result->score,
            'totalQuestions' => $result->total_questions,
            'detailedResults' => $detailedResults
        ]);
    }
}