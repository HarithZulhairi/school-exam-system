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
        Schema::create('exams', function (Blueprint $table) {
            $table->id('exam_id');
            $table->foreignId('teacher_id')->constrained('teachers', 'teacher_id')->onDelete('cascade');
            
            // Basic Info
            $table->string('title');
            $table->text('exam_description')->nullable();
            
            // Classification
            $table->string('exam_subject');
            $table->string('exam_type');
            $table->string('exam_paper'); // Kertas 1, 2, etc.
            $table->integer('exam_form'); // Form 1-5
            
            // Timing
            $table->date('exam_date');
            $table->time('exam_start_time');
            $table->time('exam_end_time');
            $table->integer('duration_minutes'); // Calculated/Stored
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};