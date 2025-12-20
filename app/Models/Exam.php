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
        return $this->belongsTo(User::class, 'teacher_id');
    }
}