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
        Schema::create('admins', function (Blueprint $table) {
            // Custom Primary Key
            $table->id('admin_id');
        
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('admin_age');
            $table->string('admin_phone_number')->nullable();
            $table->string('admin_position')->default('Administrator'); // e.g. Senior Admin, IT Support
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};