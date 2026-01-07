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

        
        $request->validate([
            
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            
            
            'nric'           => ['required', Rule::unique('teachers', 'teacher_ic')->ignore($teacher->teacher_id, 'teacher_id')],
            'phone_number'   => 'required|string|max:20',
            'address'        => 'required|string',
            'subjects'       => 'required|array', 
            'qualifications' => 'required|string',
            'status'         => 'required|string',
            'age'            => 'required|integer|min:18',
            'DOB'            => 'required|date',
            'gender'         => 'required|string',

            
            'form_class'     => [
                'required', 
                'string', 
                Rule::unique('teachers', 'teacher_form_class')->ignore($teacher->teacher_id, 'teacher_id')
            ],

            
            'password' => 'nullable|min:8|confirmed',
        ], [
            
            'form_class.unique' => 'This Class Form is already assigned to another teacher.',
        ]);

        
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        
        $teacher->teacher_ic = $request->nric;
        $teacher->teacher_address = $request->address;
        $teacher->teacher_phone_number = $request->phone_number; 
        $teacher->teacher_qualifications = $request->qualifications;
        $teacher->teacher_status = $request->status;
        $teacher->teacher_age = $request->age;
        $teacher->teacher_DOB = $request->DOB;
        $teacher->teacher_gender = $request->gender;
        
        
        $teacher->teacher_form_class = $request->form_class;
        
        
        $teacher->teacher_subjects = implode(', ', $request->subjects);
        
        $teacher->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}