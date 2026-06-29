<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tutor_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // Step 1: Basic Info
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('country');
            $table->string('timezone');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->enum('tutoring_preference', ['online', 'home', 'both'])->default('both');
            $table->boolean('is_online')->default(true);
            $table->boolean('is_home')->default(true);
            $table->decimal('hourly_rate', 8, 2);

            // Step 2: Career & Education
            $table->string('program');
            $table->string('major');
            $table->string('university');
            $table->string('study_year_from');
            $table->string('study_year_to');
            $table->string('resume_path')->nullable();

            // Step 3: About Me
            $table->string('profile_image')->nullable();
            $table->text('bio')->nullable();
            $table->text('teaching_experience')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Admin / System
            $table->string('title')->nullable();
            $table->string('subject')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->enum('status', ['pending', 'interviewing', 'approved', 'rejected'])->default('pending');
            $table->text('internal_notes')->nullable();
            $table->text('verification_notes')->nullable();
            $table->dateTime('interview_at')->nullable();
            $table->integer('rating')->default(5);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tutor_registrations');
    }
};
