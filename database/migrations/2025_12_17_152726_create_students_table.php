<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');
            
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('student_ic')->unique(); 
            $table->string('student_class');
            $table->string('student_phone_number');
            $table->string('student_address');  
            $table->integer('student_form');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};