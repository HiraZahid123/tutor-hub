<?php

namespace App\Models;

use App\Support\CountryCurrency;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    const STATUS_UNPAID = 'unpaid';
    const STATUS_PAID = 'paid';
    const STATUS_FAILED = 'failed';

    protected $fillable = [
        'tutor_id',
        'student_id',
        'student_name',
        'start_time',
        'end_time',
        'status',
        'payment_status',
        'payment_method',
        'transaction_id',
        'payment_receipt',
        'tutor_payment_notified_at',
        'is_trial',
        'price_at_booking',
        'currency',
        'duration_extension_minutes',
        'notes',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'tutor_payment_notified_at' => 'datetime',
        'is_trial' => 'boolean',
        'tutor_id' => 'integer',
        'student_id' => 'integer',
    ];

    public function tutor()
    {
        return $this->belongsTo(TutorRegistration::class, 'tutor_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function getDisplayCurrencyAttribute(): string
    {
        if ($this->currency) {
            return $this->currency;
        }

        if ($this->relationLoaded('tutor') && $this->tutor) {
            return $this->tutor->display_currency;
        }

        $tutor = $this->tutor;
        if ($tutor) {
            return $tutor->display_currency;
        }

        return 'PKR';
    }

    /**
     * Check if a student has any unpaid, completed, non-trial sessions.
     */
    public static function hasUnpaidSessions($studentId)
    {
        if (!$studentId) return false;

        return self::where('student_id', $studentId)
            ->whereIn('status', ['confirmed', 'scheduled', 'completed'])
            ->where('payment_status', self::STATUS_UNPAID)
            ->where('is_trial', false)
            ->where('end_time', '<', now())
            ->exists();
    }
}
