<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    // 1. Define the custom primary key
    protected $primaryKey = 'result_id';

    // 2. Define fillable fields
    protected $fillable = [
        'student_id',
        'exam_id',
        'score',
        'total_questions',
        'answers_json',
    ];

    // 3. Relationships

    // Belongs to a Student Profile (not just a generic user)
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Belongs to a specific Exam
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }
}