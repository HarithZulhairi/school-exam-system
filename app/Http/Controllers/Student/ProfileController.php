<?php

namespace App\Http\Controllers\Student;

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
        $student = $user->student;

        return view('student.studentProfile', compact('user', 'student'));
    }

    /**
     * Update the profile data.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;

        
        $request->validate([
            
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            
            
            'nric'           => ['required', Rule::unique('students', 'student_ic')->ignore($student->student_id, 'student_id')],
            'phone_number'   => 'required|string|max:20',
            'address'        => 'required|string',
            'age'            => 'required|integer|min:10',
            'DOB'            => 'required|date',
            'gender'         => 'required|string',
            
            
            'form'           => 'required|integer|min:1|max:6',
            'class_name'     => 'required|string',

            
            'password' => 'nullable|min:8|confirmed',
        ]);

        
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        
        $student->student_ic = $request->nric;
        $student->student_phone_number = $request->phone_number;
        $student->student_address = $request->address;
        $student->student_age = $request->age;
        $student->student_DOB = $request->DOB;
        $student->student_gender = $request->gender;
        
        
        $student->student_form = $request->form;
        $student->student_class = $request->class_name; 
        
        $student->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}