<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // 1. Define the custom primary key
    protected $primaryKey = 'student_id';

    // 2. Define fillable fields
    protected $fillable = [
        'user_id',
        'student_ic',
        'student_class',
        'student_phone_number',
        'student_address',
        'student_form',
    ];

    // 3. Relationships

    // Link back to the generic User login
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // A student has many exam results
    public function results()
    {
        return $this->hasMany(Result::class, 'student_id');
    }
}