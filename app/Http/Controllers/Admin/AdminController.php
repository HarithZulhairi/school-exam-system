<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Exam;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function dashboard()
    {
        
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalExams = Exam::count();
        
        
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.adminDashboard', compact('totalStudents', 'totalTeachers', 'totalExams', 'recentUsers'));
    }
    
    /**
     * Show the Admin Profile page.
     */
    public function profile()
    {
        $user = Auth::user();
        $admin = $user->admin; 
        
        return view('admin.adminProfile', compact('user', 'admin'));
    }

    /**
     * Update the Admin Profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $admin = $user->admin;

        
        $request->validate([
            
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            
            
            'admin_phone_number' => 'nullable|string|max:20',
            'admin_position' => 'required|string|max:255',
            'admin_age' => 'required|integer|min:18',
            
            
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

    
        $admin->update([
            'admin_name' => $request->name, 
            'admin_phone_number' => $request->admin_phone_number,
            'admin_position' => $request->admin_position,
            'admin_age' => $request->admin_age,
        ]);

        return redirect()->route('admin.profile')
                         ->with('success', 'Profile updated successfully.');
    }
}