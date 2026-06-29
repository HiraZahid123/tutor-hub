<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subject extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'icon',
        'color',
    ];

    public function category()
    {
        return $this->belongsTo(SubjectCategory::class, 'category_id');
    }

    public function tutorRegistrations()
    {
        return $this->belongsToMany(TutorRegistration::class, 'tutor_registration_subject');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($subject) {
            if (empty($subject->slug)) {
                $subject->slug = Str::slug($subject->name);
            }
        });
    }
}
