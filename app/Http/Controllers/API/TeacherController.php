<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class TeacherController extends Controller
{
    /**
     * GET /api/teachers
     */
    public function index()
    {
        $teachers = Teacher::with('user')->get();
        
        return response()->json([
            'success' => true,
            'count' => $teachers->count(),
            'data' => $teachers
        ], 200);
    }

    /**
     * POST /api/teachers
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'teacher_ic' => 'required|unique:teachers,teacher_ic',
            'teacher_gender' => 'required|in:Male,Female',
            'teacher_dob' => 'required|date',
            'teacher_phone_number' => 'nullable|string',
            'teacher_address' => 'required|string',
            'teacher_qualifications' => 'required|string',
            'teacher_status' => 'required|string',
            'teacher_subjects' => 'required|string',
            'teacher_form_class' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'teacher',
        ]);

        $age = Carbon::parse($validated['teacher_dob'])->age;

        $teacher = Teacher::create([
            'user_id' => $user->id,
            'teacher_ic' => $validated['teacher_ic'],
            'teacher_gender' => $validated['teacher_gender'],
            'teacher_DOB' => $validated['teacher_dob'],
            'teacher_age' => $age,
            'teacher_phone_number' => $validated['teacher_phone_number'],
            'teacher_address' => $validated['teacher_address'],
            'teacher_qualifications' => $validated['teacher_qualifications'],
            'teacher_status' => $validated['teacher_status'],
            'teacher_subjects' => $validated['teacher_subjects'],
            'teacher_form_class' => $validated['teacher_form_class'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Teacher registered successfully',
            'data' => $teacher->load('user')
        ], 201);
    }

    /**
     * PUT /api/teachers/{id}
     */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return response()->json(['success' => false, 'message' => 'Teacher not found'], 404);
        }

        $user = $teacher->user;

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'email', Rule::unique('users')->ignore($user->id)],
            'teacher_ic' => ['sometimes', Rule::unique('teachers')->ignore($teacher->teacher_id, 'teacher_id')],
            'teacher_dob' => 'sometimes|date',
        ]);

        if ($request->has('name')) $user->name = $request->name;
        if ($request->has('email')) $user->email = $request->email;
        if ($request->has('password')) $user->password = Hash::make($request->password);
        $user->save();

        if ($request->has('teacher_dob')) {
            $teacher->teacher_age = Carbon::parse($request->teacher_dob)->age;
        }

        $teacher->update($request->except(['name', 'email', 'password']));

        return response()->json([
            'success' => true,
            'message' => 'Teacher updated successfully',
            'data' => $teacher->load('user')
        ], 200);
    }
}