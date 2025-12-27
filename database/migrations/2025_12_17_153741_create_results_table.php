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
        Schema::create('results', function (Blueprint $table) {
            $table->id('result_id');
            $table->foreignId('student_id')->constrained('students', 'student_id')->onDelete('cascade');

            $table->foreignId('exam_id')->constrained('exams', 'exam_id')->onDelete('cascade');
            $table->integer('score'); 
            $table->integer('total_questions'); 
            $table->json('answers_json')->nullable(); // New field to store answers as JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
