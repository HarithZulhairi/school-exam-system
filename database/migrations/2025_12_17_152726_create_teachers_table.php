<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id('teacher_id');
            
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('teacher_ic')->unique();
            $table->string('teacher_gender');
            $table->integer('teacher_age');
            $table->date('teacher_DOB');  
            $table->string('teacher_form_class')->nullable();
            $table->string('teacher_phone_number');
            $table->string('teacher_address');  
            $table->string('teacher_subjects');
            $table->string('teacher_status');
            $table->string('teacher_qualifications');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
