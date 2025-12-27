<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Admin;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create('ms_MY'); // Malaysian Data

        // ==========================================
        // 0. CREATE 2 ADMINS
        // ==========================================

        // Admin 1
        $adminUser1 = User::create([
            'name' => 'Encik Ahmad Bin Faisal',
            'email' => 'admin1@smksp.edu.my',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);
        Admin::create([
            'user_id' => $adminUser1->id,
            'admin_age' => 45,
            'admin_phone_number' => '012-3456789',
            'admin_position' => 'Senior Administrator'
        ]);

        // Admin 2
        $adminUser2 = User::create([
            'name' => 'Puan Salmah',
            'email' => 'admin2@smksp.edu.my',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);
        Admin::create([
            'user_id' => $adminUser2->id,
            'admin_age' => 38,
            'admin_phone_number' => '019-8765432',
            'admin_position' => 'IT Support Officer'
        ]);

        // ==========================================
        // 1. CREATE 5 TEACHERS
        // ==========================================
        for ($i = 1; $i <= 5; $i++) {
            
            // 1. Generate Teacher Details First
            $gender = $faker->randomElement(['Male', 'Female']);
            $dob = $faker->dateTimeBetween('1970-01-01', '1998-12-31'); // Teacher born before 1998
            $dobString = $dob->format('Y-m-d');
            $age = Carbon::parse($dobString)->age;

            // 2. Generate IC for Teacher
            // Format: YYMMDD-PB-###G (PB=Place Birth, G=Gender)
            $icDate = $dob->format('ymd');
            $icPlace = '04'; // Melaka
            
            // Generate last 4 digits
            $randomPart = $faker->numberBetween(100, 999); // 3 digits
            $lastDigit = $faker->numberBetween(0, 9);
            
            // Adjust last digit for gender
            if ($gender === 'Male') {
                // Ensure odd
                if ($lastDigit % 2 == 0) $lastDigit++; 
                if ($lastDigit > 9) $lastDigit = 1; 
            } else {
                // Ensure even
                if ($lastDigit % 2 != 0) $lastDigit--;
            }
            
            $icNumber = $icDate . $icPlace . $randomPart . $lastDigit;

            // 3. Create the Login User
            $user = User::create([
                'name' => ($gender == 'Male' ? 'Cikgu ' : 'Puan ') . $faker->firstName($gender),
                'email' => 'teacher' . $i . '@school.edu', 
                'password' => Hash::make('123456'),      
                'role' => 'teacher',
            ]);

            // 4. Create Teacher Profile
            Teacher::create([
                'user_id' => $user->id,
                'teacher_ic' => $icNumber,
                'teacher_form_class' => $faker->randomElement(['1', '2', '3', '4', '5']) . ' ' . $faker->randomElement(['Bestari', 'Cerdik', 'Amanah']),
                'teacher_address' => $faker->address,
                'teacher_phone_number' => $faker->phoneNumber,
                'teacher_subjects' => $faker->randomElement(['Bahasa Melayu', 'English', 'Mathematics', 'Science', 'History']),
                'teacher_status' => 'Permanent',
                'teacher_qualifications' => 'Bachelor of Education',
                'teacher_gender' => $gender,
                'teacher_age' => $age,
                'teacher_DOB' => $dobString,
            ]);
        }

        // ==========================================
        // 2. CREATE 5 STUDENTS
        // ==========================================
        for ($i = 1; $i <= 5; $i++) {

            // 1. Generate Student Class & Form Logic
            // Example: "4 Bestari"
            $formNumber = $faker->numberBetween(1, 5);
            $className = $faker->randomElement(['Bestari', 'Cerdik', 'Amanah', 'Dedikasi']);
            $fullClassName = $formNumber . ' ' . $className;

            // 2. Generate Gender & DOB
            $gender = $faker->randomElement(['Male', 'Female']);
            
            // Calculate birth year based on Form (approximate)
            // Form 1 is approx 13 years old, Form 5 is 17
            $currentYear = date('Y');
            $birthYear = $currentYear - (12 + $formNumber); 
            $dob = $faker->dateTimeBetween("$birthYear-01-01", "$birthYear-12-31");
            $dobString = $dob->format('Y-m-d');
            $age = Carbon::parse($dobString)->age;

            // 3. Generate IC for Student
            $icDate = $dob->format('ymd');
            $icPlace = '04'; // Melaka
            
            $randomPart = $faker->numberBetween(100, 999);
            $lastDigit = $faker->numberBetween(0, 9);
            
            if ($gender === 'Male') {
                if ($lastDigit % 2 == 0) $lastDigit++; 
                if ($lastDigit > 9) $lastDigit = 1; 
            } else {
                if ($lastDigit % 2 != 0) $lastDigit--;
            }
            
            $icNumber = $icDate . $icPlace . $randomPart . $lastDigit;

            // 4. Create Login User
            $user = User::create([
                'name' => $faker->name($gender),
                'email' => 'student' . $i . '@school.edu', 
                'password' => Hash::make('123456'),      
                'role' => 'student',
            ]);

            // 5. Create Student Profile
            Student::create([
                'user_id' => $user->id,
                'student_ic' => $icNumber,
                'student_class' => $fullClassName, // "4 Bestari"
                'student_address' => $faker->address,
                'student_phone_number' => $faker->phoneNumber,
                'student_form' => $formNumber, // Extracted from class logic
                'student_gender' => $gender,
                'student_age' => $age,
                'student_DOB' => $dobString,
            ]);
        }
    }
}