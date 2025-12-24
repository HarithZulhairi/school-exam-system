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
            'subjects'       => 'required|array', 
            'qualifications' => 'required|string',
            'status'         => 'required|string',
            'age'            => 'required|integer|min:18',
            'DOB'            => 'required|date',
            'gender'         => 'required|string',

            // --- NEW: Class Form Restriction ---
            // "form_class" must be unique in "teachers" table (column: teacher_form_class)
            // We ignore the current teacher's ID so they can keep their own class without error.
            'form_class'     => [
                'required', 
                'string', 
                Rule::unique('teachers', 'teacher_form_class')->ignore($teacher->teacher_id, 'teacher_id')
            ],

            // Optional Password Validation
            'password' => 'nullable|min:8|confirmed',
        ], [
            // Custom Error Message
            'form_class.unique' => 'This Class Form is already assigned to another teacher.',
        ]);

        // 2. Update User Table
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // 3. Update Teacher Table
        $teacher->teacher_ic = $request->nric;
        $teacher->teacher_address = $request->address;
        $teacher->teacher_phone_number = $request->phone_number; // Ensure this column matches your DB
        $teacher->teacher_qualifications = $request->qualifications;
        $teacher->teacher_status = $request->status;
        $teacher->teacher_age = $request->age;
        $teacher->teacher_DOB = $request->DOB;
        $teacher->teacher_gender = $request->gender;
        
        // Save the Class Form
        $teacher->teacher_form_class = $request->form_class;
        
        // Convert Array of Subjects to Comma Separated String
        $teacher->teacher_subjects = implode(', ', $request->subjects);
        
        $teacher->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}