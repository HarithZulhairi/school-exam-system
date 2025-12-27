<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class StudentController extends Controller
{
    /**
     * Display a listing of the students.
     */
    public function index(Request $request)
    {
        $query = Student::with('user');

        // 1. Search Logic
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('user', function($u) use ($searchTerm) {
                    $u->where('name', 'like', '%' . $searchTerm . '%');
                })->orWhere('student_ic', 'like', '%' . $searchTerm . '%');
            });
        }

        // 2. Filter by Form Level
        if ($request->filled('form') && $request->form !== 'all') {
            $query->where('student_form', $request->form);
        }

        // 3. Filter by Class Name
        if ($request->filled('class_name') && $request->class_name !== 'all') {
            $query->where('student_class', $request->class_name);
        }

        $availableClasses = Student::select('student_class')
                                   ->distinct()
                                   ->orderBy('student_class')
                                   ->pluck('student_class');

        $students = $query->orderBy('student_form', 'asc')
                          ->orderBy('student_class', 'asc')
                          ->paginate(10)
                          ->withQueryString();

        return view('admin.adminViewStudentList', compact('students', 'availableClasses'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        return view('admin.adminAddStudentForm');
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate Input
        $request->validate([
            // User Account
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            
            // Student Profile
            'student_ic' => 'required|string|unique:students',
            'student_gender' => 'required|in:Male,Female',
            'student_dob' => 'required|date',
            'student_form' => 'required|integer|min:1|max:6',
            'student_class' => 'required|string',
            'student_phone_number' => 'nullable|string',
            'student_address' => 'required|string',
        ]);

        // 2. Create User Login
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
        ]);

        // 3. Calculate Age based on DOB
        $age = Carbon::parse($request->student_dob)->age;

        // 4. Create Student Profile
        Student::create([
            'user_id' => $user->id,
            'student_ic' => $request->student_ic,
            'student_gender' => $request->student_gender,
            'student_DOB' => $request->student_dob,
            'student_age' => $age,
            'student_form' => $request->student_form,
            'student_class' => $request->student_class,
            'student_phone_number' => $request->student_phone_number,
            'student_address' => $request->student_address,
        ]);

        return redirect()->route('admin.students.index')
                         ->with('success', 'New student registered successfully.');
    }

    /**
     * Display the specified student details.
     */
    public function show($id)
    {
        $student = Student::with(['user', 'results.exam'])->findOrFail($id);
        return view('admin.adminViewStudentDetails', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit($id)
    {
        $student = Student::with('user')->findOrFail($id);
        return view('admin.adminEditStudentForm', compact('student'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, $id) 
    {
        $student = Student::findOrFail($id);
        $user = User::findOrFail($student->user_id);

        // 1. Validate Input
        $request->validate([
            // User Account
            'name' => 'required|string|max:255',
            
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id . ',id',
            'password' => 'nullable|string|min:6', 
            
            // Student Profile
            'student_ic' => 'required|string|unique:students,student_ic,' . $id . ',student_id',
            'student_gender' => 'required|in:Male,Female',
            'student_dob' => 'required|date',
            'student_form' => 'required|integer|min:1|max:6',
            'student_class' => 'required|string',
            'student_phone_number' => 'nullable|string',
            'student_address' => 'required|string',
        ]); 

        // 3. Update User Account
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        // 4. Calculate Age based on DOB
        $age = Carbon::parse($request->student_dob)->age;

        // 5. Update Student Profile
        $student->update([
            'student_ic' => $request->student_ic,
            'student_gender' => $request->student_gender,
            'student_DOB' => $request->student_dob,
            'student_age' => $age,
            'student_form' => $request->student_form,
            'student_class' => $request->student_class,
            'student_phone_number' => $request->student_phone_number,
            'student_address' => $request->student_address,
        ]);

        return redirect()->route('admin.students.show', $id)
                         ->with('success', 'Student details updated successfully.');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $user = User::findOrFail($student->user_id);
        $user->delete();

        return redirect()->route('admin.students.index')
                         ->with('success', 'Student record deleted successfully.');
    }
}