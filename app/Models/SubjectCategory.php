<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubjectCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'order',
        'is_active',
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'category_id')->orderBy('name');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }
}
