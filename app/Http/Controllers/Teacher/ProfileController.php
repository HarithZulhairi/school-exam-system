<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form.
     */
    public function edit()
    {
        $user = Auth::user();
        // Load the teacher profile with the user
        $teacher = $user->teacher;

        // Convert comma-separated subjects string back to array for the view
        $currentSubjects = $teacher->teacher_subjects ? explode(', ', $teacher->teacher_subjects) : [];

        return view('teacher.teacherProfile', compact('user', 'teacher', 'currentSubjects'));
    }

    /**
     * Update the profile data.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        // 1. Validate Data
        $request->validate([
            // User Table Validation
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            
            // Teacher Table Validation
            'nric'           => ['required', Rule::unique('teachers', 'teacher_ic')->ignore($teacher->teacher_id, 'teacher_id')],
            'phone_number'   => 'required|string|max:20',
            'address'        => 'required|string',
            'subjects'       => 'required|array', // Array from multi-select
            'qualifications' => 'required|string',
            'status'         => 'required|string',
            'age'            => 'required|integer|min:18',
            'DOB'            => 'required|date',
            'gender'         => 'required|string',

            // Optional Password Validation
            'password' => 'nullable|min:8|confirmed', // expects password_confirmation field
        ]);

        // 2. Update User Table
        $user->name = $request->name;
        $user->email = $request->email;
        
        // Only update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // 3. Update Teacher Table
        $teacher->teacher_ic = $request->nric;
        // $teacher->phone_number = $request->phone_number; // Add this if you added phone to migration, otherwise remove
        $teacher->teacher_address = $request->address;
        $teacher->teacher_qualifications = $request->qualifications;
        $teacher->teacher_status = $request->status;
        $teacher->teacher_age = $request->age;
        $teacher->teacher_DOB = $request->DOB;
        $teacher->teacher_gender = $request->gender;
        
        // Convert Array of Subjects to Comma Separated String
        $teacher->teacher_subjects = implode(', ', $request->subjects);
        
        $teacher->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}