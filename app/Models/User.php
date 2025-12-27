<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    // A User might be a Student
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    // A User might be a Teacher
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    // A User might be an Admin
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
    
}