<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutorReview extends Model
{
    protected $fillable = [
        'tutor_id',
        'student_id',
        'rating',
        'comment',
        'is_verified_purchase',
    ];

    protected $casts = [
        'is_verified_purchase' => 'boolean',
    ];

    public function tutor()
    {
        return $this->belongsTo(TutorRegistration::class, 'tutor_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
