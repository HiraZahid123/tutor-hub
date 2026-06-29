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
        Schema::create('tutor_inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('tutor_id')->constrained('tutor_registrations')->onDelete('cascade');
            $table->json('subjects');
            $table->string('hiring_type'); // 'home' or 'online'
            $table->text('message')->nullable();
            $table->string('status')->default('pending'); // 'pending', 'confirmed', 'rejected'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutor_inquiries');
    }
};
