<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class StudentController extends Controller
{
    /**
     * GET /api/students
     */
    public function index()
    {
        $students = Student::with('user')->get();
        return $students;
    }

    /**
     * GET /api/students/{id}
     */
    public function show($id)
    {
        $student = Student::with('user')->find($id);
        return $student;
    }

    /**
     * POST /api/students
     */
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'student_ic' => 'required|unique:students,student_ic',
            'student_gender' => 'required|in:Male,Female',
            'student_dob' => 'required|date',
            'student_form' => 'required|integer|min:1|max:6',
            'student_class' => 'required|string',
            'student_phone_number' => 'nullable|string',
            'student_address' => 'required|string',
        ]);

        
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
        ]);

        
        $age = Carbon::parse($validated['student_dob'])->age;

        $student = Student::create([
            'user_id' => $user->id,
            'student_ic' => $validated['student_ic'],
            'student_gender' => $validated['student_gender'],
            'student_DOB' => $validated['student_dob'],
            'student_age' => $age,
            'student_form' => $validated['student_form'],
            'student_class' => $validated['student_class'],
            'student_phone_number' => $validated['student_phone_number'],
            'student_address' => $validated['student_address'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Student registered successfully',
            'data' => $student->load('user')
        ], 201);
    }

    /**
     * PUT /api/students/{id}
     */
    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['success' => false, 'message' => 'Student not found'], 404);
        }

        $user = $student->user;

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'email', Rule::unique('users')->ignore($user->id)],
            'student_ic' => ['sometimes', Rule::unique('students')->ignore($student->student_id, 'student_id')],
            'student_gender' => 'sometimes|in:Male,Female',
            'student_dob' => 'sometimes|date',
            'student_form' => 'sometimes|integer|min:1|max:6',
            'student_class' => 'sometimes|string',
            'student_address' => 'sometimes|string',
        ]);

        if ($request->has('name')) $user->name = $request->name;
        if ($request->has('email')) $user->email = $request->email;
        if ($request->has('password')) $user->password = Hash::make($request->password);
        $user->save();

        if ($request->has('student_dob')) {
            $student->student_age = Carbon::parse($request->student_dob)->age;
        }
        
        $student->update($request->only([
            'student_ic', 'student_gender', 'student_DOB', 
            'student_form', 'student_class', 'student_phone_number', 'student_address'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully',
            'data' => $student->load('user')
        ], 200);
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['success' => false, 'message' => 'Student not found'], 404);
        }

        $user = User::find($student->user_id);

        if ($user) {
            $user->delete();
        } else {
            $student->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully'
        ], 200);
    }
}
