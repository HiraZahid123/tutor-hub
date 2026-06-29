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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('subject_categories')->onDelete('set null');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable()->comment('FontAwesome class');
            $table->string('color')->nullable()->comment('Hex color code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
