<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    /**
     * Display a listing of the teachers.
     */
    public function index(Request $request)
    {
        $query = Teacher::with('user');

        // 1. Search Logic
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('user', function($u) use ($searchTerm) {
                    $u->where('name', 'like', '%' . $searchTerm . '%');
                })->orWhere('teacher_ic', 'like', '%' . $searchTerm . '%');
            });
        }

        // 2. Filter by Class Assigned
        if ($request->filled('class_assigned') && $request->class_assigned !== 'all') {
            $query->where('teacher_form_class', $request->class_assigned);
        }

        $availableClasses = Teacher::select('teacher_form_class')
                                   ->whereNotNull('teacher_form_class')
                                   ->distinct()
                                   ->orderBy('teacher_form_class')
                                   ->pluck('teacher_form_class');

        $teachers = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.adminViewTeacherList', compact('teachers', 'availableClasses'));
    }

    /**
     * Show the form for creating a new teacher.
     */
    public function create()
    {
        return view('admin.adminAddTeacherForm');
    }

    /**
     * Store a newly created teacher in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate
        $request->validate([
            // User Account
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            
            // Teacher Profile
            'teacher_ic' => 'required|string|unique:teachers',
            'teacher_gender' => 'required|in:Male,Female',
            'teacher_dob' => 'required|date',
            'teacher_phone_number' => 'nullable|string',
            'teacher_address' => 'required|string',
            'teacher_qualifications' => 'required|string',
            'teacher_status' => 'required|string',
            'teacher_subjects' => 'required|string',
            'teacher_form_class' => 'nullable|string', // Optional
        ]);

        // 2. Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teacher',
        ]);

        // 3. Calc Age
        $age = Carbon::parse($request->teacher_dob)->age;

        // 4. Create Profile
        Teacher::create([
            'user_id' => $user->id,
            'teacher_ic' => $request->teacher_ic,
            'teacher_gender' => $request->teacher_gender,
            'teacher_DOB' => $request->teacher_dob,
            'teacher_age' => $age,
            'teacher_phone_number' => $request->teacher_phone_number,
            'teacher_address' => $request->teacher_address,
            'teacher_qualifications' => $request->teacher_qualifications,
            'teacher_status' => $request->teacher_status,
            'teacher_subjects' => $request->teacher_subjects,
            'teacher_form_class' => $request->teacher_form_class,
        ]);

        return redirect()->route('admin.teachers.index')
                         ->with('success', 'New teacher registered successfully.');
    }

    /**
     * Show the form for editing the specified teacher.
     */
    public function edit($id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        return view('admin.adminEditTeacherForm', compact('teacher'));
    }

    /**
     * Update the specified teacher in storage.
     */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        $user = User::findOrFail($teacher->user_id);

        $request->validate([
            'name' => 'required|string|max:255',
            // Ignore current user ID
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            
            // Ignore current teacher ID (PK: teacher_id)
            'teacher_ic' => ['required', 'string', Rule::unique('teachers', 'teacher_ic')->ignore($teacher->teacher_id, 'teacher_id')],
            'teacher_gender' => 'required|in:Male,Female',
            'teacher_dob' => 'required|date',
            'teacher_phone_number' => 'nullable|string',
            'teacher_address' => 'required|string',
            'teacher_qualifications' => 'required|string',
            'teacher_status' => 'required|string',
            'teacher_subjects' => 'required|string',
            'teacher_form_class' => 'nullable|string',
        ]);

        // Update User
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Update Profile
        $age = Carbon::parse($request->teacher_dob)->age;

        $teacher->update([
            'teacher_ic' => $request->teacher_ic,
            'teacher_gender' => $request->teacher_gender,
            'teacher_DOB' => $request->teacher_dob,
            'teacher_age' => $age,
            'teacher_phone_number' => $request->teacher_phone_number,
            'teacher_address' => $request->teacher_address,
            'teacher_qualifications' => $request->teacher_qualifications,
            'teacher_status' => $request->teacher_status,
            'teacher_subjects' => $request->teacher_subjects,
            'teacher_form_class' => $request->teacher_form_class,
        ]);

        return redirect()->route('admin.teachers.index')
                         ->with('success', 'Teacher details updated successfully.');
    }

    /**
     * Remove the specified teacher from storage.
     */
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $user = User::findOrFail($teacher->user_id);
        $user->delete();

        return redirect()->route('admin.teachers.index')
                         ->with('success', 'Teacher record deleted successfully.');
    }
}