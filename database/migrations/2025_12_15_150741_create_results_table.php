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
            $table->id();
            // Link to the student who took it
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Link to the exam they took
            $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
            $table->integer('score'); // e.g., 80
            $table->integer('total_questions'); // e.g., 100
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
