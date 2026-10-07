<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

     protected $fillable = [
        'uuid', 'user_id', 'mentor_id', 'booking_date',
        'start_time', 'end_time', 'duration_hours',
        'total_price', 'notes', 'status'
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($booking) {
            if (empty($booking->uuid)) {
                $booking->uuid = Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }
}
