<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'tutor_payment_notified_at')) {
                $table->timestamp('tutor_payment_notified_at')->nullable()->after('payment_receipt');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'tutor_payment_notified_at')) {
                $table->dropColumn('tutor_payment_notified_at');
            }
        });
    }
};
