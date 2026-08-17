<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tutor_registrations', function (Blueprint $table) {
            // Add city (e.g. Lahore, Karachi) after country
            $table->string('city')->nullable()->after('country');
            // Add area (e.g. DHA, Gulberg) after city
            $table->string('area')->nullable()->after('city');
        });
    }

    public function down(): void
    {
        Schema::table('tutor_registrations', function (Blueprint $table) {
            $table->dropColumn(['city', 'area']);
        });
    }
};
