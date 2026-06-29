<?php

namespace App\Models;

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
        'is_trial',
        'price_at_booking',
        'duration_extension_minutes',
        'notes',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
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
