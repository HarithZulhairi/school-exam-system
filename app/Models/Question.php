<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    // 1. Define the custom primary key
    protected $primaryKey = 'question_id';

    // 2. Define fillable fields
    protected $fillable = [
        'exam_id',
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
    ];

    // 3. Relationships
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }
}