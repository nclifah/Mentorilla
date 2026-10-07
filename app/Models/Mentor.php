<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Mentor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'uuid',
        'specialization',
        'bio',
        'experience_years',
        'hourly_rate',
        'education',
        'photo',
        'status',
        'rating',
        'total_students'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($mentor) {
            if (empty($mentor->uuid)) {
                $mentor->uuid = Str::uuid();
            }
        });
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
