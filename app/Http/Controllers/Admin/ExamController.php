<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Result;

class ExamController extends Controller
{
    public function showResultDetails($result_id)
    {
        // 1. Fetch the result with necessary relationships
        // We include 'student.user' to display the student's name in the view
        $result = Result::with(['exam.questions', 'student.user'])->findOrFail($result_id);

        $exam = $result->exam;
        $student = $result->student;
        
        // 3. Decode the stored answers
        $storedAnswers = json_decode($result->answers_json, true) ?? [];

        // 4. Reconstruct detailed results
        $detailedResults = [];
        foreach ($exam->questions as $question) {
            $studentAnswer = $storedAnswers[$question->question_id] ?? null;
            
            // Compare answer (case-insensitive)
            $isCorrect = ($studentAnswer && strtolower($studentAnswer) === strtolower($question->correct_answer));
            
            $detailedResults[] = [
                'question' => $question,
                'student_answer' => $studentAnswer,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect
            ];
        }

        // 5. Return the Teacher-specific view
        return view('admin.adminViewExamResultDetails', [
            'exam' => $exam,
            'student' => $student,
            'score' => $result->score,
            'totalQuestions' => $result->total_questions,
            'detailedResults' => $detailedResults
        ]);
    }
}
