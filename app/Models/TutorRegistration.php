<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutorRegistration extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'country',
        'timezone',
        'gender',
        'tutoring_preference',
        'is_online',
        'is_home',
        'hourly_rate',
        'program',
        'major',
        'university',
        'study_year_from',
        'study_year_to',
        'resume_path',
        'profile_image',
        'bio',
        'teaching_experience',
        'latitude',
        'longitude',
        'title',
        'subject',
        'is_approved',
        'status',
        'internal_notes',
        'verification_notes',
        'interview_at',
        'rating',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function availabilities()
    {
        return $this->hasMany(TutorAvailability::class, 'tutor_id');
    }
    
    public function reviews()
    {
        return $this->hasMany(TutorReview::class, 'tutor_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'tutor_registration_subject');
    }

    public function getAverageRatingAttribute()
    {
        return round($this->reviews()->avg('rating') ?: 0, 1);
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }

    protected $casts = [
        'is_approved' => 'boolean',
        'interview_at' => 'datetime',
        'is_online' => 'boolean',
        'is_home' => 'boolean',
    ];
}
