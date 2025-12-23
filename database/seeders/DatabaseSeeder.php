<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create('ms_MY'); // Malaysian Data

        // ==========================================
        // 1. CREATE 5 TEACHERS
        // ==========================================
        for ($i = 1; $i <= 5; $i++) {
            
            // A. Create the Login User
            $user = User::create([
                'name' => $faker->name,
                'email' => 'teacher' . $i . '@school.edu', // teacher1@school.edu
                'password' => Hash::make('password'),      // Default password
                'role' => 'teacher',
            ]);

            // B. Create the Teacher Profile linked to the User
            Teacher::create([
                'user_id' => $user->id,
                'teacher_ic' => $faker->unique()->numerify('############'), // 12 digit IC
                'teacher_form_class' => 'Form ' . $faker->randomElement(['1', '2', '3', '4', '5']) . ' ' . $faker->randomElement(['Bestari', 'Cerdik', 'Amanah']),
                'teacher_address' => $faker->address,
                'teacher_phone_number' => $faker->phoneNumber,
                'teacher_subjects' => $faker->randomElement(['Bahasa Melayu', 'English', 'Mathematics', 'Science', 'History']),
                'teacher_status' => 'Permanent',
                'teacher_qualifications' => 'Bachelor of Education',
                'teacher_gender' => $faker->randomElement(['Male', 'Female']),
                'teacher_age' => $faker->numberBetween(25, 55),
                'teacher_DOB' => $faker->date('Y-m-d', '1998-01-01'), // Born before 1998
            ]);
        }

        // ==========================================
        // 2. CREATE 5 STUDENTS
        // ==========================================
        for ($i = 1; $i <= 5; $i++) {

            // A. Create the Login User
            $user = User::create([
                'name' => $faker->name,
                'email' => 'student' . $i . '@school.edu', // student1@school.edu
                'password' => Hash::make('password'),      // Default password
                'role' => 'student',
            ]);

            // B. Create the Student Profile linked to the User
            Student::create([
                'user_id' => $user->id,
                'student_ic' => $faker->unique()->numerify('############'), // 12 digit IC
                'student_class' => $faker->randomElement(['Bestari', 'Cerdik', 'Amanah', 'Dedikasi']),
                'student_address' => $faker->address,
                'student_phone_number' => $faker->phoneNumber,
                'student_form' => $faker->numberBetween(1, 5), 
                'student_gender' => $faker->randomElement(['Male', 'Female']),
                'student_age' => $faker->numberBetween(13, 17), // Secondary School Age
                'student_DOB' => $faker->date('Y-m-d', '2000-01-01'), 
            ]);
        }
    }
}