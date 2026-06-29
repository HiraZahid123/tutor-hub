<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->unsignedBigInteger('assigned_tutor_id')->nullable();
            $table->foreign('assigned_tutor_id')->references('id')->on('tutor_registrations')->onDelete('set null');
            $table->json('preferred_tutor_ids')->nullable();
            $table->string('status')->default('pending');
            $table->string('student_name');
            $table->string('contact_method');
            $table->string('city');
            $table->string('grade');
            $table->string('subject');
            $table->string('schedule')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_requests');
    }
};
