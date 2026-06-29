<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRequest extends Model
{
    protected $fillable = [
        'user_id',
        'student_name',
        'contact_method',
        'city',
        'grade',
        'subject',
        'schedule',
        'notes',
        'latitude',
        'longitude',
        'assigned_tutor_id',
        'preferred_tutor_ids',
        'tutoring_type',
        'status',
    ];

    protected $casts = [
        'preferred_tutor_ids' => 'array',
        'subject' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedTutor()
    {
        return $this->belongsTo(TutorRegistration::class, 'assigned_tutor_id');
    }
}
