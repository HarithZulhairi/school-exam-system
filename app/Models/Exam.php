<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $primaryKey = 'exam_id';

    protected $fillable = [
        'teacher_id',
        'title',
        'exam_date',
        'exam_start_time',
        'exam_end_time',
        'exam_description',
        'exam_subject',
        'exam_type',
        'exam_paper',
        'exam_form',
        'duration_minutes',
        'is_active',
    ];

    // An exam has many questions
    public function questions()
    {
        return $this->hasMany(Question::class, 'exam_id');
    }

    // An exam belongs to one teacher
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}