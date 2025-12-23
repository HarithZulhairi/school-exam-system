<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    // 1. Define the custom primary key
    protected $primaryKey = 'teacher_id';

    // 2. Define fillable fields
    protected $fillable = [
        'user_id',
        'teacher_ic',
        'teacher_gender',
        'teacher_age',
        'teacher_DOB',
        'teacher_form_class', 
        'teacher_phone_number',
        'teacher_address',
        'teacher_subjects',
        'teacher_status',
        'teacher_qualifications',
    ];

    // 3. Relationships

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // A teacher creates/owns many exams
    public function exams()
    {
        return $this->hasMany(Exam::class, 'teacher_id');
    }
}