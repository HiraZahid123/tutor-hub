<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutorAvailability extends Model
{
    protected $fillable = [
        'tutor_id',
        'day_of_week',
        'start_time',
        'end_time',
        'slot_duration',
    ];

    public function tutor()
    {
        return $this->belongsTo(TutorRegistration::class, 'tutor_id');
    }
}
