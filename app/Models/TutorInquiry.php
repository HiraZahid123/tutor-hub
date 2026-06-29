<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'tutor_id',
        'subjects',
        'hiring_type',
        'message',
        'status',
    ];

    protected $casts = [
        'subjects' => 'array',
        'tutor_id' => 'integer',
        'student_id' => 'integer',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function tutor()
    {
        return $this->belongsTo(TutorRegistration::class, 'tutor_id');
    }
}
