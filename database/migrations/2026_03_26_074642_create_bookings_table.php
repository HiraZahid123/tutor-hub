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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained('tutor_registrations')->onDelete('cascade');
            $table->foreignId('student_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('student_name')->nullable();
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->timestamp('reminder_sent_at')->nullable();
            $table->boolean('is_trial')->default(false);
            $table->decimal('price_at_booking', 8, 2)->nullable();
            $table->integer('duration_extension_minutes')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
