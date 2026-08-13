<?php

use App\Support\CountryCurrency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tutor_registrations', function (Blueprint $table) {
            $table->string('currency', 3)->default('PKR')->after('hourly_rate');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->string('currency', 3)->nullable()->after('price_at_booking');
        });

        DB::table('tutor_registrations')->orderBy('id')->chunkById(100, function ($tutors) {
            foreach ($tutors as $tutor) {
                DB::table('tutor_registrations')
                    ->where('id', $tutor->id)
                    ->update(['currency' => CountryCurrency::forCountry($tutor->country)]);
            }
        });

        DB::table('bookings')->orderBy('id')->chunkById(100, function ($bookings) {
            foreach ($bookings as $booking) {
                $tutor = DB::table('tutor_registrations')->where('id', $booking->tutor_id)->first();
                $currency = $tutor
                    ? CountryCurrency::forCountry($tutor->country)
                    : 'PKR';

                DB::table('bookings')
                    ->where('id', $booking->id)
                    ->update(['currency' => $currency]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('currency');
        });

        Schema::table('tutor_registrations', function (Blueprint $table) {
            $table->dropColumn('currency');
        });
    }
};
